<?php

namespace App\Controllers;

use App\Models\RegimeAlimentModel;
use App\Models\RegimeModel;
use App\Models\AlimentModel;

class RegimeAlimentController extends BaseController
{
    // List foods for a specific regime
    public function index($regimeId)
    {
        $regimeAlimentModel = new RegimeAlimentModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        $aliments = $regimeAlimentModel
            ->select('regime_aliment.*, aliment.nom, aliment.type_aliment, aliment.description')
            ->join('aliment', 'aliment.id = regime_aliment.aliment_id')
            ->where('regime_id', $regimeId)
            ->findAll();

        // Calculate total composition percentages
        $totalComposition = [
            'viande' => 0,
            'poisson' => 0,
            'volaille' => 0,
            'total' => 0
        ];

        foreach ($aliments as $aliment) {
            $totalComposition['viande'] += $aliment['pourcentage_viande'];
            $totalComposition['poisson'] += $aliment['pourcentage_poisson'];
            $totalComposition['volaille'] += $aliment['pourcentage_volaille'];
        }
        $totalComposition['total'] = $totalComposition['viande'] + $totalComposition['poisson'] + $totalComposition['volaille'];

        return view('regime_aliment/list', [
            'regime' => $regime,
            'aliments' => $aliments,
            'totalComposition' => $totalComposition
        ]);
    }

    // Form to add foods to a regime
    public function create($regimeId)
    {
        $regimeModel = new RegimeModel();
        $alimentModel = new AlimentModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        // Get foods not yet assigned
        $allAliments = $alimentModel->findAll();
        $regimeAliments = (new RegimeAlimentModel())->where('regime_id', $regimeId)->findAll();
        $assignedAlimentIds = array_column($regimeAliments, 'aliment_id');
        $availableAliments = array_filter($allAliments, fn($a) => !in_array($a['id'], $assignedAlimentIds));

        return view('regime_aliment/create', [
            'regime' => $regime,
            'aliments' => $availableAliments
        ]);
    }

    // Store food for regime
    public function store($regimeId)
    {
        $regimeModel = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        if (!$this->validate([
            'aliment_id' => 'required|numeric',
            'pourcentage_viande' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_poisson' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_volaille' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $viande = (float)$this->request->getPost('pourcentage_viande') ?? 0;
        $poisson = (float)$this->request->getPost('pourcentage_poisson') ?? 0;
        $volaille = (float)$this->request->getPost('pourcentage_volaille') ?? 0;
        $total = $viande + $poisson + $volaille;

        if ($total !== 100) {
            return redirect()->back()->withInput()->with('error', "Les pourcentages doivent totaliser 100% (actuellement: {$total}%)");
        }

        $regimeAlimentModel->insert([
            'regime_id' => $regimeId,
            'aliment_id' => $this->request->getPost('aliment_id'),
            'pourcentage' => $total,
            'pourcentage_viande' => $viande,
            'pourcentage_poisson' => $poisson,
            'pourcentage_volaille' => $volaille
        ]);

        return redirect()->to("/regime-aliment/$regimeId")->with('success', 'Aliment ajouté au régime.');
    }

    // Edit food assignment form
    public function edit($regimeId, $alimentId)
    {
        $regimeAlimentModel = new RegimeAlimentModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        $regimeAliment = $regimeAlimentModel
            ->select('regime_aliment.*, aliment.nom, aliment.type_aliment')
            ->join('aliment', 'aliment.id = regime_aliment.aliment_id')
            ->where('regime_id', $regimeId)
            ->where('aliment_id', $alimentId)
            ->first();

        if (!$regimeAliment) {
            return redirect()->to("/regime-aliment/$regimeId")->with('error', 'Aliment non trouvé.');
        }

        return view('regime_aliment/edit', [
            'regime' => $regime,
            'regimeAliment' => $regimeAliment
        ]);
    }

    // Update food assignment
    public function update($regimeId, $alimentId)
    {
        $regimeAlimentModel = new RegimeAlimentModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        if (!$this->validate([
            'pourcentage_viande' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_poisson' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_volaille' => 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $viande = (float)$this->request->getPost('pourcentage_viande') ?? 0;
        $poisson = (float)$this->request->getPost('pourcentage_poisson') ?? 0;
        $volaille = (float)$this->request->getPost('pourcentage_volaille') ?? 0;
        $total = $viande + $poisson + $volaille;

        if ($total !== 100) {
            return redirect()->back()->withInput()->with('error', "Les pourcentages doivent totaliser 100% (actuellement: {$total}%)");
        }

        $regimeAlimentModel
            ->where('regime_id', $regimeId)
            ->where('aliment_id', $alimentId)
            ->set([
                'pourcentage' => $total,
                'pourcentage_viande' => $viande,
                'pourcentage_poisson' => $poisson,
                'pourcentage_volaille' => $volaille
            ])
            ->update();

        return redirect()->to("/regime-aliment/$regimeId")->with('success', 'Aliment mis à jour.');
    }

    // Delete food from regime
    public function delete($regimeId, $alimentId)
    {
        $regimeAlimentModel = new RegimeAlimentModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/regime')->with('error', 'Régime non trouvé.');
        }

        $regimeAlimentModel
            ->where('regime_id', $regimeId)
            ->where('aliment_id', $alimentId)
            ->delete();

        return redirect()->to("/regime-aliment/$regimeId")->with('success', 'Aliment supprimé du régime.');
    }
}
