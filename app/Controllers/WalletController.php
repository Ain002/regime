<?php

namespace App\Controllers;

use App\Models\WalletModel;
use App\Models\WalletTransactionModel;
use App\Models\UserModel;

class WalletController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }

        if (!$user) {
            return redirect()->to('/login');
        }

        $walletModel = new WalletModel();
        $transactionModel = new WalletTransactionModel();

        // Récupérer le solde
        $wallet = $walletModel->where('user_id', $user['id'])->first();
        if (!$wallet) {
            $walletModel->insert(['user_id' => $user['id'], 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $user['id'])->first();
        }

        $solde = $wallet['solde'] ?? 0;

        // Récupérer les transactions
        $transactions = $transactionModel
            ->where('wallet_id', $wallet['id'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $pager = $transactionModel->pager;

        return view('wallet/index', [
            'user' => $user,
            'solde' => $solde,
            'transactions' => $transactions,
            'pager' => $pager
        ]);
    }
}
