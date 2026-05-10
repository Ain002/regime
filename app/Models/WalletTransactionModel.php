<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletTransactionModel extends Model
{
    protected $table = 'wallet_transactions';
    protected $primaryKey = 'id';
    // The table only has `created_at` (no `updated_at`).
    // Let CodeIgniter manage `created_at` but disable `updated_at`.
    protected $allowedFields = ['wallet_id', 'montant', 'type', 'user_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
}
