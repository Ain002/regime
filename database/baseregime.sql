CREATE database regime;
use regime;

CREATE TABLE abonnement (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    prix DOUBLE NOT NULL,
    reduction DOUBLE NOT NULL
);

CREATE TABLE type_user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    genre ENUM('H','F') NOT NULL,
    taille DOUBLE NOT NULL,
    poids DOUBLE NOT NULL,
    type_user_id INT UNSIGNED NOT NULL DEFAULT 1,
    abonnement_id INT UNSIGNED NULL,
    CONSTRAINT fk_user_type_user
    FOREIGN KEY (type_user_id)
    REFERENCES type_user(id),
    CONSTRAINT fk_user_abonnement
    FOREIGN KEY (abonnement_id)
    REFERENCES abonnement(id)
);

CREATE TABLE wallet (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    solde DOUBLE NOT NULL DEFAULT 0,

    CONSTRAINT fk_wallet_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
);

CREATE TABLE wallet_transaction (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    wallet_id INT UNSIGNED NOT NULL,
    montant DOUBLE NOT NULL,
    type_transaction ENUM('recharge','achat') NOT NULL,
    date_transaction DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transaction_wallet
    FOREIGN KEY (wallet_id)
    REFERENCES wallet(id)
);

CREATE TABLE code_recharge (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL UNIQUE,
    montant DOUBLE NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    used_by INT UNSIGNED NULL,
    used_at DATETIME NULL,

    CONSTRAINT fk_code_user
    FOREIGN KEY (used_by)
    REFERENCES users(id)
);

CREATE TABLE objectif (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL
);

CREATE TABLE objectif_user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    objectif_id INT UNSIGNED NOT NULL,
    date_choix DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_objectif_user_user
    FOREIGN KEY (user_id)
    REFERENCES users(id),

    CONSTRAINT fk_objectif_user_objectif
    FOREIGN KEY (objectif_id)
    REFERENCES objectif(id)
);

CREATE TABLE aliment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),

    type_aliment ENUM(
        'viande',
        'poisson',
        'volaille'
    ) NOT NULL
);

CREATE TABLE regime (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    duree INT NOT NULL,
    variation_poids DOUBLE NOT NULL,
    prix DOUBLE NOT NULL,
    description TEXT
);

CREATE TABLE regime_aliment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    regime_id INT UNSIGNED NOT NULL,
    aliment_id INT UNSIGNED NOT NULL,
    pourcentage DOUBLE NOT NULL,

    CONSTRAINT fk_regime_aliment_regime
    FOREIGN KEY (regime_id)
    REFERENCES regime(id),

    CONSTRAINT fk_regime_aliment_aliment
    FOREIGN KEY (aliment_id)
    REFERENCES aliment(id)
);

CREATE TABLE sport (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    variation_poids DOUBLE NOT NULL,
    duree INT NOT NULL,
    description TEXT
);

CREATE TABLE regime_sport (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    regime_id INT UNSIGNED NOT NULL,
    sport_id INT UNSIGNED NOT NULL,
    frequence INT NOT NULL,

    CONSTRAINT fk_regime_sport_regime
    FOREIGN KEY (regime_id)
    REFERENCES regime(id),

    CONSTRAINT fk_regime_sport_sport
    FOREIGN KEY (sport_id)
    REFERENCES sport(id)
);

CREATE TABLE achat_regime (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    regime_id INT UNSIGNED NOT NULL,
    prix_paye DOUBLE NOT NULL,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_achat_user
    FOREIGN KEY (user_id)
    REFERENCES users(id),

    CONSTRAINT fk_achat_regime
    FOREIGN KEY (regime_id)
    REFERENCES regime(id)
);