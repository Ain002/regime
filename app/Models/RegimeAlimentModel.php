<?php namespace App\Models;

use CodeIgniter\Model;

class RegimeAlimentModel extends Model
{
    protected $table = 'regime_aliment';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['regime_id', 'aliment_id', 'pourcentage'];
    protected $useTimestamps = false;
}
