<?php

namespace App\Controllers;

use App\Models\CommissionOperateurModel;
use App\Models\OperateurModel;

class CommissionOperateurController extends BaseController
{
    protected $commissionModel;
    protected $operateurModel;


    public function __construct()
    {
        $this->commissionModel = new CommissionOperateurModel();
        $this->operateurModel = new OperateurModel();
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
            'commissions' => $this->commissionModel
                                ->getAvecOperateur(),

            'operateurs' => $this->operateurModel
                                ->orderBy('libelle', 'ASC')
                                ->findAll()
        ];


        return view(
            'admin/commissions',
            $data
        );
    }



    public function create()
    {
        if ($redirect = $this->checkSession()) return $redirect;


        $validation = \Config\Services::validation();

        $validation->setRules([
            'id_operateur' => [
                'rules'=>'required|integer'
            ],

            'pourcentage_commission'=>[
                'rules'=>'required|decimal'
            ]
        ]);


        if(!$validation->withRequest($this->request)->run())
        {
            return redirect()
                ->back()
                ->with('errors',$validation->getErrors());
        }


        $this->commissionModel->insert([
            'id_operateur'=>$this->request->getPost('id_operateur'),
            'pourcentage_commission'=>$this->request->getPost('pourcentage_commission')
        ]);


        return redirect()
            ->to('/admin/commissions')
            ->with('success','Commission ajoutée.');
    }




    public function update()
    {
        if ($redirect = $this->checkSession()) return $redirect;


        $id = $this->request->getPost('id_commission_operateur');


        $this->commissionModel->update($id,[

            'id_operateur'=>$this->request->getPost('id_operateur'),

            'pourcentage_commission'=>
                $this->request->getPost('pourcentage_commission')

        ]);


        return redirect()
            ->to('/admin/commissions')
            ->with('success','Commission modifiée.');
    }





    public function delete($id=null)
    {
        if ($redirect = $this->checkSession()) return $redirect;


        $this->commissionModel->delete($id);


        return redirect()
            ->to('/admin/commissions')
            ->with('success','Commission supprimée.');
    }

}