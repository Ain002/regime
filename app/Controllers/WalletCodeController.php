<?php

namespace App\Controllers;

use App\Models\WalletCodeModel;

class WalletCodeController extends BaseController
{
    // Form pour user demander un code
    public function requestForm()
    {
        return view('wallet/request_form');
    }

    // User demande un code
    public function requestCode()
    {
        $model = new WalletCodeModel();

        $code = $this->request->getPost('code');

        // Vérifier que le code existe et n'est pas déjà demandé/utilisé
        $existing = $model->where('code', $code)->first();

        if (!$existing) {
            return redirect()->back()->withInput()->with('error', 'Code invalide.');
        }

        if ($existing['status'] === 'used') {
            return redirect()->back()->withInput()->with('error', 'Code déjà utilisé.');
        }

        if ($existing['status'] === 'pending' || $existing['status'] === 'approved') {
            return redirect()->back()->withInput()->with('error', 'Code déjà demandé ou approuvé.');
        }

        // Récupérer user_id (vous devez ajuster selon votre auth)
        $userId = session()->get('user_id') ?? null;
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        // Mettre à jour le code avec user_id et status pending
        $model->update($existing['id'], [
            'user_id' => $userId,
            'status' => 'pending',
            'requested_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/wallet/request')->with('success', 'Votre demande a été soumise à l\'approbation.');
    }
}
