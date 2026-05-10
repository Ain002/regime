<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletTransactionModel extends Model
{
    protected $table = 'wallet_transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['wallet_id', 'montant', 'type', 'user_id', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}
