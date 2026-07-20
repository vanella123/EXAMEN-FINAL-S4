<?php

namespace App\Controllers;

use App\Services\AdminStatisticService;

class GainController extends BaseController
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

        $gains = $this->statService->getDetailsGains();
        $totalGains = $this->statService->getTotalGains();
        $gainsRetrait = $this->statService->getTotalGainsRetrait();
        $gainsTransfert = $this->statService->getTotalGainsTransfert();

        $data = [
            'gains' => $gains,
            'total_gains' => $totalGains,
            'gains_retrait' => $gainsRetrait,
            'gains_transfert' => $gainsTransfert
        ];

        return view('admin/gains', $data);
    }
}