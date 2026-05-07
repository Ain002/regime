<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regime';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'duree',
        'variation_poids',
        'prix',
        'description'
    ];

    public function getFullProgram($id)
    {
        $regime = $this->find($id);

        if (!$regime) {
            return null;
        }

        $aliments = $this->db->table('regime_aliment')
            ->select('
                aliment.id,
                aliment.nom,
                aliment.description,
                aliment.image,
                aliment.type_aliment,

                regime_aliment.pourcentage
            ')
            ->join(
                'aliment',
                'aliment.id = regime_aliment.aliment_id'
            )
            ->where('regime_aliment.regime_id', $id)
            ->get()
            ->getResultArray();

        $sports = $this->db->table('regime_sport')
            ->select('
                sport.id,
                sport.nom,
                sport.description,
                sport.variation_poids,
                sport.duree,

                regime_sport.frequence_semaine,
                regime_sport.duree_minutes,
                regime_sport.intensite
            ')
            ->join(
                'sport',
                'sport.id = regime_sport.sport_id'
            )
            ->where('regime_sport.regime_id', $id)
            ->get()
            ->getResultArray();


        $regime['aliments'] = $aliments;

        $regime['sports'] = $sports;

        $variationSport = 0;

        foreach ($sports as $sport) {

            $variationSport += $sport['variation_poids'];
        }

        $regime['variation_totale'] =
            $regime['variation_poids'] + $variationSport;

        return $regime;
    }
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['nom','duree','variation_poids','prix'];

}