<?php

namespace App\Models;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\AbonnementModel;
use App\Models\AbonnementUserModel;


class AbonnementController extends BaseController
{
    public function acheterGold()
    {
        $userID = session()->get('id');

        $walletModel = new WalletModel();
        $abonnementModel = new AbonnementModel();
        $abonnementUserModel = new AbonnementUserModel();

        $wallet = $walletModel->where('user_id', $userID)->first();
        $gold = $abonnementModel->where('libelle', 'Gold')->first();
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