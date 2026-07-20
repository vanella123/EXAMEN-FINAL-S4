<?php

namespace App\Services;

use CodeIgniter\Database\Config;

class AdminStatisticService
{
    protected $db;

    public function __construct()
    {
        $this->db = Config::connect();
    }

    public function getNombreClients(): int
    {
        return $this->db->table('clients')->countAllResults();
    }

    public function getNombreOperations(): int
    {
        return $this->db->table('operations')->countAllResults();
    }

    public function getTotalGains(): float
    {
        $result = $this->db->table('v_gains_operateur')
            ->select('SUM(total_frais) as total')
            ->get()
            ->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    public function getTotalTransferts(): float
    {
        $result = $this->db->table('operations o')
            ->join('types_operation t', 't.id_type_operation = o.id_type_operation')
            ->where('t.code', 'TRANSFERT')
            ->select('SUM(o.montant) as total')
            ->get()
            ->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    public function getDernieresOperations(int $limite = 10): array
    {
        return $this->db->table('v_operations_frais o')
            ->join('clients c', 'c.id_client = o.id_client')
            ->join('types_operation t', 't.id_type_operation = o.id_type_operation')
            ->select('c.numero_telephone, t.libelle as type_operation, o.montant, o.frais, o.date_operation')
            ->orderBy('o.date_operation', 'DESC')
            ->limit($limite)
            ->get()
            ->getResultArray();
    }

    public function getGainsParType(): array
    {
        return $this->db->table('v_gains_operateur')
            ->get()
            ->getResultArray();
    }

    public function getTotalGainsRetrait(): float
    {
        $result = $this->db->table('v_gains_operateur')
            ->where('type_operation', 'RETRAIT')
            ->select('SUM(total_frais) as total')
            ->get()
            ->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    public function getTotalGainsTransfert(): float
    {
        $result = $this->db->table('v_gains_operateur')
            ->where('type_operation', 'TRANSFERT')
            ->select('SUM(total_frais) as total')
            ->get()
            ->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    public function getSoldeTotalClients(): float
    {
        $result = $this->db->table('v_solde_clients')
            ->select('SUM(solde) as total')
            ->get()
            ->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    public function getNouveauxClients7Jours(): int
    {
        $date = date('Y-m-d H:i:s', strtotime('-7 days'));
        return $this->db->table('clients')
            ->where('date_creation >=', $date)
            ->countAllResults();
    }

    public function getDetailsGains(): array
    {
        return $this->db->table('v_gains_operateur')
            ->get()
            ->getResultArray();
    }

    /**
     * A) Gains internes (même opérateur) : retraits + transferts internes
     */
    public function getGainsOperateurInterne(): array
    {
        $sql = "
            SELECT
                op.libelle AS operateur,
                t.code AS type_operation,
                COUNT(o.id_operation) AS nombre_operations,
                COALESCE(SUM(vf.frais), 0) AS total_frais
            FROM operations o
            JOIN types_operation t ON t.id_type_operation = o.id_type_operation
            JOIN clients c ON c.id_client = o.id_client
            JOIN prefixes p ON SUBSTR(c.numero_telephone, 1, 3) = p.prefixe
            JOIN operateur op ON op.id_operateur = p.id_operateur
            LEFT JOIN v_operations_frais vf ON vf.id_operation = o.id_operation
            WHERE t.code IN ('RETRAIT', 'TRANSFERT')
              AND (
                  t.code = 'RETRAIT'
                  OR
                  (t.code = 'TRANSFERT' AND o.id_client_destinataire IS NOT NULL
                   AND EXISTS (
                       SELECT 1 FROM clients c2
                       JOIN prefixes p2 ON SUBSTR(c2.numero_telephone, 1, 3) = p2.prefixe
                       WHERE c2.id_client = o.id_client_destinataire
                       AND p2.id_operateur = p.id_operateur
                   ))
              )
            GROUP BY op.libelle, t.code
            ORDER BY op.libelle, t.code
        ";
        return $this->db->query($sql)->getResultArray();
    }

    /**
     * B) Transferts externes (opérateurs différents) avec commissions
     */
    public function getGainsAutresOperateurs(): array
    {
        return $this->db->table('v_transferts_externes')
            ->select('
                operateur_source,
                operateur_destinataire,
                COUNT(*) AS nombre_transferts,
                SUM(montant) AS montant_total,
                pourcentage_commission,
                SUM(montant_commission) AS total_commission
            ')
            ->groupBy('operateur_source, operateur_destinataire')
            ->orderBy('operateur_source, operateur_destinataire')
            ->get()
            ->getResultArray();
    }

    /**
     * C) Montants à envoyer à chaque opérateur (dette inter-opérateur)
     */
    public function getMontantsAEnvoyerOperateurs(): array
    {
        $sql = "
            SELECT
                v.operateur_destinataire,
                COUNT(*) AS nombre_transferts,
                SUM(v.montant) AS montant_total,
                SUM(v.montant_commission) AS total_commission
            FROM v_transferts_externes v
            GROUP BY v.operateur_destinataire
            ORDER BY v.operateur_destinataire
        ";
        return $this->db->query($sql)->getResultArray();
    }

    /**
     * Récupère le total des gains retrait (interne) pour le dashboard
     */
    public function getTotalGainsRetraitInterne(): float
    {
        $sql = "
            SELECT COALESCE(SUM(vf.frais), 0) AS total
            FROM operations o
            JOIN types_operation t ON t.id_type_operation = o.id_type_operation
            LEFT JOIN v_operations_frais vf ON vf.id_operation = o.id_operation
            WHERE t.code = 'RETRAIT'
        ";
        $result = $this->db->query($sql)->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }

    /**
     * Récupère le total des gains transfert interne pour le dashboard
     */
    public function getTotalGainsTransfertInterne(): float
    {
        $sql = "
            SELECT COALESCE(SUM(vf.frais), 0) AS total
            FROM operations o
            JOIN types_operation t ON t.id_type_operation = o.id_type_operation
            JOIN clients c ON c.id_client = o.id_client
            JOIN prefixes p ON SUBSTR(c.numero_telephone, 1, 3) = p.prefixe
            LEFT JOIN v_operations_frais vf ON vf.id_operation = o.id_operation
            WHERE t.code = 'TRANSFERT'
              AND o.id_client_destinataire IS NOT NULL
              AND EXISTS (
                  SELECT 1 FROM clients c2
                  JOIN prefixes p2 ON SUBSTR(c2.numero_telephone, 1, 3) = p2.prefixe
                  WHERE c2.id_client = o.id_client_destinataire
                  AND p2.id_operateur = p.id_operateur
              )
        ";
        $result = $this->db->query($sql)->getRowArray();
        return $result ? (float) $result['total'] : 0;
    }
}