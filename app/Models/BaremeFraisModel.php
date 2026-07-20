<?php
namespace App\Models;
use CodeIgniter\Model;

class BaremeFraisModel extends Model {
    protected $table            = 'baremes_frais';
    protected $primaryKey       = 'id_bareme';
    protected $allowedFields    = ['id_type_operation', 'montant_min', 'montant_max', 'frais'];
    protected $returnType       = 'array';

    public function getFrais(int $idTypeOperation, float $montant): float
    {
        $bareme = $this->where('id_type_operation', $idTypeOperation)
                       ->where('montant_min <=', $montant)
                       ->where('montant_max >=', $montant)
                       ->first();
        return $bareme ? (float) $bareme['frais'] : 0;
    }
}