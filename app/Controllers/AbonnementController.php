<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\AbonnementModel;
use App\Models\AbonnementUserModel;
use App\Models\WalletTransactionModel;


class AbonnementController extends BaseController
{
    public function acheterGold()
    {
        $userID = session()->get('user_id');
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        $walletModel = new WalletModel();
        $abonnementModel = new AbonnementModel();
        $abonnementUserModel = new AbonnementUserModel();
        $transactionModel = new WalletTransactionModel();

        $wallet = $walletModel->where('user_id', $userID)->first();
        $gold = $abonnementModel->where('libelle', 'Gold')->first();
        if (!$gold) {
            return redirect()->back()->with('error', 'Abonnement Gold introuvable.');
        }
        if (!$wallet) {
            $walletModel->insert(['user_id' => $userID, 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $userID)->first();
        }
        $dejaGold = $abonnementUserModel->where('user_id', $userID)->where('abonnement_id', $gold['id'])->first();
        if($dejaGold)
        {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Vous êtes déjà Gold'
                );
        }
        if($wallet['solde'] < $gold['prix'])
        {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Solde insuffisant'
                );
        }
        $walletModel->update(
            $wallet['id'],
            [
                'solde' =>
                $wallet['solde'] - $gold['prix']
            ]
        );
        $transactionModel->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $gold['prix'],
            'type' => 'achat',
            'user_id' => $userID
        ]);
        $abonnementUserModel->insert([
            'user_id' => $userID,
            'abonnement_id' => $gold['id']
        ]);
        return redirect()
            ->back()
            ->with(
                'success',
                'Gold activé'
            );

    }
}
