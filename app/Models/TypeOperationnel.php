<?php
namespace App\Models;
use CodeIgniter\Model;

class TypeOperationModel extends Model {
    protected $table            = 'types_operation';
    protected $primaryKey       = 'id_type_operation';
    protected $allowedFields    = ['code', 'libelle', 'frais_applicable'];
    protected $returnType       = 'array';
}