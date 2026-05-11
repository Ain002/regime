<?php namespace App\Models;

use CodeIgniter\Model;

class ParameterModel extends Model
{
    protected $table = 'parameters';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['key', 'value', 'description'];
    protected $useTimestamps = false;
}
