
-- Types d'utilisateurs
INSERT IGNORE INTO type_user (id, code) VALUES
(1, 'user'),
(2, 'admin');

-- Abonnements
INSERT IGNORE INTO abonnement (id, libelle, prix, reduction) VALUES
(1, 'Standard', 0.00, 0.00),
(2, 'Gold', 0.00, 0.00);

-- Utilisateurs
INSERT IGNORE INTO users (nom, prenom, date_naissance, email, password, genre, taille, poids, type_user_id) VALUES
('Roberto', 'Carlos', '1990-05-15', 'roberto@example.com', '$2y$10$5Z9FVZTDyvjN53RD9pcu7.k7P13842BR/dsJNMcuiaL3v9YN4NP4q', 'H', 1.75, 85.00, 1),
('Admin', 'Système', '1985-01-01', 'admin@example.com', '$2y$10$5Z9FVZTDyvjN53RD9pcu7.k7P13842BR/dsJNMcuiaL3v9YN4NP4q', 'H', 1.80, 75.00, 2);

-- Objectifs
INSERT IGNORE INTO objectif (id, description) VALUES
(1, 'Perdre de poids'),
(2, 'Atteindre son IMC idéal'),
(3, 'Gagner de poids');

-- Aliments
INSERT IGNORE INTO aliment (nom, description, image, type_aliment) VALUES
('Poulet', NULL, NULL, 'volaille'),
('Boeuf', NULL, NULL, 'viande'),
('Poisson blanc', NULL, NULL, 'poisson'),
('Saumon', NULL, NULL, 'poisson'),
('Jambon', NULL, NULL, 'viande'),
('Dinde', NULL, NULL, 'volaille');

-- Sports
INSERT IGNORE INTO sport (nom, variation_poids, duree, description) VALUES
('Marche rapide', 3.50, 30, 'Marche à 5.5 km/h'),
('Course', 8.00, 30, 'Course à 9.7 km/h'),
('Vélo', 6.00, 45, 'Vélo à intensité modérée'),
('Natation', 7.00, 45, 'Natation modérée'),
('Musculation', 6.00, 60, 'Entraînement avec poids');

-- Régimes
INSERT IGNORE INTO regime (nom, duree, variation_poids, prix_base, prix, prix_gold, description) VALUES
('Régime Faible Calorie', 7, -5.00, 1000.00, 7000.00, 5950.00, 'Perdre 5kg en 1 semaine'),
('Régime Équilibré', 14, -3.50, 900.00, 12600.00, 10710.00, 'Perdre 3.5kg en 2 semaines'),
('Régime Perte Rapide', 10, -7.00, 800.00, 8000.00, 6800.00, 'Perdre 7kg en 10 jours'),
('Régime Gain Musculaire', 21, 4.50, 900.00, 18900.00, 16065.00, 'Gagner 4.5kg en 3 semaines'),
('Régime Maintenance', 30, 0.50, 800.00, 24000.00, 20400.00, 'Maintenir le poids idéal');

-- Régimes - Aliments (avec composition viande/poisson/volaille)
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

-- Régimes - Sports
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

-- Codes de recharge wallet
INSERT IGNORE INTO wallet_codes (code, value, status) VALUES
('CODE2024-001', 10000.00, 'available'),
('CODE2024-002', 20000.00, 'available'),
('CODE2024-003', 50000.00, 'available');

-- Paramètres système
INSERT IGNORE INTO parameters (`key`, value, description) VALUES
('prix_base_regime_court', '1000', 'Prix par jour pour régime <= 7 jours'),
('prix_base_regime_moyen', '900', 'Prix par jour pour régime 8-30 jours'),
('prix_base_regime_long', '800', 'Prix par jour pour régime > 30 jours'),
('devise', 'Ar', 'Devise locale');
