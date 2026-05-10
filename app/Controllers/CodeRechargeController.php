<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\CodeRechargeModel;
use App\Models\WalletTransactionModel;


class CodeRechargeController extends BaseController
{
    public function saisieCode()
    {
        $walletModel = new WalletModel();
        $codeRechargeModel = new CodeRechargeModel();
        $walletTransactionModel = new WalletTransactionModel();
        $code = $this->request->getGet('code');
        $userID = session()->get('user_id');

        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }
        if (!$code) {
            return redirect()->back()->with('error', 'Veuillez entrer un code.');
        }

        $wallet = $walletModel->where('user_id', $userID)->first();
        if (!$wallet) {
            $walletModel->insert(['user_id' => $userID, 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $userID)->first();
        }

        $codeData = $codeRechargeModel->where('code', $code)->first();
        if (!$codeData) {
            return redirect()->back()->with('error', 'Code invalide.');
        }

        if ($codeData['used_by'] != null && $codeData['used_at'] != null)
        {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Code déjà utilisé'
                );
        }
        $walletModel->update(
            $wallet['id'],
            [
                'solde' =>
                $wallet['solde'] + $codeData['montant']
            ]
        );
        $codeRechargeModel->update($codeData['id'], [
            'used' => 1,
            'used_by' => $userID,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        $walletTransactionModel->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $codeData['montant'],
            'type_transaction' => 'recharge',
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Votre porte-monnaie a été rechargé.');

    }

    public function validateCode()
    {
        $walletModel = new WalletModel();
        $codeRechargeModel = new CodeRechargeModel();
        $walletTransactionModel = new WalletTransactionModel();

        $code = $this->request->getPost('code');
        $userID = session()->get('user_id');

        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        if (!$code) {
            return redirect()->back()->with('error', 'Veuillez entrer un code.');
        }

        $wallet = $walletModel->where('user_id', $userID)->first();
        if (!$wallet) {
            $walletModel->insert(['user_id' => $userID, 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $userID)->first();
        }

        $codeData = $codeRechargeModel->where('code', $code)->first();
        if (!$codeData) {
            return redirect()->back()->with('error', 'Code invalide.');
        }

        if ($codeData['used'] == 1) {
            return redirect()->back()->with('error', 'Code déjà utilisé.');
        }

        $walletModel->update($wallet['id'], [
            'solde' => $wallet['solde'] + $codeData['montant']
        ]);

        $codeRechargeModel->update($codeData['id'], [
            'used' => 1,
            'used_by' => $userID,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        $walletTransactionModel->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $codeData['montant'],
            'type_transaction' => 'recharge',
            'date_transaction' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/recommendation')->with('success', 'Votre porte-monnaie a été rechargé avec succès !');
    }
}


