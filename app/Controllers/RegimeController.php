<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\AlimentModel;
use App\Models\RegimeAlimentModel;

class RegimeController extends BaseController{
    public function index()
    {
        $model = new RegimeModel();
        $regimes = $model->findAll();
        $data['regimes'] = [];

        foreach ($regimes as $regime) {
            $data['regimes'][] = $model->getFullProgram($regime['id']);
        }

        return view('regime/list', $data);
    }

    public function create()
    {
        $alimentModel = new AlimentModel();
        return view('regime/create', [
            'aliments' => $alimentModel->findAll(),
        ]);
    }

    public function store()
    {
        $regimeModel = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $percentages = $this->request->getPost('percentage') ?? [];
        $selectedPercentages = [];
        $total = 0;

        foreach ($percentages as $alimentId => $pct) {
            $value = (float) $pct;
            if ($value > 0) {
                $selectedPercentages[(int) $alimentId] = $value;
                $total += $value;
            }
        }

        if (empty($selectedPercentages) || abs($total - 100) > 0.01) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%.');
        }

        $regimeModel->save([
            'nom' => $this->request->getPost('nom'),
            'duree' => $this->request->getPost('duree'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description')
        ]);

        $regimeId = $regimeModel->getInsertID();
        foreach ($selectedPercentages as $alimentId => $pct) {
            $regimeAlimentModel->insert([
                'regime_id' => $regimeId,
                'aliment_id' => $alimentId,
                'pourcentage' => $pct,
            ]);
        }

        return redirect()->to('/admin/regime');
    }

    public function edit($id)
    {
        $regimeModel = new RegimeModel();
        $alimentModel = new AlimentModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $data['regime'] = $regimeModel->find($id);
        $data['aliments'] = $alimentModel->findAll();
        $rows = $regimeAlimentModel->where('regime_id', $id)->findAll();
        $data['regime_aliments'] = [];
        foreach ($rows as $row) {
            $data['regime_aliments'][(int) $row['aliment_id']] = (float) $row['pourcentage'];
        }

        return view('regime/edit', $data);
    }

    public function update($id)
    {
        $regimeModel = new RegimeModel();
        $regimeAlimentModel = new RegimeAlimentModel();

        $percentages = $this->request->getPost('percentage') ?? [];
        $selectedPercentages = [];
        $total = 0;

        foreach ($percentages as $alimentId => $pct) {
            $value = (float) $pct;
            if ($value > 0) {
                $selectedPercentages[(int) $alimentId] = $value;
                $total += $value;
            }
        }

        if (empty($selectedPercentages) || abs($total - 100) > 0.01) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%.');
        }

        $regimeModel->update($id, [
            'nom' => $this->request->getPost('nom'),
            'duree' => $this->request->getPost('duree'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description')
        ]);

        $regimeAlimentModel->where('regime_id', $id)->delete();
        foreach ($selectedPercentages as $alimentId => $pct) {
            $regimeAlimentModel->insert([
                'regime_id' => $id,
                'aliment_id' => $alimentId,
                'pourcentage' => $pct,
            ]);
        }

        return redirect()->to('/admin/regime');
    }

    public function delete($id)
    {
        $model = new RegimeModel();

        $model->delete($id);

        return redirect()->to('/admin/regime');
    }

}