<?php

namespace App\Controllers;

use App\Services\OperationService;

class TransfertController extends BaseController
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

    public function index()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $data = [
            'numero' => session()->get('numero'),
            'solde' => $this->operationService->getSolde(session()->get('id_client'))
        ];
        return view('client/transfert', $data);
    }

    public function save()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $montant = (float) $this->request->getPost('montant');
        $destinataire = trim($this->request->getPost('destinataire'));

        if (empty($destinataire)) {
            return redirect()->back()->with('error', 'Veuillez saisir le numéro du destinataire.');
        }

        $result = $this->operationService->effectuerTransfert(
            session()->get('id_client'),
            $destinataire,
            $montant
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/client/dashboard')->with('success', $result['message']);
    }
}