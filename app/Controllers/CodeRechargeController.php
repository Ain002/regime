<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WalletCodeModel;
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
        $walletCodeModel = new WalletCodeModel();

        $code = strtoupper(trim((string) $this->request->getPost('code')));
        $userID = session()->get('user_id');

        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        if ($code === '') {
            return redirect()->back()->with('error', 'Veuillez entrer un code.');
        }

        // Chercher le code avec status 'available'
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

        // Créer une demande de recharge en attente d'approbation admin
        $walletCodeModel->update($codeData['id'], [
            'status' => 'pending',
            'user_id' => $userID,
            'requested_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Votre demande de recharge a été soumise. En attente de confirmation de l\'administrateur.');
    }
}


