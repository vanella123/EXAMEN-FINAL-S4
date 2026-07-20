PRAGMA foreign_keys = OFF;

DROP VIEW IF EXISTS v_gains_operateur;
DROP VIEW IF EXISTS v_historique_client;
DROP VIEW IF EXISTS v_solde_clients;
DROP VIEW IF EXISTS v_mouvements;
DROP VIEW IF EXISTS v_operations_frais;

DROP TRIGGER IF EXISTS trg_archive_bareme_update;
DROP TRIGGER IF EXISTS trg_archive_bareme_delete;

DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS baremes_frais_historique;
DROP TABLE IF EXISTS baremes_frais;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS types_operation;
DROP TABLE IF EXISTS administrateurs;
DROP TABLE IF EXISTS prefixes;

PRAGMA foreign_keys = ON;


--- Version 2
-- TABLE OPERATEUR
DROP TABLE IF EXISTS operateur;

CREATE TABLE operateur (
    id_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(50) NOT NULL UNIQUE
);

-- TABLE COMMISSION OPERATEUR
DROP TABLE IF EXISTS commission_operateur;

CREATE TABLE commission_operateur (
    id_commission_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur INTEGER NOT NULL,
    pourcentage_commission DECIMAL(5,2) NOT NULL,

    FOREIGN KEY (id_operateur)
        REFERENCES operateur(id_operateur)
);

-- TABLE PREFIXES
DROP TABLE IF EXISTS prefixes;

CREATE TABLE prefixes (
    id_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(3) NOT NULL UNIQUE,
    actif INTEGER NOT NULL DEFAULT 1,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_operateur INTEGER NOT NULL,

    FOREIGN KEY (id_operateur)
        REFERENCES operateur(id_operateur)
);

-- 2. ADMINISTRATEURS
DROP TABLE IF EXISTS administrateurs;
CREATE TABLE administrateurs (
    id_admin      INTEGER PRIMARY KEY AUTOINCREMENT,
    login         VARCHAR(50)  NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL,
    date_creation DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 3. TYPES_OPERATION
DROP TABLE IF EXISTS types_operation;
CREATE TABLE types_operation (
    id_type_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    code              VARCHAR(20) NOT NULL UNIQUE, -- DEPOT, RETRAIT, TRANSFERT
    libelle           VARCHAR(50) NOT NULL,
    frais_applicable  INTEGER     NOT NULL DEFAULT 1
);


DROP TABLE IF EXISTS baremes_frais;
CREATE TABLE baremes_frais (
    id_bareme         INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    montant_min       DECIMAL(12,2) NOT NULL,
    montant_max       DECIMAL(12,2) NOT NULL,
    frais             DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation)
        ON DELETE CASCADE
);


DROP TABLE IF EXISTS baremes_frais_historique;
CREATE TABLE baremes_frais_historique (
    id_bareme_historique INTEGER PRIMARY KEY AUTOINCREMENT,
    id_bareme_origine    INTEGER NOT NULL,
    id_type_operation    INTEGER NOT NULL,
    montant_min          DECIMAL(12,2) NOT NULL,
    montant_max          DECIMAL(12,2) NOT NULL,
    frais                DECIMAL(12,2) NOT NULL,
    date_modif            DATETIME NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation)
);


DROP TRIGGER IF EXISTS trg_archive_bareme_update;
CREATE TRIGGER trg_archive_bareme_update
BEFORE UPDATE ON baremes_frais
BEGIN
    INSERT INTO baremes_frais_historique
        (id_bareme_origine, id_type_operation, montant_min, montant_max, frais, date_modif)
    VALUES
        (OLD.id_bareme, OLD.id_type_operation, OLD.montant_min, OLD.montant_max, OLD.frais, STRFTIME('%Y-%m-%d %H:%M:%f','now'));
END;

-- Archive automatiquement avant toute suppression
DROP TRIGGER IF EXISTS trg_archive_bareme_delete;
CREATE TRIGGER trg_archive_bareme_delete
BEFORE DELETE ON baremes_frais
BEGIN
    INSERT INTO baremes_frais_historique
        (id_bareme_origine, id_type_operation, montant_min, montant_max, frais, date_modif)
    VALUES
        (OLD.id_bareme, OLD.id_type_operation, OLD.montant_min, OLD.montant_max, OLD.frais, STRFTIME('%Y-%m-%d %H:%M:%f','now'));
END;

-- 6. CLIENTS

DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
    id_client        INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    date_creation    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 7. OPERATIONS
