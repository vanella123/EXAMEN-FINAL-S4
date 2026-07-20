<?php

namespace App\Controllers;

use App\Models\AdminModel;

class AdminAuthController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        return view('admin/login');
    }

    public function login()
    {
        $login = trim($this->request->getPost('login'));
        $password = $this->request->getPost('mot_de_passe');

        if (empty($login) || empty($password)) {
            return redirect()->back()->with('error', 'Veuillez saisir vos identifiants.');
        }

        $admin = $this->adminModel->findByLogin($login);

        if (!$admin || $password !== $admin['mot_de_passe']) {
            return redirect()->back()->with('error', 'Identifiants incorrects.');
        }

        session()->set([
            'id_admin' => $admin['id_admin'],
            'login' => $admin['login'],
            'role' => 'admin'
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}