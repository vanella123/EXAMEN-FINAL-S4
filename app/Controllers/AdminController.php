<?php
namespace App\Controllers;

use App\Models\BaremeFraisModel;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController {

    // Modifier un barème (Le Trigger SQLite se chargera de copier l'ancien dans l'historique)
    public function modifierBareme($id = null) {
        $model = new BaremeFraisModel();
        $donnees = $this->request->getJSON(true);

        if (!$model->find($id)) {
            return $this->failNotFound('Barème introuvable');
        }

        $model->update($id, [
            'montant_min' => $donnees['montant_min'],
            'montant_max' => $donnees['montant_max'],
            'frais'       => $donnees['frais']
        ]);

        return $this->respond(['message' => 'Barème mis à jour. L\'historique a été généré par la base de données.']);
    }

    // Voir les bénéfices accumulés via la vue v_gains_operateur
    public function obtenirGains() {
        $db = \Config\Database::connect();
        $gains = $db->table('v_gains_operateur')->get()->getResultArray();

        return $this->respond($gains);
    }
}
