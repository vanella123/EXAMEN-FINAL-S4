<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;

class CompteController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Config::connect();
    }

    public function index()
    {
        if (!session()->get('role')) {
            return redirect()->to('/admin/login');
        }

        $search = trim($this->request->getGet('search'));

        $builder = $this->db->table('v_solde_clients');
        $builder->select('v_solde_clients.*, clients.date_creation')
                ->join('clients', 'clients.id_client = v_solde_clients.id_client');

        if (!empty($search)) {
            $builder->like('v_solde_clients.numero_telephone', $search);
        }

        $builder->orderBy('clients.date_creation', 'DESC');

        $data = [
            'clients' => $builder->get()->getResultArray(),
            'search' => $search,
            'total_clients' => $this->db->table('clients')->countAllResults(),
            'solde_total' => 0,
            'nouveaux_7j' => 0
        ];

        $soldeResult = $this->db->table('v_solde_clients')
            ->select('SUM(solde) as total')
            ->get()
            ->getRowArray();
        $data['solde_total'] = $soldeResult ? (float) $soldeResult['total'] : 0;

        $date = date('Y-m-d H:i:s', strtotime('-7 days'));
        $data['nouveaux_7j'] = $this->db->table('clients')
            ->where('date_creation >=', $date)
            ->countAllResults();

        return view('admin/comptes', $data);
    }
}