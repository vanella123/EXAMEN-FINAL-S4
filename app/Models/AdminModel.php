<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'administrateurs';
    protected $primaryKey = 'id_admin';

    protected $allowedFields = [
        'login',
        'mot_de_passe'
    ];

    protected $returnType = 'array';

    public function findByLogin(string $login)
    {
        return $this->where('login', $login)->first();
    }
}