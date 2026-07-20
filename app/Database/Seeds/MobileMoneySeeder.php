<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MobileMoneySeeder extends Seeder
{
    public function run()
    {
        // 1. Insertion de l'administrateur
        // Note : En production, remplace 'CHANGE_ME_HASH' par un mot de passe haché avec password_hash()
        $this->db->query("INSERT INTO administrateurs (login, mot_de_passe) VALUES ('admin', 'CHANGE_ME_HASH');");

        // 2. Insertion des préfixes
        $this->db->query("INSERT INTO prefixes (prefixe) VALUES ('033');");
        $this->db->query("INSERT INTO prefixes (prefixe) VALUES ('037');");

        // 3. Insertion des types d'opérations
        $this->db->query("INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('DEPOT', 'Depot', 0);");
        $this->db->query("INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('RETRAIT', 'Retrait', 1);");
        $this->db->query("INSERT INTO types_operation (code, libelle, frais_applicable) VALUES ('TRANSFERT', 'Transfert', 1);");

        // 4. Insertion des barèmes pour les RETRAITS (id_type_operation = 2)
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 100, 5000, 100);");
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 5001, 15000, 300);");
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (2, 15001, 50000, 700);");

        // 5. Insertion des barèmes pour les TRANSFERTS (id_type_operation = 3)
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 100, 5000, 50);");
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 5001, 15000, 150);");
        $this->db->query("INSERT INTO baremes_frais (id_type_operation, montant_min, montant_max, frais) VALUES (3, 15001, 50000, 400);");

        // 6. Insertion des clients de test
        $this->db->query("INSERT INTO clients (numero_telephone) VALUES ('0331234567');");
        $this->db->query("INSERT INTO clients (numero_telephone) VALUES ('0377654321');");
    }
}