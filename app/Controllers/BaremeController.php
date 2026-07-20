<?php

namespace App\Controllers;

use App\Models\BaremeFraisModel;
use App\Models\TypeOperationModel;

class BaremeController extends BaseController
{
    protected $baremeModel;
    protected $typeModel;

    public function __construct()
    {
        $this->baremeModel = new BaremeFraisModel();
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

        $baremes = $this->baremeModel
            ->select('baremes_frais.*, types_operation.code, types_operation.libelle')
            ->join('types_operation', 'types_operation.id_type_operation = baremes_frais.id_type_operation')
            ->orderBy('types_operation.code', 'ASC')
            ->orderBy('baremes_frais.montant_min', 'ASC')
            ->findAll();

        $types = $this->typeModel->findAll();

        $data = [
            'baremes' => $baremes,
            'types' => $types
        ];
        return view('admin/baremes', $data);
    }

    public function create()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_type_operation' => 'required|numeric',
            'montant_min' => 'required|numeric|greater_than[-1]',
            'montant_max' => 'required|numeric',
            'frais' => 'required|numeric|greater_than_equal_to[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');

        if ($montantMin >= $montantMax) {
            return redirect()->back()->with('error', 'Le montant minimum doit être inférieur au montant maximum.');
        }

        $this->baremeModel->insert([
            'id_type_operation' => $this->request->getPost('id_type_operation'),
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => (float) $this->request->getPost('frais')
        ]);

        return redirect()->to('/admin/baremes')->with('success', 'Barème ajouté.');
    }

    public function update()
    {
        if ($redirect = $this->checkSession()) return $redirect;

        $id = $this->request->getPost('id_bareme');
        $bareme = $this->baremeModel->find($id);

        if (!$bareme) {
            return redirect()->back()->with('error', 'Barème introuvable.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_type_operation' => 'required|numeric',
            'montant_min' => 'required|numeric|greater_than[-1]',
            'montant_max' => 'required|numeric',
            'frais' => 'required|numeric|greater_than_equal_to[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');

        if ($montantMin >= $montantMax) {
            return redirect()->back()->with('error', 'Le montant minimum doit être inférieur au montant maximum.');
        }

        $this->baremeModel->update($id, [
            'id_type_operation' => $this->request->getPost('id_type_operation'),
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => (float) $this->request->getPost('frais')
        ]);

        return redirect()->to('/admin/baremes')->with('success', 'Barème mis à jour.');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->checkSession()) return $redirect;

        if (!$this->baremeModel->find($id)) {
            return redirect()->to('/admin/baremes')->with('error', 'Barème introuvable.');
        }

        $this->baremeModel->delete($id);
        return redirect()->to('/admin/baremes')->with('success', 'Barème supprimé.');
    }
}