<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifUserModel extends Model
{
    protected $table      = 'objectif_user';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'objectif_id',
        'date_choix'
    ];

    
    public function getLatestObjectifByUserId($userId)
    {
        return $this->select('o.description')
                    ->from('objectif_user ou') // Alias pour la table principale
                    ->join('objectif o', 'o.id = ou.objectif_id')
                    ->where('ou.user_id', $userId)
                    ->orderBy('ou.date_choix', 'DESC')
                    ->first(); // Retourne directement le premier résultat ou null
    }
}