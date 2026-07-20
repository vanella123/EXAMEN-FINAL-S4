<?php
namespace App\Models;
use CodeIgniter\Model;

class OperationModel extends Model {
    protected $table            = 'operations';
    protected $primaryKey       = 'id_operation';
    protected $allowedFields    = ['id_client', 'id_client_destinataire', 'id_type_operation', 'montant'];
    protected $returnType       = 'array';
}