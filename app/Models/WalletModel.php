<?php

namespace App\Models;

use CodeIgniter\Model;


class WalletModel extends Model
{
    protected $table = 'wallet';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id','solde'];
        public function getSoldeByUserId($userId)
        {
            $result = $this->where('user_id', $userId)->first();
            return $result ? $result['solde'] : 0;
        }

}