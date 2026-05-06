<?php
// Script pour générer un hash bcrypt valide pour le mot de passe "password"
$password = "password";
$hash = password_hash($password, PASSWORD_BCRYPT);

echo "Mot de passe : " . $password . "\n";
echo "Hash bcrypt : " . $hash . "\n";
echo "\n";
echo "Commande SQL à exécuter :\n";
echo "UPDATE users SET password = '" . $hash . "' WHERE email IN ('alice@example.com', 'bob@example.com');\n";
?>
