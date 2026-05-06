<?php

namespace App\Functions;

use App\Models\UserModel;

class AuthFunctions
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Authenticate user with email and password
     * Returns user data or null
     */
    public function authenticate($email, $password)
    {
        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Register new user
     * Returns user ID or false
     */
    public function register($nom, $email, $password, $genre = null)
    {
        $data = [
            'nom' => $nom,
            'email' => $email,
            'password' => $password,
            'genre' => $genre,
        ];

        $this->userModel->skipValidation(true);
        $userId = $this->userModel->insert($data);

        return $userId;
    }

    /**
     * Get user by ID
     */
    public function getUserById($userId)
    {
        return $this->userModel->find($userId);
    }

    /**
     * Complete user profile
     */
    public function completeProfile($userId, $taille, $poids, $abonnement_id = null)
    {
        $data = [
            'taille' => $taille,
            'poids' => $poids,
        ];

        if ($abonnement_id) {
            $data['abonnement_id'] = $abonnement_id;
        }

        return $this->userModel->update($userId, $data);
    }

    /**
     * Check if email exists
     */
    public function emailExists($email)
    {
        return $this->userModel->where('email', $email)->first() !== null;
    }
}
