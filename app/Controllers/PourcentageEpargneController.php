<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\PourcentageEpargneModel;

class CommissionOperateurController extends BaseController
{
    protected $pourcentageEpargneModel;
    protected $clientModel;


    public function __construct()
    {
        $this->pourcentageEpargneModel = new PourcentageEpargneModel();
        $this->clientModel = new ClientModel();
    }


    // private function checkSession()
    // {
    //     if (!session()->get('role')) {
    //         return redirect()->to('/admin/login');
    //     }

    //     return null;
    // }


    public function index()
    {
        // if ($redirect = $this->checkSession()) return $redirect;
        $data = [
            'commissions' => $this->pourcentageEpargneModel
                                ->getAvecClient(),

            'operateurs' => $this->clientModel
                                ->orderBy('id_client', 'ASC')
                                ->findAll()
        ];


        return view(
            'client/pourcentage',
            $data
        );
    }



    public function create()
    {
        // if ($redirect = $this->checkSession()) return $redirect;


        $validation = \Config\Services::validation();

        $validation->setRules([
            'id_client' => [
                'rules'=>'required|integer'
            ],

            'pourcentage'=>[
                'rules'=>'required|decimal'
            ]
        ]);


        if(!$validation->withRequest($this->request)->run())
        {
            return redirect()
                ->back()
                ->with('errors',$validation->getErrors());
        }


        $this->PourcentageEpargne->insert([
            'id_client'=>$this->request->getPost('id_operateur'),
            'pourcentage'=>$this->request->getPost('pourcentage_commission')
        ]);

        return redirect()
            ->to('/client/pourcentage')
            ->with('success','pourcentage ajoutée.');
    }




    // public function update()
    // {
    //     // if ($redirect = $this->checkSession()) return $redirect;


    //     $id = $this->request->getPost('id_commission_opera');


    //     $this->commissionModel->update($id,[

    //         'id_operateur'=>$this->request->getPost('id_operateur'),

    //         'pourcentage_commission'=>
    //             $this->request->getPost('pourcentage_commission')

    //     ]);


    //     return redirect()
    //         ->to('/admin/commissions')
    //         ->with('success','Commission modifiée.');
    // }





    // public function delete($id=null)
    // {
    //     if ($redirect = $this->checkSession()) return $redirect;


    //     $this->commissionModel->delete($id);


    //     return redirect()
    //         ->to('/admin/commissions')
    //         ->with('success','Commission supprimée.');
    // }

}