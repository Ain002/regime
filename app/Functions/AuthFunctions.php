<?php

namespace App\Functions;

use App\Models\UserModel;
use Config\Database;

class AuthFunctions
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = Database::connect();
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
    public function register($nom, $prenom, $dateNaissance, $email, $password, $genre, $taille, $poids)
    {
        $data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $dateNaissance,
            'email' => $email,
            'password' => $password,
            'genre' => $genre,
            'taille' => $taille,
            'poids' => $poids,
            'type_user_id' => 1,
        ];

        $this->userModel->skipValidation(true);
        $userId = $this->userModel->insert($data);

        return $userId;
    }

    /**
     * Save selected user objective
     */
    public function saveUserObjective($userId, $objectifCode)
    {
        $descriptionMap = [
            'lose_weight' => 'Réduire son poids',
            'ideal_bmi' => 'Atteindre son IMC idéal',
            'gain_weight' => 'Augmenter son poids',
        ];

        if (!isset($descriptionMap[$objectifCode])) {
            return false;
        }

        $description = $descriptionMap[$objectifCode];
        $objectifTable = $this->db->table('objectif');
        $objectifUserTable = $this->db->table('objectif_user');

        $objectif = $objectifTable->where('description', $description)->get()->getRowArray();

        if (!$objectif) {
            $objectifTable->insert(['description' => $description]);
            $objectifId = $this->db->insertID();
        } else {
            $objectifId = $objectif['id'];
        }

        $objectifUserTable->where('user_id', $userId)->delete();

        return $objectifUserTable->insert([
            'user_id' => $userId,
            'objectif_id' => $objectifId,
        ]);
    }

    /**
     * Get user by ID
     */
    public function getUserById($userId)
    {
        return $this->userModel->find($userId);
    }

    /**
     * Get a user by nom and type_user_id
     */
    public function getUserByNameAndType($nom, $typeUserId)
    {
        return $this->userModel->where('nom', $nom)->where('type_user_id', $typeUserId)->first();
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
