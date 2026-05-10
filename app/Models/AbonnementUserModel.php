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

    public function isUserGold($userId)
    {
        return $this->groupStart()
                ->where('date_expiration >', date('Y-m-d H:i:s'))
                ->orWhere('date_expiration IS NULL', null, false)
            ->groupEnd()
            ->where('user_id', $userId)
            ->where('abonnement_id', 2)
            ->first() !== null;
    }

    public static function applyGoldDiscount(float $price, bool $isGold): float
    {
        return $isGold ? round($price * 0.85, 2) : round($price, 2);
    }


}