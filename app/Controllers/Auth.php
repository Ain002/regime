<?php

namespace App\Controllers;

use App\Functions\AuthFunctions;

class Auth extends BaseController
{
    private $authFunctions;

    public function __construct()
    {
        $this->authFunctions = new AuthFunctions();
    }
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function authenticate()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/login');
        }

        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validation
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Authenticate using AuthFunctions
        $user = $this->authFunctions->authenticate($email, $password);

        if ($user) {
            // Connexion réussie
            $session->set([
                'user_id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'isLoggedIn' => true,
            ]);

            // Si profil incomplet, rediriger vers la complétion
            if (empty($user['taille']) || empty($user['poids'])) {
                return redirect()->to('/profile/complete')->with('success', 'Bienvenue ' . $user['nom'] . '! Complétez votre profil.');
            }

            return redirect()->to('/')->with('success', 'Bienvenue ' . $user['nom'] . '!');
        } else {
            // Identifiants incorrects
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Vous avez été déconnecté.');
    }

    public function registerSubmit()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/register');
        }

        // Validation côté serveur
        if (!$this->validate([
            'nom' => 'required|min_length[2]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nom = $this->request->getPost('nom');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $genre = $this->request->getPost('genre') ?? null;

        // Register using AuthFunctions
        $insertId = $this->authFunctions->register($nom, $email, $password, $genre);

        if ($insertId) {
            $user = $this->authFunctions->getUserById($insertId);
            session()->set([
                'user_id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/profile/complete')->with('success', 'Inscription réussie. Complétez votre profil.');
        }

        return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'inscription.');
    }

    public function completeProfile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user = $this->authFunctions->getUserById($session->get('user_id'));

        return view('auth/complete_profile', ['user' => $user]);
    }

    public function completeProfileSubmit()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/profile/complete');
        }

        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!$this->validate([
            'taille' => 'required|numeric',
            'poids' => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $taille = $this->request->getPost('taille');
        $poids = $this->request->getPost('poids');
        $abonnement_id = $this->request->getPost('abonnement_id') ?: null;

        // Update profile using AuthFunctions
        $this->authFunctions->completeProfile($session->get('user_id'), $taille, $poids, $abonnement_id);

        return redirect()->to('/')->with('success', 'Profil complété.');
    }
}
