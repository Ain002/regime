<?php

namespace App\Models;

use CodeIgniter\Model;


class AbonnementUserModel extends Model
{
    protected $table = 'abonnement_user';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id','abonnement_id','date_achat','date_expiration'];

}