<?php

namespace App\Controllers;

use App\Models\WalletCodeModel;

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

    // Approuver un code
    public function approve($id)
    {
        $model = new WalletCodeModel();
        $code = $model->find($id);

        if (!$code) {
            return redirect()->back()->with('error', 'Code non trouvé.');
        }

        $model->update($id, [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        // Ici vous pouvez ajouter la logique de créditer le compte user si souhaité

        return redirect()->to('/admin/wallet?filter=pending')->with('success', 'Code approuvé.');
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
