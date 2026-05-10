
CREATE DATABASE regime;
USE regime;

CREATE TABLE IF NOT EXISTS abonnement (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(100) NOT NULL,
  prix DECIMAL(12,2) NOT NULL,
  reduction DECIMAL(5,2) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS type_user (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  date_naissance DATE NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  genre ENUM('H', 'F') NOT NULL,
  taille DECIMAL(8,2) NOT NULL,
  poids DECIMAL(8,2) NOT NULL,
  type_user_id INT UNSIGNED NOT NULL DEFAULT 1,
  abonnement_id INT UNSIGNED NULL,
  CONSTRAINT fk_user_type_user FOREIGN KEY (type_user_id) REFERENCES type_user(id),
  CONSTRAINT fk_user_abonnement FOREIGN KEY (abonnement_id) REFERENCES abonnement(id)
);

CREATE TABLE IF NOT EXISTS abonnement_user (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  abonnement_id INT UNSIGNED NOT NULL,
  date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_expiration DATETIME NULL,
  CONSTRAINT fk_abonnement_user_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_abonnement_user_abonnement FOREIGN KEY (abonnement_id) REFERENCES abonnement(id) ON DELETE CASCADE,
  UNIQUE KEY unique_abonnement_user (user_id, abonnement_id, date_achat)
);

CREATE TABLE IF NOT EXISTS wallet (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  solde DECIMAL(12,2) NOT NULL DEFAULT 0,
  CONSTRAINT fk_wallet_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_wallet_user (user_id)
);

CREATE TABLE IF NOT EXISTS wallet_transactions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  wallet_id INT UNSIGNED NOT NULL,
  montant DECIMAL(12,2) NOT NULL,
  type ENUM('recharge', 'achat') NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_id INT UNSIGNED NULL,
  CONSTRAINT fk_transaction_wallet FOREIGN KEY (wallet_id) REFERENCES wallet(id) ON DELETE CASCADE,
  CONSTRAINT fk_transaction_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS code_recharge (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(255) NOT NULL UNIQUE,
  montant DECIMAL(12,2) NOT NULL,
  used TINYINT(1) NOT NULL DEFAULT 0,
  used_by INT UNSIGNED NULL,
  used_at DATETIME NULL,
  CONSTRAINT fk_code_user FOREIGN KEY (used_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS wallet_codes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(100) NOT NULL UNIQUE,
  value DECIMAL(12,2) NOT NULL,
  status ENUM('available', 'pending', 'approved', 'rejected', 'used') NOT NULL DEFAULT 'available',
  user_id INT UNSIGNED NULL,
  requested_at DATETIME NULL,
  approved_at DATETIME NULL,
  rejected_at DATETIME NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_wallet_codes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_wallet_codes_status (status),
  INDEX idx_wallet_codes_user_id (user_id)
);

CREATE TABLE IF NOT EXISTS objectif (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  description VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS objectif_user (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  objectif_id INT UNSIGNED NOT NULL,
  date_choix DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_objectif_user_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_objectif_user_objectif FOREIGN KEY (objectif_id) REFERENCES objectif(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS aliment (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  type_aliment ENUM('viande', 'poisson', 'volaille', 'legume', 'fruit', 'autre') NOT NULL
);

CREATE TABLE IF NOT EXISTS regime (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  duree INT NOT NULL,
  variation_poids DECIMAL(8,2) NOT NULL,
  prix DECIMAL(12,2) NOT NULL,
  description TEXT NULL
);

CREATE TABLE IF NOT EXISTS regime_aliment (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  regime_id INT UNSIGNED NOT NULL,
  aliment_id INT UNSIGNED NOT NULL,
  pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
  CONSTRAINT fk_regime_aliment_regime FOREIGN KEY (regime_id) REFERENCES regime(id) ON DELETE CASCADE,
  CONSTRAINT fk_regime_aliment_aliment FOREIGN KEY (aliment_id) REFERENCES aliment(id) ON DELETE CASCADE,
  UNIQUE KEY unique_regime_aliment (regime_id, aliment_id)
);

CREATE TABLE IF NOT EXISTS sport (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  variation_poids DECIMAL(8,2) NOT NULL,
  duree INT NOT NULL,
  description TEXT
);

CREATE TABLE IF NOT EXISTS regime_sport (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  regime_id INT UNSIGNED NOT NULL,
  sport_id INT UNSIGNED NOT NULL,
  frequence_semaine INT NOT NULL,
  duree_minutes INT NOT NULL,
  intensite VARCHAR(50) NOT NULL,
  CONSTRAINT fk_regime_sport_regime FOREIGN KEY (regime_id) REFERENCES regime(id) ON DELETE CASCADE,
  CONSTRAINT fk_regime_sport_sport FOREIGN KEY (sport_id) REFERENCES sport(id) ON DELETE CASCADE,
  UNIQUE KEY unique_regime_sport (regime_id, sport_id)
);

CREATE TABLE IF NOT EXISTS achat_regime (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  regime_id INT UNSIGNED NOT NULL,
  prix_paye DECIMAL(12,2) NOT NULL,
  date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_achat_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_achat_regime FOREIGN KEY (regime_id) REFERENCES regime(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS parameters (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  value TEXT,
  description VARCHAR(255)
);
