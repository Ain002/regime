-- Test data for regime app
-- Run: mysql -u user -p your_db < database/test_data.sql

SET FOREIGN_KEY_CHECKS = 0;

-- Abonnements
INSERT INTO abonnement (id, libelle, reduction) VALUES
(1, 'Free', 0.0),
(2, 'Premium', 20.0);

-- Users (password = "password")
-- bcrypt hash for 'password' (common test hash)
INSERT INTO users (id, nom, email, password, genre, taille, poids, abonnement_id) VALUES
(1, 'Alice Dupont', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.IlQpiX6a9rJNq5e.', 'F', 165.0, 60.0, 2),
(2, 'Bob Martin',   'bob@example.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.IlQpiX6a9rJNq5e.', 'H', 180.0, 85.0, NULL);

-- Wallets
INSERT INTO wallet (id, user_id, solde) VALUES
(1, 1, 50.00),
(2, 2, 10.00);

-- Wallet transactions
INSERT INTO wallet_transaction (id, wallet_id, montant, type_transaction) VALUES
(1, 1, 50.00, 'recharge'),
(2, 1, 10.00, 'achat'),
(3, 2, 10.00, 'recharge');

-- Code de recharge
INSERT INTO code_recharge (id, code, montant, used, used_by) VALUES
(1, 'RECH50', 50.00, FALSE, NULL),
(2, 'GIFT10', 10.00, TRUE, 2);

-- Objectifs
INSERT INTO objectif (id, description) VALUES
(1, 'Perdre 5 kg'),
(2, 'Gagner du muscle');

-- Objectif_user
INSERT INTO objectif_user (id, user_id, objectif_id) VALUES
(1, 1, 1),
(2, 2, 2);

-- Aliments
INSERT INTO aliment (id, nom, description, image, type_aliment) VALUES
(1, 'Poulet', 'Blanc de poulet, source de protéine', NULL, 'volaille'),
(2, 'Pomme', 'Pomme Rouge', NULL, 'fruit'),
(3, 'Brocoli', 'Brocoli frais', NULL, 'legume');

-- Regimes
INSERT INTO regime (id, nom, duree, variation_poids, prix, description) VALUES
(1, 'Régime Équilibré', 30, -2.5, 29.99, 'Repas équilibrés pour perte progressive de poids'),
(2, 'Régime Protéiné', 60, -3.5, 49.99, 'Alimentation riche en protéines pour préserver la masse musculaire');

-- Regime -> Aliments (pourcentages)
INSERT INTO regime_aliment (id, regime_id, aliment_id, pourcentage) VALUES
(1, 1, 1, 40.0),
(2, 1, 2, 30.0),
(3, 1, 3, 30.0),
(4, 2, 1, 60.0),
(5, 2, 3, 40.0);

-- Sports
INSERT INTO sport (id, nom, variation_poids, duree, description) VALUES
(1, 'Course', -1.0, 30, 'Course modérée 3x/semaine'),
(2, 'Musculation', -0.5, 45, 'Séances de musculation 3x/semaine');

-- Regime -> Sport
INSERT INTO regime_sport (id, regime_id, sport_id, frequence) VALUES
(1, 1, 1, 3),
(2, 2, 2, 3);

-- Achat regimes
INSERT INTO achat_regime (id, user_id, regime_id, prix_paye) VALUES
(1, 1, 1, 29.99);

SET FOREIGN_KEY_CHECKS = 1;

-- Notes:
-- Test accounts:
--  - alice@example.com / password
--  - bob@example.com / password

-- To import:
-- mysql -u <user> -p <database_name> < database/test_data.sql
