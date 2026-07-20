<?php

namespace App\Controllers;

use App\Services\AdminStatisticService;

class AdminDashboardController extends BaseController
{
    protected $statService;

    public function __construct()
    {
        $this->statService = new AdminStatisticService();
    }

    public function index()
    {
        if (!session()->get('role')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'total_clients' => $this->statService->getNombreClients(),
            'total_operations' => $this->statService->getNombreOperations(),
            'total_gains' => $this->statService->getTotalGains(),
            'total_transferts' => $this->statService->getTotalTransferts(),
            'dernieres_operations' => $this->statService->getDernieresOperations(10),
            'gains_retrait' => $this->statService->getTotalGainsRetrait(),
            'gains_transfert' => $this->statService->getTotalGainsTransfert()
        ];

        return view('admin/dashboard', $data);
    }
}