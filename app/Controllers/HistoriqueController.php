<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;

class HistoriqueController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Config::connect();
    }

    public function index()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }

        $idClient = session()->get('id_client');

        $operations = $this->db->table('v_historique_client')
            ->where('id_client', $idClient)
            ->orderBy('date_operation', 'DESC')
            ->orderBy('id_operation', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'numero' => session()->get('numero'),
            'operations' => $operations
        ];

        return view('client/historique', $data);
    }
}