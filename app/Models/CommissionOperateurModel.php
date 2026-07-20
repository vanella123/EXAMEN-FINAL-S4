<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionOperateurModel extends Model
{
    protected $table = 'commission_operateur';
    protected $primaryKey = 'id_commission_operateur';

    protected $allowedFields = [
        'id_operateur',
        'pourcentage_commission'
    ];

    protected $returnType = 'array';


    /**
     * Retourne les commissions avec le nom de l'opérateur
     */
    public function getAvecOperateur()
    {
        return $this->select(
                    'commission_operateur.*, operateur.libelle AS operateur'
                )
                ->join(
                    'operateur',
                    'operateur.id_operateur = commission_operateur.id_operateur'
                )
                ->orderBy('operateur', 'ASC')
                ->findAll();
    }
}