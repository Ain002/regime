-- Ajout de la colonne prix à la table abonnement sur une base existante
USE regime;

ALTER TABLE abonnement
    ADD COLUMN prix DOUBLE NOT NULL DEFAULT 0 AFTER libelle;

UPDATE abonnement
SET prix = 0
WHERE prix IS NULL;