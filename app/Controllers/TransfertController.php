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
        $inclureFrais = (bool) $this->request->getPost('inclure_frais');

        if (empty($destinataire)) {
            return redirect()->back()->with('error', 'Veuillez saisir le numéro du destinataire.');
        }

        $result = $this->operationService->effectuerTransfert(
            session()->get('id_client'),
            $destinataire,
            $montant,
            $inclureFrais
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/client/dashboard')->with('success', $result['message']);
    }

    public function saveMultiple()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $montantTotal = (float) $this->request->getPost('montant_total');
        $destinatairesStr = trim($this->request->getPost('destinataires'));
        $inclureFrais = (bool) $this->request->getPost('inclure_frais_multiple');

        if (empty($destinatairesStr)) {
            return redirect()->back()->with('error', 'Veuillez saisir au moins un destinataire.');
        }

        $numeros = explode("\n", $destinatairesStr);
        $numeros = array_map('trim', $numeros);
        $numeros = array_filter($numeros, fn($n) => !empty($n));

        if (count($numeros) < 1) {
            return redirect()->back()->with('error', 'Veuillez saisir au moins un destinataire.');
        }

        $result = $this->operationService->effectuerTransfertMultiple(
            session()->get('id_client'),
            $numeros,
            $montantTotal,
            $inclureFrais
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to('/client/dashboard')->with('success', $result['message']);
    }
}
