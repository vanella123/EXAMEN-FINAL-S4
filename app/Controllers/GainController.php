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

        // V2: gains internes et externes
        $gainsInternes = $this->statService->getGainsOperateurInterne();
        $gainsExternes = $this->statService->getGainsAutresOperateurs();

        $data = [
            'gains' => $gains,
            'total_gains' => $totalGains,
            'gains_retrait' => $gainsRetrait,
            'gains_transfert' => $gainsTransfert,
            'gains_internes' => $gainsInternes,
            'gains_externes' => $gainsExternes
        ];

        return view('admin/gains', $data);
    }
}
