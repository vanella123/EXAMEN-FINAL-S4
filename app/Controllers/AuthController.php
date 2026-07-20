<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\PrefixModel;

class AuthController extends BaseController
{
    protected $clientModel;
    protected $prefixModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->prefixModel = new PrefixModel();
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        return view('auth/login');
    }

    /**
     * Connexion automatique
     */
    public function login()
    {
        $numero = trim($this->request->getPost('numero'));

        if (empty($numero)) {
            return redirect()->back()->with('error', 'Veuillez saisir votre numéro.');
        }

        // Vérifie que le numéro contient exactement 10 chiffres
        if (!preg_match('/^[0-9]{10}$/', $numero)) {
            return redirect()->back()->with('error', 'Numéro invalide.');
        }

        // Recherche du client
        $client = $this->clientModel->findByNumero($numero);

        // Si le client n'existe pas
        if (!$client) {

            // Vérification du préfixe
            if (!$this->prefixModel->estValide($numero)) {
                return redirect()->back()->with('error', 'Préfixe non autorisé.');
            }

            // Création automatique
            $id = $this->clientModel->insert([
                'numero_telephone' => $numero
            ]);

            $client = $this->clientModel->find($id);
        }

        // Création de la session
        session()->set([
            'id_client' => $client['id_client'],
            'numero' => $client['numero_telephone'],
            'connecte' => true
        ]);

        return redirect()->to('/client/dashboard');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}