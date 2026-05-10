<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\WalletCodeModel;
use App\Models\WalletTransactionModel;
use App\Models\UserModel;

class CodeRechargeController extends BaseController
{
    public function saisieCode()
    {
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }

        if (!$user) {
            return redirect()->to('/login');
        }

        return view('code/index', [
            'user' => $user,
        ]);
    }

    public function validateCode()
    {
        $walletModel = new WalletModel();
        $walletCodeModel = new WalletCodeModel();
        $walletTransactionModel = new WalletTransactionModel();

        $code = strtoupper(trim((string) $this->request->getPost('code')));
        $userID = session()->get('user_id');

        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        if ($code === '') {
            return redirect()->back()->with('error', 'Veuillez entrer un code.');
        }

        $wallet = $walletModel->where('user_id', $userID)->first();
        if (!$wallet) {
            $walletModel->insert(['user_id' => $userID, 'solde' => 0]);
            $wallet = $walletModel->where('user_id', $userID)->first();
        }

        $codeData = $walletCodeModel
            ->where('code', $code)
            ->where('status', 'available')
            ->first();

        if (!$codeData) {
            return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
        }

        $montant = (float) ($codeData['value'] ?? 0);
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant du code invalide.');
        }

        $walletModel->update($wallet['id'], [
            'solde' => ((float) $wallet['solde']) + $montant,
        ]);

        $walletCodeModel->update($codeData['id'], [
            'status' => 'used',
            'user_id' => $userID,
            'approved_at' => date('Y-m-d H:i:s'),
        ]);

        $walletTransactionModel->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $montant,
            'type' => 'recharge',
            'user_id' => $userID,
        ]);

        return redirect()->to('/recommendation')->with('success', 'Votre porte-monnaie a été rechargé avec succès !');
    }
}


