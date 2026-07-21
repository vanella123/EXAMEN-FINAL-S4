<?php

namespace App\Models;

use CodeIgniter\Model;

class PourcentageEpargneModel extends Model
{
    protected $table = 'pourcentage_epargne';
    protected $primaryKey = 'id_pourcentage_epargne';

    protected $allowedFields = [
        'id_client',
        'pourcentage'
    ];

    protected $returnType = 'array';


    /**
     * Retourne les commissions avec le nom de l'opérateur
     */
    public function getAvecClient()
    {
        return $this->select(
                    'pourcentage_epargne.*, clients.numero_telephone AS clients'
                )
                ->join(
                    'clients',
                    'clients.id_client = pourcentage_epargne.id_client'
                )
                ->orderBy('clients', 'ASC')
                ->findAll();
    }
}