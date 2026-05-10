<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\ObjectifUserModel;
use App\Models\UserModel;

class ObjectifController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }

        if (!$user) {
            return redirect()->to('/login');
        }

        $objectifModel = new ObjectifModel();
        $objectifUserModel = new ObjectifUserModel();

        // Récupérer tous les objectifs
        $objectifs = $objectifModel->findAll();

        // Récupérer l'objectif actuel de l'utilisateur
        $currentObjectif = $objectifUserModel->getLatestObjectifByUserId($user['id']);

        return view('objectif/index', [
            'user' => $user,
            'objectifs' => $objectifs,
            'currentObjectif' => $currentObjectif
        ]);
    }

    public function choose()
    {
        $user = session()->get('user');
        if (!$user && session()->get('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }

        if (!$user) {
            return redirect()->to('/login');
        }

        $objectifId = $this->request->getPost('objectif_id');
        if (!$objectifId) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un objectif.');
        }

        $objectifUserModel = new ObjectifUserModel();
        $objectifUserModel->insert([
            'user_id' => $user['id'],
            'objectif_id' => $objectifId,
            'date_choix' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/recommendation')->with('success', 'Objectif mis à jour avec succès !');
    }
}
