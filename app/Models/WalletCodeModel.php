<?php namespace App\Models;

use CodeIgniter\Model;

class WalletCodeModel extends Model
{
    protected $table = 'wallet_codes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['code', 'value', 'status', 'user_id', 'requested_at', 'approved_at', 'rejected_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
