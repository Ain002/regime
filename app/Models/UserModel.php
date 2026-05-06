<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nom',
        'email',
        'password',
        'genre',
        'taille',
        'poids',
        'abonnement_id',
    ];

    // Validation rules
    protected $validationRules = [
        'nom' => 'required|string|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'genre' => 'required|in_list[H,F]',
        'taille' => 'required|numeric',
        'poids' => 'required|numeric',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est requis',
            'string' => 'Le nom doit être du texte',
            'max_length' => 'Le nom ne peut pas dépasser 255 caractères',
        ],
        'email' => [
            'required' => 'L\'email est requis',
            'valid_email' => 'L\'email doit être valide',
            'is_unique' => 'Cet email est déjà utilisé',
        ],
        'password' => [
            'required' => 'Le mot de passe est requis',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères',
        ],
        'genre' => [
            'required' => 'Le genre est requis',
            'in_list' => 'Le genre doit être H ou F',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
