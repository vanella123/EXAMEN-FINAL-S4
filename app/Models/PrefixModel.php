<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id_prefixe';

    protected $allowedFields = [
        'prefixe',
        'actif',
        'id_operateur'
    ];

    protected $returnType = 'array';


    /**
     * Retourne tous les préfixes avec leur opérateur
     */
    public function getAvecOperateur()
    {
        return $this->select('prefixes.*, operateur.libelle AS operateur')
                    ->join('operateur', 'operateur.id_operateur = prefixes.id_operateur')
                    ->findAll();
    }


    /**
     * Vérifie si un préfixe est actif
     */
    public function estValide($numero)
    {
        // Les 3 premiers chiffres du numéro
        $prefixe = substr($numero, 0, 3);

        return $this->where('prefixe', $prefixe)
                    ->where('actif', 1)
                    ->first();
    }


    /**
     * Retourne tous les préfixes actifs
     */
    public function getActifs()
    {
        return $this->where('actif', 1)->findAll();
    }
}