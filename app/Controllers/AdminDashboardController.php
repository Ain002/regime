<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\CodeRechargeModel;
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
        $codeModel = new CodeRechargeModel();
        $allCodes = $codeModel->findAll();
        $totalCodes = count($allCodes);
        $codesUsed = count(array_filter($allCodes, fn($c) => !empty($c['used'])));
        $codesPending = count(array_filter($allCodes, fn($c) => $c['statut'] === 'pending'));

        // Statistiques des utilisateurs
        $userModel = new UserModel();
        $totalUsers = count($userModel->where('type_user_id', 1)->findAll());

        // Statistiques des achats Gold
        $abbonModel = new AbonnementUserModel();
        $goldPurchases = count($abbonModel->findAll());

        // Statistiques des transactions portefeuille
        $transModel = new WalletTransactionModel();
        $totalTransactions = count($transModel->findAll());
        $transactions = $transModel->orderBy('created_at', 'DESC')->limit(10)->findAll();

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
            'codesUsed' => $codesUsed,
            'codesPending' => $codesPending,
            'totalUsers' => $totalUsers,
            'goldPurchases' => $goldPurchases,
            'totalTransactions' => $totalTransactions,
            'recentTransactions' => $transactions,
            'revenueByType' => $revenueByType,
        ];

        return view('admin/dashboard', $data);
    }
}
