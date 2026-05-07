<?php

namespace App\Controllers;

use App\Models\AlimentModel;

class AlimentController extends BaseController
{
    public function index()
    {
        $model = new AlimentModel();
        $data['aliments'] = $model->findAll();

        return view('aliment/list', $data);
    }

    public function create()
    {
        return view('aliment/create');
    }

    public function store()
    {
        $model = new AlimentModel();

        $rules = [
            'nom' => 'required|min_length[2]',
            'type_aliment' => "required|in_list[viande,poisson,volaille,legume,fruit,autre]",
            'description' => 'permit_empty',
            'image' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nom' => $this->request->getPost('nom'),
            'type_aliment' => $this->request->getPost('type_aliment'),
            'description' => $this->request->getPost('description'),
            'image' => $this->request->getPost('image'),
        ]);

        return redirect()->to('/aliment')->with('success', 'Aliment ajouté.');
    }

    public function edit($id)
    {
        $model = new AlimentModel();
        $data['aliment'] = $model->find($id);

        if (! $data['aliment']) {
            return redirect()->to('/aliment')->with('error', 'Aliment non trouvé.');
        }

        return view('aliment/edit', $data);
    }

    public function update($id)
    {
        $model = new AlimentModel();

        $rules = [
            'nom' => 'required|min_length[2]',
            'type_aliment' => "required|in_list[viande,poisson,volaille,legume,fruit,autre]",
            'description' => 'permit_empty',
            'image' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'type_aliment' => $this->request->getPost('type_aliment'),
            'description' => $this->request->getPost('description'),
            'image' => $this->request->getPost('image'),
        ]);

        return redirect()->to('/aliment')->with('success', 'Aliment modifié.');
    }

    public function delete($id)
    {
        $model = new AlimentModel();
        $model->delete($id);

        return redirect()->to('/aliment')->with('success', 'Aliment supprimé.');
    }
}
