<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\AlimentModel;
use App\Models\RegimeAlimentModel;

class RegimeController extends BaseController
{
    // LISTE
    public function index()
    {
        $model = new RegimeModel();
        $alimentModel = new AlimentModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $regimes = $model->findAll();
        
        // Enrichir avec aliments associés
        foreach ($regimes as &$regime) {
            $aliments = $regimeAlimentModel->where('regime_id', $regime['id'])->findAll();
            $regime['aliments'] = [];
            foreach ($aliments as $a) {
                $aliment = $alimentModel->find($a['aliment_id']);
                $regime['aliments'][] = [
                    'nom' => $aliment['nom'],
                    'type_aliment' => $aliment['type_aliment'],
                    'pourcentage' => $a['pourcentage']
                ];
            }
        }

        $data['regimes'] = $regimes;
        return view('regime/list', $data);
    }

    // FORM CREATE
    public function create()
    {
        $alimentModel = new AlimentModel();
        $data['aliments'] = $alimentModel->findAll();
        return view('regime/create', $data);
    }

    // STORE
    public function store()
    {
        $model = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $duree = (int)$this->request->getPost('duree');
        $variation = (float)$this->request->getPost('variation_poids');

        // Validation
        $rules = [
            'nom' => 'required|min_length[2]',
            'duree' => 'required|integer|greater_than[0]',
            'description' => 'permit_empty'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Calcul prix
        if ($duree <= 7) {
            $prixParJour = 1000;
        } elseif ($duree <= 30) {
            $prixParJour = 900;
        } else {
            $prixParJour = 800;
        }
        $prixTotal = $duree * $prixParJour;

        // Save régime
        $model->save([
            'nom' => $this->request->getPost('nom'),
            'duree' => $duree,
            'variation_poids' => $variation,
            'prix' => $prixTotal,
            'description' => $this->request->getPost('description')
        ]);

        $regimeId = $model->getInsertID();

        // Gérer aliments et pourcentages
        $percentages = $this->request->getPost('percentage') ?? [];
        $total = 0.0;

        foreach ($percentages as $aid => $p) {
            $total += (float)$p;
        }

        // Validation somme = 100%
        if (abs($total - 100.0) > 0.01) {
            $model->delete($regimeId);
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être 100%.');
        }

        // Insert dans regime_aliment
        foreach ($percentages as $aid => $p) {
            $val = (float)$p;
            if ($val > 0) {
                $regimeAlimentModel->insert([
                    'regime_id' => $regimeId,
                    'aliment_id' => (int)$aid,
                    'pourcentage' => $val
                ]);
            }
        }

        return redirect()->to('/regime');
    }

    // FORM EDIT
    public function edit($id)
    {
        $model = new RegimeModel();
        $alimentModel = new AlimentModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $data['regime'] = $model->find($id);
        if (!$data['regime']) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        $data['aliments'] = $alimentModel->findAll();

        // Récupérer les aliments actuels avec pourcentages
        $rels = $regimeAlimentModel->where('regime_id', $id)->findAll();
        $data['regime_aliments'] = [];
        foreach ($rels as $r) {
            $data['regime_aliments'][$r['aliment_id']] = $r['pourcentage'];
        }

        return view('regime/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $model = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $duree = (int)$this->request->getPost('duree');
        $variation = (float)$this->request->getPost('variation_poids');

        $rules = [
            'nom' => 'required|min_length[2]',
            'duree' => 'required|integer|greater_than[0]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($duree <= 7) {
            $prixParJour = 1000;
        } elseif ($duree <= 30) {
            $prixParJour = 900;
        } else {
            $prixParJour = 800;
        }
        $prixTotal = $duree * $prixParJour;

        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'duree' => $duree,
            'variation_poids' => $variation,
            'prix' => $prixTotal,
            'description' => $this->request->getPost('description')
        ]);

        // Mettre à jour aliments
        $percentages = $this->request->getPost('percentage') ?? [];
        $total = 0.0;

        foreach ($percentages as $aid => $p) {
            $total += (float)$p;
        }

        if (abs($total - 100.0) > 0.01) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être 100%.');
        }

        // Supprimer les anciens et réinsérer
        $regimeAlimentModel->where('regime_id', $id)->delete();

        foreach ($percentages as $aid => $p) {
            $val = (float)$p;
            if ($val > 0) {
                $regimeAlimentModel->insert([
                    'regime_id' => $id,
                    'aliment_id' => (int)$aid,
                    'pourcentage' => $val
                ]);
            }
        }

        return redirect()->to('/regime');
    }

    // DELETE
    public function delete($id)
    {
        $model = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        // Le schéma SQL actuel ne définit pas ON DELETE CASCADE.
        $regimeAlimentModel->where('regime_id', $id)->delete();
        $model->delete($id);

        return redirect()->to('/regime');
    }
}