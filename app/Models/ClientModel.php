<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $allowedFields = [
        'numero_telephone'
    ];

    protected $returnType = 'array';

    /**
     * Recherche un client par son numéro
     */
    public function findByNumero($numero)
    {
        return $this->where('numero_telephone', $numero)->first();
    }
}