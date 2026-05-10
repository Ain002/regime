USE regime;

-- -----------------------------------------------------
-- Données de base (id stables)
-- -----------------------------------------------------

INSERT IGNORE INTO type_user (id, code) VALUES
(1, 'user'),
(2, 'admin');

INSERT IGNORE INTO abonnement (id, libelle, prix, reduction) VALUES
(1, 'Standard', 0.00, 0.00),
(2, 'Gold', 15000.00, 10.00);

INSERT IGNORE INTO objectif (id, description) VALUES
(1, 'Perdre de poids'),
(2, 'Atteindre son IMC idéal'),
(3, 'Gagner de poids');

INSERT IGNORE INTO parameters (`key`, value, description) VALUES
('prix_base_regime_court', '1000', 'Prix par jour pour régime <= 7 jours'),
('prix_base_regime_moyen', '900', 'Prix par jour pour régime 8-30 jours'),
('prix_base_regime_long', '800', 'Prix par jour pour régime > 30 jours'),
('devise', 'Ar', 'Devise locale');

-- -----------------------------------------------------
-- Utilisateurs
-- Mot de passe seed: admin123 (hash bcrypt)
-- -----------------------------------------------------

INSERT IGNORE INTO users (id, nom, prenom, date_naissance, email, password, genre, taille, poids, type_user_id, abonnement_id) VALUES
(1, 'Admin', 'Système', '1985-01-01', 'admin@example.com', '$2y$10$5Z9FVZTDyvjN53RD9pcu7.k7P13842BR/dsJNMcuiaL3v9YN4NP4q', 'H', 180.00, 75.00, 2, NULL),
(2, 'users', 'users', '1990-05-15', 'roberto@example.com', '$2y$10$5Z9FVZTDyvjN53RD9pcu7.k7P13842BR/dsJNMcuiaL3v9YN4NP4q', 'H', 175.00, 85.00, 1, NULL),
(3, 'Marie', 'Rasoanaivo', '1995-08-22', 'marie@example.com', '$2y$10$5Z9FVZTDyvjN53RD9pcu7.k7P13842BR/dsJNMcuiaL3v9YN4NP4q', 'F', 165.00, 62.00, 1, NULL);

INSERT IGNORE INTO objectif_user (user_id, objectif_id, date_choix) VALUES
(2, 1, NOW()),
(3, 2, NOW());

-- -----------------------------------------------------
-- Catalogue: aliments, sports, régimes
-- -----------------------------------------------------

INSERT IGNORE INTO aliment (id, nom, description, image, type_aliment) VALUES
(1, 'Poulet', 'Viande blanche maigre', NULL, 'volaille'),
(2, 'Boeuf', 'Viande rouge maigre', NULL, 'viande'),
(3, 'Poisson blanc', 'Riche en protéines', NULL, 'poisson'),
(4, 'Saumon', 'Riche en oméga-3', NULL, 'poisson'),
(5, 'Jambon', 'Apport protéique', NULL, 'viande'),
(6, 'Dinde', 'Faible en gras', NULL, 'volaille');

INSERT IGNORE INTO sport (id, nom, variation_poids, duree, description) VALUES
(1, 'Marche rapide', 3.50, 30, 'Marche à 5.5 km/h'),
(2, 'Course', 8.00, 30, 'Course à 9.7 km/h'),
(3, 'Vélo', 6.00, 45, 'Vélo à intensité modérée'),
(4, 'Natation', 7.00, 45, 'Natation modérée'),
(5, 'Musculation', 6.00, 60, 'Entraînement avec poids');

INSERT IGNORE INTO regime (id, nom, duree, variation_poids, prix_base, prix, prix_gold, description) VALUES
(1, 'Régime Faible Calorie', 7, -5.00, 1000.00, 7000.00, 5950.00, 'Perdre 5kg en 1 semaine'),
(2, 'Régime Équilibré', 14, -3.50, 900.00, 12600.00, 10710.00, 'Perdre 3.5kg en 2 semaines'),
(3, 'Régime Perte Rapide', 10, -7.00, 800.00, 8000.00, 6800.00, 'Perdre 7kg en 10 jours'),
(4, 'Régime Gain Musculaire', 21, 4.50, 900.00, 18900.00, 16065.00, 'Gagner 4.5kg en 3 semaines'),
(5, 'Régime Maintenance', 30, 0.50, 800.00, 24000.00, 20400.00, 'Maintenir le poids idéal');

