<?php

namespace App\Controllers;

use App\Services\OperationService;

class OperationController extends BaseController
{
    protected $operationService;

    public function __construct()
    {
        $this->operationService = new OperationService();
    }

    private function checkSession()
    {
        if (!session()->get('connecte')) {
            return redirect()->to('/login');
        }
        return null;
    }

    public function depot()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $data = [
            'numero' => session()->get('numero'),
            'solde' => $this->operationService->getSolde(session()->get('id_client'))
        ];
        return view('client/depot', $data);
    }

    public function saveDepot()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $montant = (float) $this->request->getPost('montant');
        $result = $this->operationService->effectuerDepot(session()->get('id_client'), $montant);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/client/dashboard')->with('success', $result['message']);
    }

    public function retrait()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $data = [
            'numero' => session()->get('numero'),
            'solde' => $this->operationService->getSolde(session()->get('id_client'))
        ];
        return view('client/retrait', $data);
    }

    public function saveRetrait()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $montant = (float) $this->request->getPost('montant');
        $result = $this->operationService->effectuerRetrait(session()->get('id_client'), $montant);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/client/dashboard')->with('success', $result['message']);
    }

    // public function saveTransfert(){
    //     if ($redirect = $this->checkSession()) return $redirect;
    //     $montant_transferer = 

    // }
}