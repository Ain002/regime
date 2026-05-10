<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeSportModel extends Model
{
    protected $table            = 'regime_sport';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['regime_id', 'sport_id', 'frequence_semaine', 'duree_minutes', 'intensite'];
    protected $useTimestamps    = false;

    // Get all sports for a regime with details
    public function getSportsForRegime($regimeId)
    {
        return $this->select('regime_sport.*,  sport.id as sport_id, sport.nom, sport.description, sport.variation_poids, sport.duree')
            ->join('sport', 'sport.id = regime_sport.sport_id')
            ->where('regime_sport.regime_id', $regimeId)
            ->findAll();
    }

    // Delete all sports for a regime
    public function deleteByRegime($regimeId)
    {
        return $this->where('regime_id', $regimeId)->delete();
    }
}
