<?php namespace App\Models;

use CodeIgniter\Model;

class AlimentModel extends Model
{
    protected $table = 'aliment';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nom', 'description', 'image', 'type_aliment'];
    protected $useTimestamps = false;
}
