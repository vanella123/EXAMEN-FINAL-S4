<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';

    protected $primaryKey = 'id_client';

    protected $returnType = 'array';

    protected $allowedFields = [
        'numero_telephone'
    ];

    /**
     * Recherche un client par son numéro
     */
    public function findByNumero($numero)
    {
        return $this->where('numero_telephone', $numero)->first();
    }

    /**
     * Retourne le solde actuel d'un client
     */
    public function getSolde($idClient)
    {
        return $this->db
            ->table('v_solde_clients')
            ->where('id_client', $idClient)
            ->get()
            ->getRowArray();
    }

    /**
     * Retourne l'historique des opérations d'un client
     */
    public function getHistorique($idClient, $limit = 10)
    {
        return $this->db
            ->table('v_historique_client')
            ->where('id_client', $idClient)
            ->orderBy('date_operation', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}