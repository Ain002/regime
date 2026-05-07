<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRechargeModel extends Model
{
    protected $table = 'code_recharge';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'code',
        'montant',
        'used',
        'used_by',
        'used_at'
    ];
}