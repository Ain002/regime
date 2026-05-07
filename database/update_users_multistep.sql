-- Mise à jour de schéma pour le nouveau formulaire d'inscription multi-étapes
-- À exécuter sur une base déjà existante

USE regime;

ALTER TABLE users ADD prenom VARCHAR(255) NOT NULL;
ALTER TABLE users ADD date_naissance DATE NOT NULL;

-- Harmoniser les objectifs affichés dans le formulaire
INSERT INTO objectif (description)
SELECT 'Perdre de poids'
WHERE NOT EXISTS (
    SELECT 1 FROM objectif WHERE description = 'Perdre de poids'
);

INSERT INTO objectif (description)
SELECT 'Atteindre son IMC idéal'
WHERE NOT EXISTS (
    SELECT 1 FROM objectif WHERE description = 'Atteindre son IMC idéal'
);

INSERT INTO objectif (description)
SELECT 'Gagner de poids'
WHERE NOT EXISTS (
    SELECT 1 FROM objectif WHERE description = 'Gagner de poids'
);
