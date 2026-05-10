<?php

namespace App\Controllers;

use App\Models\WalletCodeModel;
use App\Models\WalletModel;
use App\Models\WalletTransactionModel;

class AdminWalletController extends BaseController
{
    // Dashboard admin - liste les codes en attente
    public function index()
    {
        $model = new WalletCodeModel();

        // Filtrer par statut
        $filter = $this->request->getGet('filter') ?? 'pending';
        $data['filter'] = $filter;

        if ($filter === 'all') {
            $data['codes'] = $model->findAll();
        } else {
            $data['codes'] = $model->where('status', $filter)->findAll();
        }

        return view('admin/wallet/list', $data);
    }

    // Approuver un code et créditer le compte
    public function approve($id)
    {
        $walletCodeModel = new WalletCodeModel();
        $walletModel = new WalletModel();
        $transactionModel = new WalletTransactionModel();

        $code = $walletCodeModel->find($id);

        if (!$code) {
            return redirect()->back()->with('error', 'Code non trouvé.');
        }

        if ($code['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Ce code n\'est pas en attente d\'approbation.');
        }

        if (!$code['user_id']) {
            return redirect()->back()->with('error', 'Pas d\'utilisateur associé à ce code.');
        }

        // Récupérer ou créer le portefeuille de l'utilisateur
        $wallet = $walletModel->where('user_id', $code['user_id'])->first();
        if (!$wallet) {
            $walletModel->insert(['user_id' => $code['user_id'], 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $code['user_id'])->first();
        }

        $montant = (float) $code['value'];

        // Créditer le portefeuille
        $walletModel->update($wallet['id'], [
            'solde' => ((float) $wallet['solde']) + $montant,
        ]);

        // Créer une transaction (insert via table to avoid Model->insert binding issues)
        $transactionModel->db->table('wallet_transactions')->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $montant,
            'type' => 'recharge',
            'user_id' => $code['user_id'],
        ]);

        // Marquer le code comme utilisé
        $walletCodeModel->update($id, [
            'status' => 'used',
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/wallet?filter=pending')->with('success', 'Code approuvé et compte crédité avec succès.');
    }

    // Rejeter un code
    public function reject($id)
    {
        $model = new WalletCodeModel();
        $code = $model->find($id);

        if (!$code) {
            return redirect()->back()->with('error', 'Code non trouvé.');
        }

        $model->update($id, [
            'status' => 'rejected',
            'rejected_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/wallet?filter=pending')->with('success', 'Code rejeté.');
    }

    // Marquer comme utilisé
    public function markUsed($id)
    {
        $model = new WalletCodeModel();
        $code = $model->find($id);

        if (!$code) {
            return redirect()->back()->with('error', 'Code non trouvé.');
        }

        $model->update($id, [
            'status' => 'used'
        ]);

        return redirect()->back()->with('success', 'Code marqué comme utilisé.');
    }
}
