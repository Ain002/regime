<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    /**
     * Affiche le formulaire de profil
     */
    public function index()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to('/login');
        }

        return view('profile/index', ['user' => $user]);
    }

    /**
     * Traite la mise à jour du profil
     */
    public function update()
    {
        $user = $this->getCurrentUser();
        if (!$user) return redirect()->to('/login');

        $userModel = new UserModel();

        // Préparation des données de base
        $data = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'genre'          => $this->request->getPost('genre'),
            'taille'         => $this->request->getPost('taille'),
            'poids'          => $this->request->getPost('poids'),
            'date_naissance' => $this->request->getPost('date_naissance')
        ];

        // Password optionnel : On ne l'ajoute que s'il est rempli
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password; 
        }

        // Validation dynamique pour l'email
        $userModel->setValidationRule('email', "required|valid_email|is_unique[users.email,id,{$user['id']}]");

        if (!$userModel->update($user['id'], $data)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        // Rafraîchir la session avec les nouvelles données
        session()->set('user', $userModel->find($user['id']));

        return redirect()->to('/profile')->with('success', 'Profil mis à jour avec succès ✨');
    }

    /**
     * Méthode utilitaire pour éviter la répétition de code
     */
    private function getCurrentUser()
    {
        $user = session()->get('user');
        if (!$user && session()->has('user_id')) {
            $user = (new UserModel())->find(session()->get('user_id'));
            session()->set('user', $user);
        }
        return $user;
    }
}