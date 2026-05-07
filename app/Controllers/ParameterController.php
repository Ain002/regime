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

    // FORM EDIT
    public function edit($id)
    {
        $model = new ParameterModel();
        $data['parameter'] = $model->find($id);

        if (!$data['parameter']) {
            return redirect()->to('/parameter')->with('error', 'Paramètre non trouvé.');
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

        return redirect()->to('/parameter')->with('success', 'Paramètre mis à jour.');
    }
}
