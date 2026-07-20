<?php

namespace App\Controllers;

use App\Services\AdminStatisticService;

class MontantController extends BaseController
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

        $montants = $this->statService->getMontantsAEnvoyerOperateurs();

        $totalTransferts = array_sum(array_column($montants, 'nombre_transferts'));
        $totalMontant = array_sum(array_column($montants, 'montant_total'));
        $totalCommission = array_sum(array_column($montants, 'total_commission'));

        $data = [
            'montants' => $montants,
            'total_transferts' => $totalTransferts,
            'total_montant' => $totalMontant,
            'total_commission' => $totalCommission
        ];

        return view('admin/montants', $data);
    }
}
