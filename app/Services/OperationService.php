<?php

namespace App\Services;

use App\Models\OperationModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeFraisModel;
use App\Models\ClientModel;
use CodeIgniter\Database\Config;

class OperationService
{
    protected $operationModel;
    protected $typeOperationModel;
    protected $baremeFraisModel;
    protected $clientModel;
    protected $db;

    public function __construct()
    {
        $this->operationModel = new OperationModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeFraisModel = new BaremeFraisModel();
        $this->clientModel = new ClientModel();
        $this->db = Config::connect();
    }

    public function getIdTypeOperation(string $code): ?int
    {
        $type = $this->typeOperationModel->where('code', $code)->first();
        return $type ? (int) $type['id_type_operation'] : null;
    }

    public function getSolde(int $idClient): float
    {
        $row = $this->db->table('v_solde_clients')
                       ->where('id_client', $idClient)
                       ->get()
                       ->getRowArray();
        return $row ? (float) $row['solde'] : 0;
    }

    public function getFrais(string $codeType, float $montant): float
    {
        $idType = $this->getIdTypeOperation($codeType);
        if (!$idType) return 0;
        return $this->baremeFraisModel->getFrais($idType, $montant);
    }

    public function effectuerDepot(int $idClient, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $idType = $this->getIdTypeOperation('DEPOT');
        if (!$idType) {
            return ['success' => false, 'message' => 'Type DEPOT introuvable.'];
        }

        $this->operationModel->insert([
            'id_client' => $idClient,
            'id_type_operation' => $idType,
            'montant' => $montant
        ]);

        return ['success' => true, 'message' => 'Dépôt effectué avec succès.'];
    }

    public function effectuerRetrait(int $idClient, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $idType = $this->getIdTypeOperation('RETRAIT');
        if (!$idType) {
            return ['success' => false, 'message' => 'Type RETRAIT introuvable.'];
        }

        $frais = $this->baremeFraisModel->getFrais($idType, $montant);
        $total = $montant + $frais;
        $solde = $this->getSolde($idClient);

        if ($solde < $total) {
            return ['success' => false, 'message' => 'Solde insuffisant.'];
        }

        $this->operationModel->insert([
            'id_client' => $idClient,
            'id_type_operation' => $idType,
            'montant' => $montant
        ]);

        return ['success' => true, 'message' => 'Retrait effectué avec succès.'];
    }

    public function effectuerTransfert(int $idClient, string $numeroDestinataire, float $montant): array
    {
        if ($montant <= 0) {
            return ['success' => false, 'message' => 'Montant invalide.'];
        }

        $expediteur = $this->clientModel->find($idClient);
        if (!$expediteur) {
            return ['success' => false, 'message' => 'Expéditeur introuvable.'];
        }

        if ($expediteur['numero_telephone'] === $numeroDestinataire) {
            return ['success' => false, 'message' => 'Le destinataire doit être différent de l\'expéditeur.'];
        }

        $destinataire = $this->clientModel->findByNumero($numeroDestinataire);
        if (!$destinataire) {
            $idDest = $this->clientModel->insert(['numero_telephone' => $numeroDestinataire]);
            $destinataire = $this->clientModel->find($idDest);
        }

        $idType = $this->getIdTypeOperation('TRANSFERT');
        if (!$idType) {
            return ['success' => false, 'message' => 'Type TRANSFERT introuvable.'];
        }

        $frais = $this->baremeFraisModel->getFrais($idType, $montant);
        $total = $montant + $frais;
        $solde = $this->getSolde($idClient);

        if ($solde < $total) {
            return ['success' => false, 'message' => 'Solde insuffisant.'];
        }

        $this->db->transBegin();

        try {
            $this->operationModel->insert([
                'id_client' => $idClient,
                'id_client_destinataire' => $destinataire['id_client'],
                'id_type_operation' => $idType,
                'montant' => $montant
            ]);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return ['success' => false, 'message' => 'Erreur lors du transfert.'];
            }

            $this->db->transCommit();
            return ['success' => true, 'message' => 'Transfert effectué avec succès.'];
        } catch (\Exception $e) {
            $this->db->transRollback();
            return ['success' => false, 'message' => 'Erreur lors du transfert.'];
        }
    }
}