<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table = 'promotion';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pourcentage'
    ];

    protected $returnType = 'array';


    /**
     * Retourne les commissions avec le nom de l'opérateur
     */
    public function getPromotion()
    {
        return $this->findAll();
                
    }
}