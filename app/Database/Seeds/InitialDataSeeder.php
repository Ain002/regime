<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Insert objectif
        $data = [
            ['description' => 'Perdre de poids'],
            ['description' => 'Atteindre son IMC idéal'],
            ['description' => 'Gagner de poids'],
        ];

        foreach ($data as $row) {
            $this->db->table('objectif')->insert($row);
        }

        // Insert regimes
        $regimes = [
            ['nom' => 'Régime Faible Calorie', 'duree' => 7, 'variation_poids' => -5.00, 'prix' => 7000.00, 'description' => 'Perdre 5kg en 1 semaine'],
            ['nom' => 'Régime Équilibré', 'duree' => 14, 'variation_poids' => -3.50, 'prix' => 12600.00, 'description' => 'Perdre 3.5kg en 2 semaines'],
            ['nom' => 'Régime Perte Rapide', 'duree' => 10, 'variation_poids' => -7.00, 'prix' => 8000.00, 'description' => 'Perdre 7kg en 10 jours'],
            ['nom' => 'Régime Gain Musculaire', 'duree' => 21, 'variation_poids' => 4.50, 'prix' => 18900.00, 'description' => 'Gagner 4.5kg en 3 semaines'],
            ['nom' => 'Régime Maintenance', 'duree' => 30, 'variation_poids' => 0.50, 'prix' => 24000.00, 'description' => 'Maintenir le poids idéal'],
        ];

        foreach ($regimes as $regime) {
            $this->db->table('regime')->insert($regime);
        }

        // Insert regime_aliment
        $regimeAliments = [
            // Regime 1
            ['regime_id' => 1, 'aliment_id' => 1, 'pourcentage' => 30],
            ['regime_id' => 1, 'aliment_id' => 3, 'pourcentage' => 25],
            ['regime_id' => 1, 'aliment_id' => 4, 'pourcentage' => 20],
            ['regime_id' => 1, 'aliment_id' => 5, 'pourcentage' => 15],
            ['regime_id' => 1, 'aliment_id' => 6, 'pourcentage' => 10],
            // Regime 2
            ['regime_id' => 2, 'aliment_id' => 1, 'pourcentage' => 25],
            ['regime_id' => 2, 'aliment_id' => 2, 'pourcentage' => 20],
            ['regime_id' => 2, 'aliment_id' => 3, 'pourcentage' => 25],
            ['regime_id' => 2, 'aliment_id' => 4, 'pourcentage' => 20],
            ['regime_id' => 2, 'aliment_id' => 6, 'pourcentage' => 10],
            // Regime 3
            ['regime_id' => 3, 'aliment_id' => 3, 'pourcentage' => 40],
            ['regime_id' => 3, 'aliment_id' => 4, 'pourcentage' => 30],
            ['regime_id' => 3, 'aliment_id' => 6, 'pourcentage' => 20],
            ['regime_id' => 3, 'aliment_id' => 1, 'pourcentage' => 10],
            // Regime 4
            ['regime_id' => 4, 'aliment_id' => 2, 'pourcentage' => 35],
            ['regime_id' => 4, 'aliment_id' => 1, 'pourcentage' => 30],
            ['regime_id' => 4, 'aliment_id' => 6, 'pourcentage' => 25],
            ['regime_id' => 4, 'aliment_id' => 5, 'pourcentage' => 10],
            // Regime 5
            ['regime_id' => 5, 'aliment_id' => 1, 'pourcentage' => 20],
            ['regime_id' => 5, 'aliment_id' => 2, 'pourcentage' => 20],
            ['regime_id' => 5, 'aliment_id' => 3, 'pourcentage' => 20],
            ['regime_id' => 5, 'aliment_id' => 4, 'pourcentage' => 20],
            ['regime_id' => 5, 'aliment_id' => 6, 'pourcentage' => 20],
        ];

        foreach ($regimeAliments as $row) {
            $this->db->table('regime_aliment')->insert($row);
        }

        // Insert regime_sport
        $regimeSports = [
            // Regime 1
            ['regime_id' => 1, 'sport_id' => 2, 'frequence_semaine' => 5, 'duree_minutes' => 30, 'intensite' => 'élevée'],
            ['regime_id' => 1, 'sport_id' => 1, 'frequence_semaine' => 3, 'duree_minutes' => 45, 'intensite' => 'modérée'],
            // Regime 2
            ['regime_id' => 2, 'sport_id' => 3, 'frequence_semaine' => 4, 'duree_minutes' => 45, 'intensite' => 'modérée'],
            ['regime_id' => 2, 'sport_id' => 1, 'frequence_semaine' => 3, 'duree_minutes' => 30, 'intensite' => 'faible'],
            // Regime 3
            ['regime_id' => 3, 'sport_id' => 2, 'frequence_semaine' => 6, 'duree_minutes' => 40, 'intensite' => 'élevée'],
            ['regime_id' => 3, 'sport_id' => 4, 'frequence_semaine' => 2, 'duree_minutes' => 45, 'intensite' => 'modérée'],
            // Regime 4
            ['regime_id' => 4, 'sport_id' => 5, 'frequence_semaine' => 5, 'duree_minutes' => 60, 'intensite' => 'modérée'],
            ['regime_id' => 4, 'sport_id' => 2, 'frequence_semaine' => 3, 'duree_minutes' => 20, 'intensite' => 'faible'],
            // Regime 5
            ['regime_id' => 5, 'sport_id' => 1, 'frequence_semaine' => 3, 'duree_minutes' => 30, 'intensite' => 'faible'],
            ['regime_id' => 5, 'sport_id' => 3, 'frequence_semaine' => 2, 'duree_minutes' => 45, 'intensite' => 'faible'],
        ];

        foreach ($regimeSports as $row) {
            $this->db->table('regime_sport')->insert($row);
        }

        echo "Data seeded successfully!";
    }
}