DROP TABLE IF EXISTS operations;
CREATE TABLE operations (
    id_operation           INTEGER PRIMARY KEY AUTOINCREMENT,
    id_client               INTEGER NOT NULL,           -- client qui initie l'operation
    id_client_destinataire  INTEGER,                    -- rempli uniquement pour un transfert
    id_type_operation       INTEGER NOT NULL,
    montant                 DECIMAL(12,2) NOT NULL,
    date_operation           DATETIME NOT NULL DEFAULT (STRFTIME('%Y-%m-%d %H:%M:%f','now')),
    FOREIGN KEY (id_client) REFERENCES clients(id_client),
    FOREIGN KEY (id_client_destinataire) REFERENCES clients(id_client),
    FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation)
);

-- INDEXES
CREATE INDEX idx_operations_client ON operations(id_client);
CREATE INDEX idx_operations_destinataire ON operations(id_client_destinataire);
CREATE INDEX idx_operations_type ON operations(id_type_operation);
CREATE INDEX idx_baremes_type ON baremes_frais(id_type_operation);

-- DONNEES DE BASE

INSERT INTO administrateurs (login, mot_de_passe) VALUES ('admin', 'password');

INSERT INTO prefixes (prefixe) VALUES ('033');
INSERT INTO prefixes (prefixe) VALUES ('037');

INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('DEPOT', 'Depot', 0);
INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('RETRAIT', 'Retrait', 1);
INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('TRANSFERT', 'Transfert', 1);

-- Bareme RETRAIT (id_type_operation = 2)
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 100, 5000, 100);
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 5001, 15000, 300);
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 15001, 50000, 700);

-- Bareme TRANSFERT (id_type_operation = 3)
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 100, 5000, 50);
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 5001, 15000, 150);
INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 15001, 50000, 400);

INSERT INTO clients (numero_telephone) VALUES ('0331234567');
INSERT INTO clients (numero_telephone) VALUES ('0377654321');

-- VUES

DROP VIEW IF EXISTS v_operations_frais;
CREATE VIEW v_operations_frais AS
SELECT 
    o.id_operation,
    o.id_client,
    o.id_client_destinataire,
    o.id_type_operation,
    o.montant,
    o.date_operation,
    COALESCE(
        (SELECT h.frais FROM baremes_frais_historique h
         WHERE h.id_type_operation = o.id_type_operation
           AND o.montant BETWEEN h.montant_min AND h.montant_max
           AND h.date_modif > o.date_operation
         ORDER BY h.date_modif ASC
         LIMIT 1),
        (SELECT b.frais FROM baremes_frais b
         WHERE b.id_type_operation = o.id_type_operation
           AND o.montant BETWEEN b.montant_min AND b.montant_max
         LIMIT 1),
        0
    ) AS frais
FROM operations o;

DROP VIEW IF EXISTS v_mouvements;
CREATE VIEW v_mouvements AS
SELECT
    o.id_client AS id_client,
    o.id_operation,
    o.date_operation,
    t.libelle AS type_operation,
    CASE t.code WHEN 'DEPOT' THEN o.montant ELSE -(o.montant + o.frais) END AS montant_mouvement
FROM v_operations_frais o 
JOIN types_operation t ON t.id_type_operation = o.id_type_operation

UNION ALL

SELECT
    o.id_client_destinataire AS id_client,
    o.id_operation,
    o.date_operation,
    'Transfert recu' AS type_operation,
    o.montant AS montant_mouvement
FROM v_operations_frais o
WHERE o.id_client_destinataire IS NOT NULL;

-- Solde de chaque client, 100% calcule depuis 'operations'
DROP VIEW IF EXISTS v_solde_clients;
CREATE VIEW v_solde_clients AS
SELECT
    c.id_client,
    c.numero_telephone,
    COALESCE(SUM(m.montant_mouvement), 0) AS solde
FROM clients c 
LEFT JOIN v_mouvements m ON m.id_client = c.id_client
GROUP BY c.id_client, c.numero_telephone;


DROP VIEW IF EXISTS v_historique_client;
CREATE VIEW v_historique_client AS
SELECT
    m.id_client,
    m.id_operation,
    m.date_operation,
    m.type_operation,
    m.montant_mouvement,
    SUM(m.montant_mouvement) OVER (
        PARTITION BY m.id_client
        ORDER BY m.date_operation, m.id_operation
        ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
    ) AS solde_apres
FROM v_mouvements m;

DROP VIEW IF EXISTS v_gains_operateur;
CREATE VIEW v_gains_operateur AS
SELECT
    t.code AS type_operation,
    COUNT(o.id_operation) AS nombre_operations,
    SUM(o.frais) AS total_frais
FROM v_operations_frais o
JOIN types_operation t ON t.id_type_operation = o.id_type_operation
WHERE t.frais_applicable = 1
GROUP BY t.code;

