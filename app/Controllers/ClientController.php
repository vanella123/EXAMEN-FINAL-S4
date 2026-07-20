<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Config;

class ClientController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Config::connect();
    }

    /**
     * Tableau de bord du client
     */
    public function dashboard()
    {
        // Vérifier que le client est connecté
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $idClient = session()->get('id_client');

        // Récupérer le solde du client
        $solde = $this->db->table('v_solde_clients')
            ->where('id_client', $idClient)
            ->get()
            ->getRowArray();

        // Les 10 dernières opérations
        $historique = $this->db->table('v_historique_client')
            ->where('id_client', $idClient)
            ->orderBy('date_operation', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $data = [
            'numero' => session()->get('numero'),
            'solde' => $solde['solde'] ?? 0,
            'historique' => $historique
        ];

        return view('client/dashboard', $data);
    }
}