INSERT IGNORE INTO regime_aliment (regime_id, aliment_id, pourcentage, pourcentage_viande, pourcentage_poisson, pourcentage_volaille) VALUES
(1, 1, 100, 20, 30, 50),
(1, 3, 100, 10, 70, 20),
(1, 4, 100, 5, 80, 15),
(1, 5, 100, 60, 20, 20),
(1, 6, 100, 15, 25, 60),
(2, 1, 100, 25, 25, 50),
(2, 2, 100, 70, 20, 10),
(2, 3, 100, 15, 70, 15),
(2, 4, 100, 10, 75, 15),
(2, 6, 100, 20, 30, 50),
(3, 3, 100, 10, 80, 10),
(3, 4, 100, 5, 85, 10),
(3, 6, 100, 20, 30, 50),
(3, 1, 100, 40, 20, 40),
(4, 2, 100, 80, 10, 10),
(4, 1, 100, 30, 25, 45),
(4, 6, 100, 25, 35, 40),
(4, 5, 100, 75, 15, 10),
(5, 1, 100, 25, 25, 50),
(5, 2, 100, 60, 20, 20),
(5, 3, 100, 15, 70, 15),
(5, 4, 100, 10, 75, 15),
(5, 6, 100, 25, 30, 45);

INSERT IGNORE INTO regime_sport (regime_id, sport_id, frequence_semaine, duree_minutes, intensite) VALUES
(1, 2, 5, 30, 'élevée'),
(1, 1, 3, 45, 'modérée'),
(2, 3, 4, 45, 'modérée'),
(2, 1, 3, 30, 'faible'),
(3, 2, 6, 40, 'élevée'),
(3, 4, 2, 45, 'modérée'),
(4, 5, 5, 60, 'modérée'),
(4, 2, 3, 20, 'faible'),
(5, 1, 3, 30, 'faible'),
(5, 3, 2, 45, 'faible');

-- -----------------------------------------------------
-- Wallet + dashboard data
-- -----------------------------------------------------

INSERT IGNORE INTO wallet (user_id, solde) VALUES
(2, 50000.00),
(3, 72000.00);

INSERT IGNORE INTO wallet_transactions (wallet_id, montant, type, created_at, user_id) VALUES
(1, 10000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 30 DAY), 2),
(1, 7000.00, 'achat', DATE_SUB(NOW(), INTERVAL 25 DAY), 2),
(1, 20000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 20 DAY), 2),
(1, 12600.00, 'achat', DATE_SUB(NOW(), INTERVAL 17 DAY), 2),
(1, 5000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 12 DAY), 2),
(2, 15000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 28 DAY), 3),
(2, 8000.00, 'achat', DATE_SUB(NOW(), INTERVAL 22 DAY), 3),
(2, 25000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 10 DAY), 3),
(2, 18900.00, 'achat', DATE_SUB(NOW(), INTERVAL 7 DAY), 3),
(2, 10000.00, 'recharge', DATE_SUB(NOW(), INTERVAL 3 DAY), 3);

INSERT IGNORE INTO wallet_codes (code, value, status, user_id, requested_at, approved_at, rejected_at, created_at, updated_at) VALUES
('CODE2026-001', 10000.00, 'available', NULL, NULL, NULL, NULL, NOW(), NOW()),
('CODE2026-002', 20000.00, 'available', NULL, NULL, NULL, NULL, NOW(), NOW()),
('CODE2026-003', 50000.00, 'used', 2, DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_SUB(NOW(), INTERVAL 9 DAY), NULL, DATE_SUB(NOW(), INTERVAL 20 DAY), NOW()),
('CODE2026-004', 15000.00, 'pending', 3, DATE_SUB(NOW(), INTERVAL 2 DAY), NULL, NULL, DATE_SUB(NOW(), INTERVAL 5 DAY), NOW()),
('CODE2026-005', 8000.00, 'approved', 2, DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, DATE_SUB(NOW(), INTERVAL 8 DAY), NOW()),
('CODE2026-006', 12000.00, 'rejected', 3, DATE_SUB(NOW(), INTERVAL 4 DAY), NULL, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 9 DAY), NOW());

INSERT IGNORE INTO achat_regime (user_id, regime_id, prix_paye, date_achat, statut, date_expiration) VALUES
(2, 1, 7000.00, DATE_SUB(NOW(), INTERVAL 25 DAY), 'completed', DATE_SUB(NOW(), INTERVAL 18 DAY)),
(2, 2, 12600.00, DATE_SUB(NOW(), INTERVAL 17 DAY), 'completed', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 3, 8000.00, DATE_SUB(NOW(), INTERVAL 22 DAY), 'completed', DATE_SUB(NOW(), INTERVAL 12 DAY)),
(3, 4, 18900.00, DATE_SUB(NOW(), INTERVAL 7 DAY), 'pending', DATE_ADD(NOW(), INTERVAL 14 DAY));

INSERT IGNORE INTO abonnement_user (user_id, abonnement_id, date_achat, date_expiration) VALUES
(2, 2, DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY)),
(3, 2, DATE_SUB(NOW(), INTERVAL 20 DAY), DATE_ADD(NOW(), INTERVAL 40 DAY));
