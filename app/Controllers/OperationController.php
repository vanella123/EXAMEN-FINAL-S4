<?php
namespace App\Controllers;

use App\Models\OperationModel;
use CodeIgniter\RESTful\ResourceController;

class OperationController extends ResourceController {

    public function effectuer() {
        $db = \Config\Database::connect();
        $operationModel = new OperationModel();
        
        $donnees = $this->request->getJSON(true);
        $idClient = $donnees['id_client'];
        $codeType = $donnees['code_type']; // 'DEPOT', 'RETRAIT', 'TRANSFERT'
        $montant  = $donnees['montant'];
        $idDest   = $donnees['id_client_destinataire'] ?? null;

        // 1. Trouver le type d'opération
        $typeOp = $db->table('types_operation')->where('code', $codeType)->get()->getRowArray();
        if (!$typeOp) {
            return $this->fail('Type d\'opération invalide.');
        }

        // 2. Si RETRAIT ou TRANSFERT, vérifier le solde requis (Montant + Frais théoriques)
        if ($codeType === 'RETRAIT' || $codeType === 'TRANSFERT') {
            // Récupérer le solde actuel du client depuis la vue
            $soldeClient = $db->table('v_solde_clients')->where('id_client', $idClient)->get()->getRowArray();
            $soldeActuel = $soldeClient ? (float)$soldeClient['solde'] : 0.0;

            // Simuler le frais qui va s'appliquer via le barème actif
            $bareme = $db->table('baremes_frais')
                         ->where('id_type_operation', $typeOp['id_type_operation'])
                         ->where("$montant BETWEEN montant_min AND montant_max")
                         ->get()
                         ->getRowArray();

            $frais = $bareme ? (float)$bareme['frais'] : 0.0;
            $coutTotal = $montant + $frais;

            if ($soldeActuel < $coutTotal) {
                return $this->fail('Solde insuffisant pour couvrir le montant et les frais.');
            }
        }

        // 3. Insérer l'opération (L'avantage de votre architecture SQL : tout se recalcule tout seul !)
        $nouvelleOp = [
            'id_client'              => $idClient,
            'id_client_destinataire' => ($codeType === 'TRANSFERT') ? $idDest : null,
            'id_type_operation'      => $typeOp['id_type_operation'],
            'montant'                => $montant
        ];

        $operationModel->insert($nouvelleOp);

        return $this->respondCreated(['message' => 'Opération validée et enregistrée.']);
    }
}