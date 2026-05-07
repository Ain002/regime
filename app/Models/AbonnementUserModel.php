<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementUserModel extends Model
{
    protected $table = 'abonnement_user';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'abonnement_id',
        'date_achat',
        'date_expiration'
    ];

    public function isUserGold($userId){
        return $this->where('user_id', $userId)
                ->where('abonnement_id', 2) 
                ->where('date_expiration >', date('Y-m-d H:i:s'))
                ->orWhere('date_expiration', null) 
                ->first() !== null;
    }


}