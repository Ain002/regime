<?php

namespace App\Controllers;

use App\Models\RegimeModel;

class RegimeController extends BaseController{
    public function index()
    {
        $model = new RegimeModel();

        $data['regimes'] = $model->findAll();

        return view('regime/index', $data);
    }

    public function create()
    {
        return view('regime/create');
    }

    public function store()
    {
        $model = new RegimeModel();

        $model->save([
            'nom' => $this->request->getPost('nom'),
            'duree' => $this->request->getPost('duree'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/regime');
    }

    public function edit($id)
    {
        $model = new RegimeModel();

        $data['regime'] = $model->find($id);

        return view('regime/edit', $data);
    }

    public function update($id)
    {
        $model = new RegimeModel();

        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'duree' => $this->request->getPost('duree'),
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix' => $this->request->getPost('prix'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/regime');
    }

    public function delete($id)
    {
        $model = new RegimeModel();

        $model->delete($id);

        return redirect()->to('/regime');
    }

}