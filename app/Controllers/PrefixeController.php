<?php

namespace App\Controllers;

use App\Models\PrefixModel;

class PrefixeController extends BaseController
{
    protected $prefixModel;

    public function __construct()
    {
        $this->prefixModel = new PrefixModel();
    }

    private function checkSession()
    {
        if (!session()->get('role')) {
            return redirect()->to('/admin/login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $data = [
            'prefixes' => $this->prefixModel->orderBy('prefixe', 'ASC')->findAll()
        ];
        return view('admin/prefixes', $data);
    }

    public function create()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'prefixe' => 'required|min_length[2]|max_length[3]|is_unique[prefixes.prefixe]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $this->prefixModel->insert([
            'prefixe' => trim($this->request->getPost('prefixe')),
            'actif' => $this->request->getPost('actif') ? 1 : 0
        ]);

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function update()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $id = $this->request->getPost('id_prefixe');
        $prefixe = trim($this->request->getPost('prefixe'));

        $existing = $this->prefixModel->find($id);
        if (!$existing) {
            return redirect()->back()->with('error', 'Préfixe introuvable.');
        }

        $validation = \Config\Services::validation();
        $rule = 'required|min_length[2]|max_length[3]';
        if ($prefixe !== $existing['prefixe']) {
            $rule .= '|is_unique[prefixes.prefixe]';
        }
        $validation->setRules(['prefixe' => $rule]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $this->prefixModel->update($id, [
            'prefixe' => $prefixe,
            'actif' => $this->request->getPost('actif') ? 1 : 0
        ]);

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe mis à jour.');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->checkSession()) return $redirect;

        if (!$this->prefixModel->find($id)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Préfixe introuvable.');
        }

        $this->prefixModel->delete($id);
        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe supprimé.');
    }
}