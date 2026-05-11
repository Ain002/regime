<?php

namespace App\Controllers;

use App\Models\RegimeSportModel;
use App\Models\RegimeModel;
use App\Models\ActivityModel;

class RegimeSportController extends BaseController
{
    // List sports for a specific regime
    public function index($regimeId)
    {
        $regimeSportModel = new RegimeSportModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        $sports = $regimeSportModel->getSportsForRegime($regimeId);

        return view('regime_sport/list', [
            'regime' => $regime,
            'sports' => $sports
        ]);
    }

    // Form to add sports to a regime
    public function create($regimeId)
    {
        $regimeModel = new RegimeModel();
        $activityModel = new ActivityModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        // Get sports not yet assigned
        $allSports = $activityModel->findAll();
        $regimeSports = (new RegimeSportModel())->where('regime_id', $regimeId)->findAll();
        $assignedSportIds = array_column($regimeSports, 'sport_id');
        $availableSports = array_filter($allSports, fn($s) => !in_array($s['id'], $assignedSportIds));

        return view('regime_sport/create', [
            'regime' => $regime,
            'sports' => $availableSports
        ]);
    }

    // Store sport for regime
    public function store($regimeId)
    {
        $regimeModel = new RegimeModel();
        $regimeSportModel = new RegimeSportModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        if (!$this->validate([
            'sport_id' => 'required|numeric',
            'frequence_semaine' => 'required|numeric|greater_than[0]|less_than_equal_to[7]',
            'duree_minutes' => 'required|numeric|greater_than[0]',
            'intensite' => 'required|in_list[faible,modérée,élevée]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $regimeSportModel->insert([
            'regime_id' => $regimeId,
            'sport_id' => $this->request->getPost('sport_id'),
            'frequence_semaine' => $this->request->getPost('frequence_semaine'),
            'duree_minutes' => $this->request->getPost('duree_minutes'),
            'intensite' => $this->request->getPost('intensite')
        ]);

        return redirect()->to("/admin/regime-sport/$regimeId")->with('success', 'Sport ajouté au régime.');
    }

    // Edit sport assignment form
    public function edit($regimeId, $sportId)
    {
        $regimeSportModel = new RegimeSportModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        $regimeSport = $regimeSportModel
            ->where('regime_id', $regimeId)
            ->where('sport_id', $sportId)
            ->first();

        if (!$regimeSport) {
            return redirect()->to("/admin/regime-sport/$regimeId")->with('error', 'Assignation non trouvée.');
        }

        return view('regime_sport/edit', [
            'regime' => $regime,
            'regimeSport' => $regimeSport
        ]);
    }

    // Update sport assignment
    public function update($regimeId, $sportId)
    {
        $regimeSportModel = new RegimeSportModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        if (!$this->validate([
            'frequence_semaine' => 'required|numeric|greater_than[0]|less_than_equal_to[7]',
            'duree_minutes' => 'required|numeric|greater_than[0]',
            'intensite' => 'required|in_list[faible,modérée,élevée]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $regimeSportModel
            ->where('regime_id', $regimeId)
            ->where('sport_id', $sportId)
            ->set([
                'frequence_semaine' => $this->request->getPost('frequence_semaine'),
                'duree_minutes' => $this->request->getPost('duree_minutes'),
                'intensite' => $this->request->getPost('intensite')
            ])
            ->update();

        return redirect()->to("/admin/regime-sport/$regimeId")->with('success', 'Sport mis à jour.');
    }

    // Delete sport from regime
    public function delete($regimeId, $sportId)
    {
        $regimeSportModel = new RegimeSportModel();
        $regimeModel = new RegimeModel();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/admin/regime')->with('error', 'Régime non trouvé.');
        }

        $regimeSportModel
            ->where('regime_id', $regimeId)
            ->where('sport_id', $sportId)
            ->delete();

        return redirect()->to("/admin/regime-sport/$regimeId")->with('success', 'Sport supprimé du régime.');
    }
}
