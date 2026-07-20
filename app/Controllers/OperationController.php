<?php

namespace App\Controllers;

use App\Models\OperationModel;

class OperationController extends BaseController
{
    protected $operationModel;

    public function __construct()
    {
        $this->operationModel = new OperationModel();
    }

    /**
     * Formulaire de dépôt
     */
    public function depot()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        return view('client/depot');
    }

    /**
     * Enregistrer le dépôt
     */
    public function saveDepot()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        // DEPOT = id_type_operation 1
        $this->operationModel->insert([
            'id_client' => session()->get('id_client'),
            'id_type_operation' => 1,
            'montant' => $montant
        ]);

        return redirect()
            ->to('/client/dashboard')
            ->with('success', 'Dépôt effectué avec succès.');
    }
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
    $montant = (float) $this->request->getPost('montant');

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

    $db->table('operations')->insert([
        'id_client' => $idClient,
        'id_type_operation' => 2,
        'montant' => $montant
    ]);

    return redirect()
        ->to('/client/dashboard')
        ->with('success', 'Retrait effectué avec succès.');
}

}