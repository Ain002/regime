<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ObjectifUserModel;
use App\Models\AbonnementUserModel; 
use App\Models\UserModel;
use App\Models\WalletModel;

use FPDF;

class RecommendationController extends BaseController
{
    public function exportFPDF($regimeId)
    {
        $regimeModel = new RegimeModel();
        $programme = $regimeModel->getFullProgram($regimeId);
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }
        if (!$user || !$programme) {
            return redirect()->to('/recommendation')->with('error', 'Impossible de générer le PDF.');
        }

        // P = Portrait, mm = millimètres, A4 = format
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        
        // --- En-tête ---
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(0, 0, 0); // Couleur Noire
        $pdf->Cell(0, 10, utf8_decode("VOTRE PROGRAMME DE RÉGIME"), 0, 1, 'C');
        $pdf->Ln(10); // Saut de ligne

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $tailleM = ((float) $user['taille']) > 3 ? ((float) $user['taille']) / 100 : (float) $user['taille'];
        $imc = $tailleM > 0 ? round(((float) $user['poids']) / ($tailleM ** 2), 2) : 0;
        $pdf->Cell(0, 10, utf8_decode("Utilisateur : " . ($user['nom'] ?? '') . " " . ($user['prenom'] ?? '')), 0, 1);
        $pdf->Cell(0, 10, "IMC : " . $imc, 0, 1);
        $pdf->Ln(5);

        $pdf->SetFillColor(255, 255, 128); // navy blue 
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 12, utf8_decode("Régime : " . $programme['nom']), 0, 1, 'L', true);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        // En-têtes du tableau
        $pdf->Cell(130, 10, "Aliment", 1);
        $pdf->Cell(60, 10, "Pourcentage", 1, 1);

        $pdf->SetFont('Arial', '', 12);
        foreach ($programme['aliments'] as $al) {
            $pdf->Cell(130, 10, utf8_decode($al['nom']), 1);
            $pdf->Cell(60, 10, $al['pourcentage'] . "%", 1, 1);
        }

        // 'D' force le téléchargement, 'I' affiche dans le navigateur
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('D', 'Regime_' . $programme['nom'] . '.pdf');
    }
    
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

        $tailleM = ((float) $user['taille']) > 3 ? ((float) $user['taille']) / 100 : (float) $user['taille'];
        $imc = $tailleM > 0 ? ((float) $user['poids'] / ($tailleM * $tailleM)) : 0;
        $imc = round($imc, 2);
        $etat = $this->getEtatPhysique($imc);

        $objectifModel = new ObjectifUserModel();
        $objectif = $objectifModel->getLatestObjectifByUserId($user['id']);
        $objectifDescription = $objectif['description'] ?? '';

        $aboModel = new AbonnementUserModel();
        $isGold = $aboModel->isUserGold($user['id']); 

        $walletModel = new WalletModel();
        $solde = $walletModel->getSoldeByUserId($user['id']) ?? 0;

        $regimeModel = new RegimeModel();
        
        if ($objectifDescription == 'Augmenter son poids' || $objectifDescription == 'Gagner de poids') {
            $regimeModel->where('variation_poids >', 0);
        } elseif ($objectifDescription == 'Réduire son poids' || $objectifDescription == 'Perdre de poids') {
            $regimeModel->where('variation_poids <', 0);
        } else {
            // "Atteindre son IMC idéal"
            if ($imc > 25) {
                $regimeModel->where('variation_poids <', 0);
            } elseif ($imc < 18.5) {
                $regimeModel->where('variation_poids >', 0);
            } else {
                $regimeModel->where('variation_poids >=', -2)
                            ->where('variation_poids <=', 2);
            }
        }

        $regimes = $regimeModel->findAll();
        $programmes = [];

        foreach ($regimes as $regime) {
            $details = $regimeModel->getFullProgram($regime['id']);
            
            $prixTotal = $regime['prix']; 

            if ($isGold) {
                $prixTotal = $prixTotal * 0.85; 
            }

            $details['prix_final'] = round($prixTotal, 2);
            $details['is_gold_applied'] = $isGold; 
            
            $programmes[] = $details;
        }

        return view('recommendation/index', [
            'user'       => $user,
            'imc'        => $imc,
            'etat'       => $etat,
            'objectif'   => $objectifDescription,
            'solde'      => $solde,
            'isGold'     => $isGold,
            'programmes' => $programmes
        ]);
    }

    public function buy($regimeId)
    {
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }

        if (!$user) {
            return redirect()->to('/login');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/recommendation')->with('error', 'Régime introuvable.');
        }

        $walletModel = new WalletModel();
        $wallet = $walletModel->where('user_id', $user['id'])->first();
        if (!$wallet) {
            return redirect()->to('/recommendation')->with('error', 'Portefeuille introuvable.');
        }

        // Vérifier le solde
        $prix = $regime['prix'];
        $aboModel = new AbonnementUserModel();
        if ($aboModel->isUserGold($user['id'])) {
            $prix = $prix * 0.85;
        }

        if ($wallet['solde'] < $prix) {
            return redirect()->to('/recommendation')->with('error', 'Solde insuffisant. Veuillez recharger votre portefeuille.');
        }

        // Effectuer l'achat
        $walletModel->update($wallet['id'], [
            'solde' => $wallet['solde'] - $prix
        ]);

        // Créer un enregistrement d'achat
        $achatRegimeModel = new \App\Models\AchatRegimeModel();
        $achatRegimeModel->insert([
            'user_id' => $user['id'],
            'regime_id' => $regimeId,
            'montant_paye' => $prix,
            'date_achat' => date('Y-m-d H:i:s'),
            'statut' => 'active',
            'date_expiration' => date('Y-m-d', strtotime('+30 days'))
        ]);

        // Créer une transaction
        $transactionModel = new \App\Models\WalletTransactionModel();
        $transactionModel->insert([
            'wallet_id' => $wallet['id'],
            'montant' => $prix,
            'type' => 'achat',
            'user_id' => $user['id']
        ]);

        return redirect()->to('/recommendation')->with('success', 'Régime acheté avec succès !');
    }

    private function getEtatPhysique($imc)
    {
        if ($imc < 18.5) return 'Sous-poids';
        if ($imc < 25)   return 'Normal';
        if ($imc < 30)   return 'Surpoids';
        return 'Obèse';
    }
}
