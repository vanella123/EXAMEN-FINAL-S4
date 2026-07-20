<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitMobileMoney extends Migration
{
    public function up() 
    {
        // On active les clés étrangères pour SQLite
        $this->db->query("PRAGMA foreign_keys = ON;");

        // 1. Création des Tables
        $this->db->query("CREATE TABLE IF NOT EXISTS prefixes (
            id_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
            prefixe VARCHAR(3) NOT NULL UNIQUE,
            actif INTEGER NOT NULL DEFAULT 1,
            date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS administrateurs (
            id_admin INTEGER PRIMARY KEY AUTOINCREMENT,
            login VARCHAR(50) NOT NULL UNIQUE,
            mot_de_passe VARCHAR(255) NOT NULL,
            date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS types_operation (
            id_type_operation INTEGER PRIMARY KEY AUTOINCREMENT,
            code VARCHAR(20) NOT NULL UNIQUE,
            libelle VARCHAR(50) NOT NULL,
            frais_applicable INTEGER NOT NULL DEFAULT 1
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS baremes_frais (
            id_bareme INTEGER PRIMARY KEY AUTOINCREMENT,
            id_type_operation INTEGER NOT NULL,
            montant_min DECIMAL(12,2) NOT NULL,
            montant_max DECIMAL(12,2) NOT NULL,
            frais DECIMAL(12,2) NOT NULL,
            FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation) ON DELETE CASCADE
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS baremes_frais_historique (
            id_bareme_historique INTEGER PRIMARY KEY AUTOINCREMENT,
            id_bareme_origine INTEGER NOT NULL,
            id_type_operation INTEGER NOT NULL,
            montant_min DECIMAL(12,2) NOT NULL,
            montant_max DECIMAL(12,2) NOT NULL,
            frais DECIMAL(12,2) NOT NULL,
            date_modif DATETIME NOT NULL,
            FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation)
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS clients (
            id_client INTEGER PRIMARY KEY AUTOINCREMENT,
            numero_telephone VARCHAR(15) NOT NULL UNIQUE,
            date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );");

        $this->db->query("CREATE TABLE IF NOT EXISTS operations (
            id_operation INTEGER PRIMARY KEY AUTOINCREMENT,
            id_client INTEGER NOT NULL,
            id_client_destinataire INTEGER,
            id_type_operation INTEGER NOT NULL,
            montant DECIMAL(12,2) NOT NULL,
            date_operation DATETIME NOT NULL DEFAULT (STRFTIME('%Y-%m-%d %H:%M:%f','now')),
            FOREIGN KEY (id_client) REFERENCES clients(id_client),
            FOREIGN KEY (id_client_destinataire) REFERENCES clients(id_client),
            FOREIGN KEY (id_type_operation) REFERENCES types_operation(id_type_operation)
        );");

        // 2. Création des Index
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_operations_client ON operations(id_client);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_operations_destinataire ON operations(id_client_destinataire);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_operations_type ON operations(id_type_operation);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_baremes_type ON baremes_frais(id_type_operation);");

        // 3. Création des Triggers
        $this->db->query("CREATE TRIGGER IF NOT EXISTS trg_archive_bareme_update
            BEFORE UPDATE ON baremes_frais
            BEGIN
                INSERT INTO baremes_frais_historique (id_bareme_origine, id_type_operation, montant_min, montant_max, frais, date_modif)
                VALUES (OLD.id_bareme, OLD.id_type_operation, OLD.montant_min, OLD.montant_max, OLD.frais, STRFTIME('%Y-%m-%d %H:%M:%f','now'));
            END;");

        $this->db->query("CREATE TRIGGER IF NOT EXISTS trg_archive_bareme_delete
            BEFORE DELETE ON baremes_frais
            BEGIN
                INSERT INTO baremes_frais_historique (id_bareme_origine, id_type_operation, montant_min, montant_max, frais, date_modif)
                VALUES (OLD.id_bareme, OLD.id_type_operation, OLD.montant_min, OLD.montant_max, OLD.frais, STRFTIME('%Y-%m-%d %H:%M:%f','now'));
            END;");

        // 4. Création des Vues
        $this->db->query("CREATE VIEW IF NOT EXISTS v_operations_frais AS
            SELECT o.id_operation, o.id_client, o.id_client_destinataire, o.id_type_operation, o.montant, o.date_operation,
            COALESCE(
                (SELECT h.frais FROM baremes_frais_historique h WHERE h.id_type_operation = o.id_type_operation AND o.montant BETWEEN h.montant_min AND h.montant_max AND h.date_modif > o.date_operation ORDER BY h.date_modif ASC LIMIT 1),
                (SELECT b.frais FROM baremes_frais b WHERE b.id_type_operation = o.id_type_operation AND o.montant BETWEEN b.montant_min AND b.montant_max LIMIT 1),
                0
            ) AS frais FROM operations o;");

        $this->db->query("CREATE VIEW IF NOT EXISTS v_mouvements AS
            SELECT o.id_client AS id_client, o.id_operation, o.date_operation, t.libelle AS type_operation,
            CASE t.code WHEN 'DEPOT' THEN o.montant ELSE -(o.montant + o.frais) END AS montant_mouvement
            FROM v_operations_frais o JOIN types_operation t ON t.id_type_operation = o.id_type_operation
            UNION ALL
            SELECT o.id_client_destinataire AS id_client, o.id_operation, o.date_operation, 'Transfert recu' AS type_operation, o.montant AS montant_mouvement
            FROM v_operations_frais o WHERE o.id_client_destinataire IS NOT NULL;");

        $this->db->query("CREATE VIEW IF NOT EXISTS v_solde_clients AS
            SELECT c.id_client, c.numero_telephone, COALESCE(SUM(m.montant_mouvement), 0) AS solde
            FROM clients c LEFT JOIN v_mouvements m ON m.id_client = c.id_client GROUP BY c.id_client, c.numero_telephone;");

        $this->db->query("CREATE VIEW IF NOT EXISTS v_historique_client AS
            SELECT m.id_client, m.id_operation, m.date_operation, m.type_operation, m.montant_mouvement,
            SUM(m.montant_mouvement) OVER (PARTITION BY m.id_client ORDER BY m.date_operation, m.id_operation ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS solde_apres
            FROM v_mouvements m;");

        $this->db->query("CREATE VIEW IF NOT EXISTS v_gains_operateur AS
            SELECT t.code AS type_operation, COUNT(o.id_operation) AS nombre_operations, SUM(o.frais) AS total_frais
            FROM v_operations_frais o JOIN types_operation t ON t.id_type_operation = o.id_type_operation WHERE t.frais_applicable = 1 GROUP BY t.code;");
    }

    public function down()
    {
        // Suppression des éléments en cas de rollback (dans l'ordre inverse des dépendances)
        $this->db->query("DROP VIEW IF EXISTS v_gains_operateur;");
        $this->db->query("DROP VIEW IF EXISTS v_historique_client;");
        $this->db->query("DROP VIEW IF EXISTS v_solde_clients;");
        $this->db->query("DROP VIEW IF EXISTS v_mouvements;");
        $this->db->query("DROP VIEW IF EXISTS v_operations_frais;");
        $this->db->query("DROP TRIGGER IF EXISTS trg_archive_bareme_delete;");
        $this->db->query("DROP TRIGGER IF EXISTS trg_archive_bareme_update;");
        $this->forge->dropTable('operations', true);
        $this->forge->dropTable('clients', true);
        $this->forge->dropTable('baremes_frais_historique', true);
        $this->forge->dropTable('baremes_frais', true);
        $this->forge->dropTable('types_operation', true);
        $this->forge->dropTable('administrateurs', true);
        $this->forge->dropTable('prefixes', true);
    }
}