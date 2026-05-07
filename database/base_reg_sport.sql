use regime

CREATE TABLE regime_sport (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    regime_id INT UNSIGNED NOT NULL,

    sport_id INT UNSIGNED NOT NULL,

    frequence_semaine INT NOT NULL,

    duree_minutes INT NOT NULL,

    intensite ENUM(
        'faible',
        'moyenne',
        'forte'
    ) DEFAULT 'moyenne',

    calories_estimees DOUBLE DEFAULT 0,

    FOREIGN KEY (regime_id)
    REFERENCES regime(id),

    FOREIGN KEY (sport_id)
    REFERENCES sport(id)
);