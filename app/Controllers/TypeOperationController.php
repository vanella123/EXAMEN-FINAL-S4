<?php

namespace App\Controllers;

use App\Models\TypeOperationModel;

class TypeOperationController extends BaseController
{
    protected $typeModel;

    public function __construct()
    {
        $this->typeModel = new TypeOperationModel();
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
            'types' => $this->typeModel->orderBy('code', 'ASC')->findAll()
        ];
        return view('admin/types_operations', $data);
    }

    public function create()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'code' => 'required|max_length[20]|is_unique[types_operation.code]',
            'libelle' => 'required|max_length[50]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $this->typeModel->insert([
            'code' => strtoupper(trim($this->request->getPost('code'))),
            'libelle' => trim($this->request->getPost('libelle')),
            'frais_applicable' => $this->request->getPost('frais_applicable') ? 1 : 0
        ]);

        return redirect()->to('/admin/types-operations')->with('success', 'Type d\'opération ajouté.');
    }

    public function update()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $id = $this->request->getPost('id_type_operation');
        $type = $this->typeModel->find($id);

        if (!$type) {
            return redirect()->back()->with('error', 'Type introuvable.');
        }

        $code = strtoupper(trim($this->request->getPost('code')));
        $validation = \Config\Services::validation();
        $rule = 'required|max_length[20]';
        if ($code !== $type['code']) {
            $rule .= '|is_unique[types_operation.code]';
        }
        $validation->setRules(['code' => $rule, 'libelle' => 'required|max_length[50]']);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $this->typeModel->update($id, [
            'code' => $code,
            'libelle' => trim($this->request->getPost('libelle')),
            'frais_applicable' => $this->request->getPost('frais_applicable') ? 1 : 0
        ]);

        return redirect()->to('/admin/types-operations')->with('success', 'Type d\'opération mis à jour.');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->checkSession()) return $redirect;

        if (!$this->typeModel->find($id)) {
            return redirect()->to('/admin/types-operations')->with('error', 'Type introuvable.');
        }

        $this->typeModel->delete($id);
        return redirect()->to('/admin/types-operations')->with('success', 'Type d\'opération supprimé.');
    }
}