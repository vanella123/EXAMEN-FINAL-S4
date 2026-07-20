<?php
namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\RESTful\ResourceController;

class ClientController extends ResourceController {
    
    // Créer un nouveau client
    public function creer() {
        $model = new ClientModel();
        $donnees = $this->request->getJSON(true);

        if (!$this->validate(['numero_telephone' => 'required|is_unique[clients.numero_telephone]'])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model->insert(['numero_telephone' => $donnees['numero_telephone']]);
        return $this->respondCreated(['message' => 'Client créé avec succès']);
    }

    // Récupérer le solde depuis la vue v_solde_clients
    public function obtenirSolde($id = null) {
        $db = \Config\Database::connect();
        
        $builder = $db->table('v_solde_clients');
        $client = $builder->where('id_client', $id)->get()->getRowArray();

        if (!$client) {
            return $this->failNotFound('Client introuvable');
        }

        return $this->respond($client);
    }

    // Récupérer l'historique complet depuis la vue v_historique_client
    public function obtenirHistorique($id = null) {
        $db = \Config\Database::connect();
        
        $builder = $db->table('v_historique_client');
        $historique = $builder->where('id_client', $id)
                              ->orderBy('date_operation', 'DESC')
                              ->get()
                              ->getResultArray();

        return $this->respond($historique);
    }
}