<?php

namespace App\Controllers;

class InitDB extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        try {
            // Lire et exécuter schema.sql
            echo "<h2>Exécution de schema.sql...</h2>";
            $schemaSQL = file_get_contents(APPPATH . '../database/schema.sql');
            $queries = array_filter(array_map('trim', explode(';', $schemaSQL)));

            foreach ($queries as $query) {
                if (!empty($query) && strpos($query, '--') !== 0) {
                    try {
                        $db->query($query);
                        echo "✓ Requête exécutée<br>";
                    } catch (\Exception $e) {
                        echo "✗ Erreur: " . $e->getMessage() . "<br>";
                    }
                }
            }

            // Lire et exécuter seed.sql
            echo "<h2>Exécution de seed.sql...</h2>";
            $seedSQL = file_get_contents(APPPATH . '../database/seed.sql');
            $queries = array_filter(array_map('trim', explode(';', $seedSQL)));

            foreach ($queries as $query) {
                if (!empty($query) && strpos($query, '--') !== 0) {
                    try {
                        $db->query($query);
                        echo "✓ Données insérées<br>";
                    } catch (\Exception $e) {
                        echo "✗ Erreur: " . $e->getMessage() . "<br>";
                    }
                }
            }

            echo "<h2>✅ Initialisation terminée!</h2>";
        } catch (\Exception $e) {
            echo "Erreur générale: " . $e->getMessage();
        }
    }
}
