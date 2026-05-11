<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ObjectifUserModel;
use App\Models\AbonnementUserModel;
use App\Models\AbonnementModel;
use App\Models\UserModel;
use App\Models\WalletModel;

use FPDF;

class RecommendationController extends BaseController
{
    public function exportFPDF($regimeId)
    {
        // 1. Initialisation des modèles
        $regimeModel = new RegimeModel();
        $userModel   = new UserModel();
        $aboModel    = new AbonnementUserModel();
    
        // 2. Récupération des données essentielles
        $programme = $regimeModel->getFullProgram($regimeId);
        $user      = session()->get('user');
    
        // Sécurité : Recharger le user si la session est incomplète
        if (!$user && session()->get('user_id')) {
            $user = $userModel->find(session()->get('user_id'));
            session()->set('user', $user);
        }
    
        if (!$user || !$programme) {
            return redirect()->to('/recommendation')->with('error', 'Impossible de générer le PDF.');
        }
    
        // 3. Préparation des données (Calculs préalables)
        
        // Gestion du prix et réduction Gold
        $isGold = $aboModel->isUserGold($user['id']);
        $prixFinal = AbonnementUserModel::applyGoldDiscount((float)$programme['prix'], $isGold);
    
        // Calcul IMC (gestion cm vs m)
        $tailleCm = (float)$user['taille'];
        $poids    = (float)$user['poids'];
        $tailleM  = ($tailleCm > 3) ? $tailleCm / 100 : $tailleCm;
        $imc      = ($tailleM > 0) ? round($poids / ($tailleM * $tailleM), 2) : 0;
    
        // 4. Création du PDF
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 15);
    
        // --- HEADER ---
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(44, 62, 80); // Couleur sombre pro
        $pdf->Cell(0, 15, utf8_decode('PROGRAMME PERSONNALISÉ'), 0, 1, 'C');
        $pdf->Ln(5);
    
