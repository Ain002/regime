<?php

namespace App\Controllers;

use App\Models\ParameterModel;

class ParameterController extends BaseController
{
    // LISTE
    public function index()
    {
        $model = new ParameterModel();
        $data['parameters'] = $model->findAll();
        return view('parameter/list', $data);
    }

    // FORM CREATE
    public function create()
    {
        return view('parameter/create');
    }

    // STORE (créer nouveau paramètre)
    public function store()
    {
        $model = new ParameterModel();

        $rules = [
            'key' => 'required|is_unique[parameters.key]',
            'value' => 'required',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'key' => $this->request->getPost('key'),
            'value' => $this->request->getPost('value'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/parameter')->with('success', 'Paramètre créé avec succès.');
    }

    // FORM EDIT
    public function edit($id)
    {
        $model = new ParameterModel();
        $data['parameter'] = $model->find($id);

        if (!$data['parameter']) {
            return redirect()->to('/admin/parameter')->with('error', 'Paramètre non trouvé.');
        }

        return view('parameter/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $model = new ParameterModel();

        $rules = [
            'value' => 'required',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'value' => $this->request->getPost('value'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/parameter')->with('success', 'Paramètre mis à jour.');
    }

    // DELETE
    public function delete($id)
    {
        $model = new ParameterModel();
        $param = $model->find($id);

        if (!$param) {
            return redirect()->to('/admin/parameter')->with('error', 'Paramètre non trouvé.');
        }

        $model->delete($id);

        return redirect()->to('/admin/parameter')->with('success', 'Paramètre supprimé.');
    }
}
