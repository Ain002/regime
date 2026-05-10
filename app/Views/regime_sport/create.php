<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>
<div class="container mt-5">
    <h2>Ajouter un sport au régime: <?= esc($regime['nom']) ?></h2>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/regime-sport/store/<?= $regime['id'] ?>" method="POST" class="form mt-4">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="sport_id" class="form-label">Sport <span class="text-danger">*</span></label>
            <select id="sport_id" name="sport_id" class="form-select" required>
                <option value="">-- Sélectionnez un sport --</option>
                <?php foreach ($sports as $sport): ?>
                    <option value="<?= $sport['id'] ?>"><?= esc($sport['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="frequence_semaine" class="form-label">Fréquence (fois/semaine) <span class="text-danger">*</span></label>
                <input type="number" id="frequence_semaine" name="frequence_semaine" class="form-control" step="1" min="1" max="7" required value="<?= old('frequence_semaine', 3) ?>">
                <small class="text-muted">Entre 1 et 7 fois</small>
            </div>

            <div class="col-md-4 mb-3">
                <label for="duree_minutes" class="form-label">Durée (minutes) <span class="text-danger">*</span></label>
                <input type="number" id="duree_minutes" name="duree_minutes" class="form-control" step="5" min="5" required value="<?= old('duree_minutes', 30) ?>">
                <small class="text-muted">Durée minimum recommandée</small>
            </div>

            <div class="col-md-4 mb-3">
                <label for="intensite" class="form-label">Intensité <span class="text-danger">*</span></label>
                <select id="intensite" name="intensite" class="form-select" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="faible" <?= old('intensite') === 'faible' ? 'selected' : '' ?>>Faible</option>
                    <option value="modérée" <?= old('intensite') === 'modérée' ? 'selected' : '' ?>>Modérée</option>
                    <option value="élevée" <?= old('intensite') === 'élevée' ? 'selected' : '' ?>>Élevée</option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">✅ Ajouter le sport</button>
            <a href="/regime-sport/<?= $regime['id'] ?>" class="btn btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>
<?php $this->endSection() ?>
