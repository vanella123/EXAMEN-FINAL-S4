<?php

namespace App\Controllers;

use App\Models\OperationModel;
use App\Models\ClientModel;

class OperationController extends BaseController
{
    protected $operationModel;
    protected $clientModel;

    public function __construct()
    {
        $this->operationModel = new OperationModel();
        $this->clientModel = new ClientModel();
    }

    /*
    |--------------------------------------------------------------------------
    | DEPOT
    |--------------------------------------------------------------------------
    */

    public function depot()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        return view('client/depot');
    }

    public function saveDepot()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        $this->operationModel->insert([
            'id_client' => session()->get('id_client'),
            'id_type_operation' => 1,
            'montant' => $montant
        ]);

        return redirect()
            ->to('/client/dashboard')
            ->with('success', 'Dépôt effectué avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | RETRAIT
    |--------------------------------------------------------------------------
    */

    public function retrait()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        return view('client/retrait');
    }

    public function saveRetrait()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $idClient = session()->get('id_client');
        $montant = (float)$this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        $db = \Config\Database::connect();

        $solde = $db->table('v_solde_clients')
                    ->where('id_client', $idClient)
                    ->get()
                    ->getRow();

        if (!$solde || $solde->solde < $montant) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        $this->operationModel->insert([
            'id_client' => $idClient,
            'id_type_operation' => 2,
            'montant' => $montant
        ]);

        return redirect()
            ->to('/client/dashboard')
            ->with('success', 'Retrait effectué avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSFERT
    |--------------------------------------------------------------------------
    */

    public function transfert()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        return view('client/transfert');
    }

    public function saveTransfert()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $idClient = session()->get('id_client');
        $numeroDest = trim($this->request->getPost('numero'));
        $montant = (float)$this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        // Recherche du destinataire
        $destinataire = $this->clientModel->findByNumero($numeroDest);

        if (!$destinataire) {
            return redirect()->back()->with('error', 'Destinataire introuvable.');
        }

        if ($destinataire['id_client'] == $idClient) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous transférer de l\'argent.');
        }

        $db = \Config\Database::connect();

        // Solde actuel
        $solde = $db->table('v_solde_clients')
                    ->where('id_client', $idClient)
                    ->get()
                    ->getRow();

        if (!$solde) {
            return redirect()->back()->with('error', 'Impossible de récupérer votre solde.');
        }

        // Frais du transfert
        $frais = $db->table('baremes_frais')
                    ->where('id_type_operation', 3)
                    ->where('montant_min <=', $montant)
                    ->where('montant_max >=', $montant)
                    ->get()
                    ->getRow();

        $montantTotal = $montant;

        if ($frais) {
            $montantTotal += $frais->frais;
        }

        if ($solde->solde < $montantTotal) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        // Enregistrement
        $this->operationModel->insert([
            'id_client' => $idClient,
            'id_client_destinataire' => $destinataire['id_client'],
            'id_type_operation' => 3,
            'montant' => $montant
        ]);

        return redirect()
            ->to('/client/dashboard')
            ->with('success', 'Transfert effectué avec succès.');
    }
}