        // --- BLOC INFOS CLIENT ---
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0);
        $pdf->Cell(0, 8, utf8_decode('Identité : ' . ($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')), 0, 1);
        
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(40, 7, utf8_decode('IMC : ' . $imc), 0, 0);
        $pdf->Cell(40, 7, utf8_decode('Poids : ' . $poids . ' kg'), 0, 0);
        $pdf->Cell(40, 7, utf8_decode('Taille : ' . $tailleCm . ' cm'), 0, 1);
        $pdf->Ln(10);
    
        // --- TITRE DU RÉGIME ---
        $pdf->SetFillColor(52, 152, 219); // Bleu
        $pdf->SetTextColor(255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, ' ' . utf8_decode(strtoupper($programme['nom'])), 0, 1, 'L', true);
        
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 6, utf8_decode($programme['description']));
        $pdf->Ln(5);
    
        // --- TABLEAU RÉCAPITULATIF (Duree / Poids / Prix) ---
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(236, 240, 241);
        $pdf->Cell(60, 8, utf8_decode('Durée prévue'), 1, 0, 'C', true);
        $pdf->Cell(60, 8, utf8_decode('Objectif de variation'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, utf8_decode('Prix Total'), 1, 1, 'C', true);
    
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(60, 10, $programme['duree'] . ' semaines', 1, 0, 'C');
        $pdf->Cell(60, 10, $programme['variation_totale'] . ' kg', 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(70, 10, number_format($prixFinal, 0, ',', ' ') . ' Ar', 1, 1, 'C');
        $pdf->Ln(10);
    
        // --- TABLEAU COMPOSITION ALIMENTS ---
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 10, utf8_decode(' Composition Alimentaire'), 0, 1);
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Cell(90, 8, 'Aliment', 1, 0, 'L', true);
        $pdf->Cell(50, 8, 'Type', 1, 0, 'L', true);
        $pdf->Cell(50, 8, '% du Programme', 1, 1, 'L', true);
    
        $pdf->SetFont('Arial', '', 10);
        foreach ($programme['aliments'] as $aliment) {
            $pdf->Cell(90, 8, utf8_decode($aliment['nom']), 1);
            $pdf->Cell(50, 8, utf8_decode(ucfirst($aliment['type_aliment'])), 1);
            $pdf->Cell(50, 8, $aliment['pourcentage'] . '%', 1, 1, 'C');
        }
        $pdf->Ln(10);
    
        // --- SECTION SPORTS ---
        if (!empty($programme['sports'])) {
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Cell(0, 10, utf8_decode(' Programme Sportif Associé'), 0, 1);
            $pdf->Ln(2);
    
            foreach ($programme['sports'] as $sport) {
                $pdf->SetDrawColor(52, 152, 219);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(0, 8, ' > ' . utf8_decode($sport['nom']), 'B', 1);
                
                $pdf->SetDrawColor(0);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Ln(2);
                $pdf->MultiCell(0, 5, utf8_decode($sport['description']));
                
                $detailsSport = "Frequence : {$sport['frequence_semaine']}x/sem | Duree : {$sport['duree_minutes']} min | Intensite : {$sport['intensite']}";
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(0, 7, utf8_decode($detailsSport), 0, 1);
                $pdf->Ln(4);
            }
        }
    
        // --- FOOTER ---
        $pdf->SetY(-25);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetTextColor(127, 140, 141);
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'R');
    
        // --- SORTIE ---
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('D', 'Programme_' . str_replace(' ', '_', $programme['nom']) . '.pdf');
    }
    public function detail($regimeId)
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
        $programme = $regimeModel->getFullProgram($regimeId);
        if (!$programme) {
            return redirect()->to('/recommendation')->with('error', 'Programme introuvable');
        }

        $aboModel = new AbonnementUserModel();
        $isGold = $aboModel->isUserGold($user['id']);
        $programme['prix_final'] = AbonnementUserModel::applyGoldDiscount((float) $programme['prix'], $isGold);
        $programme['is_gold_applied'] = $isGold;

        $walletModel = new WalletModel();
        $solde = $walletModel->getSoldeByUserId($user['id']) ?? 0;

        return view('recommendation/detail', [
            'programme' => $programme,
            'user' => $user,
            'solde' => $solde,
            'isGold' => $isGold
        ]);
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
        
        // Récupérer le prix de l'abonnement Gold
        $abonnementModel = new AbonnementModel();
        $goldAbonnement = $abonnementModel->where('libelle', 'Gold')->first();
        $goldPrice = $goldAbonnement ? (float)$goldAbonnement['prix'] : 0;

        $regimeModel = new RegimeModel();

        if ($objectifDescription == 'Augmenter son poids' || $objectifDescription == 'Gagner de poids') {
            $regimeModel->where('variation_poids >', 0);
        } elseif ($objectifDescription == 'Réduire son poids' || $objectifDescription == 'Perdre de poids') {
            $regimeModel->where('variation_poids <', 0);
        } else {
            // 'Atteindre son IMC idéal'
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

            $prixTotal = AbonnementUserModel::applyGoldDiscount((float) $regime['prix'], $isGold);

            $details['prix_final'] = round($prixTotal, 2);
            $details['is_gold_applied'] = $isGold;

            $programmes[] = $details;
        }

        return view('recommendation/index', [
            'user' => $user,
            'imc' => $imc,
            'etat' => $etat,
            'objectif' => $objectifDescription,
            'solde' => $solde,
            'isGold' => $isGold,
            'goldPrice' => $goldPrice,
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
        $aboModel = new AbonnementUserModel();
        $prix = AbonnementUserModel::applyGoldDiscount((float) $regime['prix'], $aboModel->isUserGold($user['id']));

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
        if ($imc < 18.5)
            return 'Sous-poids';
        if ($imc < 25)
            return 'Normal';
        if ($imc < 30)
            return 'Surpoids';
        return 'Obèse';
    }
}
