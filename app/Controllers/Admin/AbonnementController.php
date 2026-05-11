<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AbonnementModel;

class AbonnementController extends BaseController
{
    // Liste des abonnements
    public function index()
    {
        $model = new AbonnementModel();
        $data['abonnements'] = $model->findAll();
        return view('admin/abonnement/list', $data);
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $model = new AbonnementModel();
        $data['abonnement'] = $model->find($id);
        
        if (!$data['abonnement']) {
            return redirect()->to('/admin/abonnements')->with('error', 'Abonnement non trouvé.');
        }
        
        return view('admin/abonnement/edit', $data);
    }

    // Mise à jour
    public function update($id)
    {
        $model = new AbonnementModel();
        $abonnement = $model->find($id);
        
        if (!$abonnement) {
            return redirect()->to('/admin/abonnements')->with('error', 'Abonnement non trouvé.');
        }

        $rules = [
            'libelle' => 'required',
            'prix' => 'required|numeric',
            'reduction' => 'permit_empty|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('abonnement')->where('id', $id)->update([
            'libelle' => $this->request->getPost('libelle'),
            'prix' => (float)$this->request->getPost('prix'),
            'reduction' => $this->request->getPost('reduction') ?? 0
        ]);

        return redirect()->to('/admin/abonnements')->with('success', 'Abonnement mis à jour avec succès.');
    }
}
