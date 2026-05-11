<?php

namespace App\Controllers;

use App\Models\ActivityModel;

class ActivityController extends BaseController
{
    // LISTE
    public function index()
    {
        $model = new ActivityModel();
        $data['activities'] = $model->findAll();
        return view('activity/list', $data);
    }

    // FORM CREATE
    public function create()
    {
        return view('activity/create');
    }

    // STORE
    public function store()
    {
        $model = new ActivityModel();

        $rules = [
            'nom' => 'required|min_length[2]',
            'variation_poids' => 'required|numeric',
            'duree' => 'required|integer|greater_than[0]',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nom' => $this->request->getPost('nom'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'duree' => (int) $this->request->getPost('duree'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/activity');
    }

    // FORM EDIT
    public function edit($id)
    {
        $model = new ActivityModel();
        $data['activity'] = $model->find($id);

        if (!$data['activity']) {
            return redirect()->to('/admin/activity')->with('error', 'Activité non trouvée.');
        }

        return view('activity/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $model = new ActivityModel();

        $rules = [
            'nom' => 'required|min_length[2]',
            'variation_poids' => 'required|numeric',
            'duree' => 'required|integer|greater_than[0]',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'duree' => (int) $this->request->getPost('duree'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/activity');
    }

    // DELETE
    public function delete($id)
    {
        $model = new ActivityModel();
        $model->delete($id);
        return redirect()->to('/admin/activity');
    }
}
