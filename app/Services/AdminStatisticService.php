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
}