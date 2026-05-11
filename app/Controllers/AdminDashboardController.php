<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\WalletCodeModel;
use App\Models\UserModel;
use App\Models\WalletTransactionModel;
use App\Models\AbonnementUserModel;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Vérifier que c'est un admin
        if (!$session->get('isAdmin')) {
            return redirect()->to('/auth/admin-login')->with('error', 'Accès réservé aux administrateurs');
        }

        // Statistiques des régimes
        $regimeModel = new RegimeModel();
        $totalRegimes = count($regimeModel->findAll());

        // Statistiques des codes recharge
        $codeModel = new WalletCodeModel();
        $allCodes = $codeModel->findAll();
        $totalCodes = count($allCodes);
        $codesAvailable = count(array_filter($allCodes, fn($c) => ($c['status'] ?? 'available') === 'available'));
        $codesUsed = count(array_filter($allCodes, fn($c) => ($c['status'] ?? '') === 'used'));
        $codesPending = count(array_filter($allCodes, fn($c) => ($c['status'] ?? '') === 'pending'));
        $codesApproved = count(array_filter($allCodes, fn($c) => ($c['status'] ?? '') === 'approved'));
        $codesRejected = count(array_filter($allCodes, fn($c) => ($c['status'] ?? '') === 'rejected'));

        // Statistiques des utilisateurs
        $userModel = new UserModel();
        $totalUsers = $userModel->where('type_user_id', 1)->countAllResults();

        // Statistiques des achats Gold
        $abbonModel = new AbonnementUserModel();
        $goldPurchases = $abbonModel->countAllResults();

        // Statistiques des transactions portefeuille
        $transModel = new WalletTransactionModel();
        $totalTransactions = $transModel->countAllResults();
        $transactions = $transModel->orderBy('created_at', 'DESC')->findAll(10);

        // Revenus totaux par type
        $allTransactions = $transModel->findAll();
        $revenueByType = [];
        foreach ($allTransactions as $trans) {
            $type = $trans['type'] ?? 'unknown';
            if (!isset($revenueByType[$type])) {
                $revenueByType[$type] = 0;
            }
            $revenueByType[$type] += (float) $trans['montant'];
        }

        $data = [
            'totalRegimes' => $totalRegimes,
            'totalCodes' => $totalCodes,
            'codesAvailable' => $codesAvailable,
            'codesUsed' => $codesUsed,
            'codesPending' => $codesPending,
            'codesApproved' => $codesApproved,
            'codesRejected' => $codesRejected,
            'totalUsers' => $totalUsers,
            'goldPurchases' => $goldPurchases,
            'totalTransactions' => $totalTransactions,
            'recentTransactions' => $transactions,
            'revenueByType' => $revenueByType,
        ];

        return view('admin/dashboard', $data);
    }
}
