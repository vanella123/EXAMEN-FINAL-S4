<?php
namespace App\Models;
use CodeIgniter\Model;

class BaremeFraisModel extends Model {
    protected $table            = 'baremes_frais';
    protected $primaryKey       = 'id_bareme';
    protected $allowedFields    = ['id_type_operation', 'montant_min', 'montant_max', 'frais'];
    protected $returnType       = 'array';
}