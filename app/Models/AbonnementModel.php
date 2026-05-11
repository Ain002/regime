<?php

namespace App\Models;

use CodeIgniter\Model;

class AbonnementModel extends Model
{
    protected $table = 'abonnement';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['libelle','reduction','prix'];
    protected $protectFields = false;

}