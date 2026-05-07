<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatRegimeModel extends Model
{
    protected $table = 'achat_regime';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'prix_paye'
    ];
}