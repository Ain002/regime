<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regime';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['nom','duree','variation_poids','prix'];

}