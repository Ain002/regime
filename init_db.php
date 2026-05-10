<?php
// Script pour initialiser la base de données
require_once __DIR__ . '/public/index.php';

// Créer une instance de la base de données
$db = \Config\Database::connect();

// Lire et exécuter schema.sql
echo "Exécution de schema.sql...\n";
$schemaSQL = file_get_contents(__DIR__ . '/database/schema.sql');
$queries = array_filter(array_map('trim', explode(';', $schemaSQL)));

foreach ($queries as $query) {
    if (!empty($query) && strpos($query, '--') !== 0) {
        try {
            $db->query($query);
            echo "✓ Requête exécutée\n";
        } catch (\Exception $e) {
            echo "✗ Erreur: " . $e->getMessage() . "\n";
        }
    }
}

// Lire et exécuter seed.sql
echo "\nExécution de seed.sql...\n";
$seedSQL = file_get_contents(__DIR__ . '/database/seed.sql');
$queries = array_filter(array_map('trim', explode(';', $seedSQL)));

foreach ($queries as $query) {
    if (!empty($query) && strpos($query, '--') !== 0) {
        try {
            $db->query($query);
            echo "✓ Données insérées\n";
        } catch (\Exception $e) {
            echo "✗ Erreur: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n✅ Initialisation terminée!\n";
?>
