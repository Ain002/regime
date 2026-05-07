<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\ObjectifUserModel;
use App\Models\AbonnementUserModel; // Ajouté pour vérifier le statut Gold

class RecommendationController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login');
        }

        $imc = $user['poids'] / ($user['taille'] * $user['taille']);
        $imc = round($imc, 2);
        $etat = $this->getEtatPhysique($imc);

        $objectifModel = new ObjectifUserModel();
        $objectif = $objectifModel->getLatestObjectifByUserId($user['id']);
        $objectifDescription = $objectif['description'] ?? '';

 
        $aboModel = new AbonnementUserModel();
        $isGold = $aboModel->isUserGold($user['id']); 

        $regimeModel = new RegimeModel();
        

        if ($objectifDescription == 'Augmenter son poids') {
            $regimeModel->where('variation_poids >', 0);
        } elseif ($objectifDescription == 'Réduire son poids') {
            $regimeModel->where('variation_poids <', 0);
        } else {
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
            'programmes' => $programmes
        ]);
    }

    private function getEtatPhysique($imc)
    {
        if ($imc < 18.5) return 'Sous-poids';
        if ($imc < 25)   return 'Normal';
        if ($imc < 30)   return 'Surpoids';
        return 'Obèse';
    }
}