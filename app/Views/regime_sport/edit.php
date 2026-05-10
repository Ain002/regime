<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>
<div class="container mt-5">
    <h2>Modifier les détails du sport</h2>
    <p class="text-muted">Régime: <?= esc($regime['nom']) ?> | Sport: <?= esc($regimeSport['nom']) ?></p>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/regime-sport/update/<?= $regime['id'] ?>/<?= $regimeSport['sport_id'] ?>" method="POST" class="form mt-4">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Sport</label>
            <input type="text" class="form-control" value="<?= esc($regimeSport['nom']) ?>" disabled>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="frequence_semaine" class="form-label">Fréquence (fois/semaine) <span class="text-danger">*</span></label>
                <input type="number" id="frequence_semaine" name="frequence_semaine" class="form-control" step="1" min="1" max="7" required value="<?= old('frequence_semaine', $regimeSport['frequence_semaine']) ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label for="duree_minutes" class="form-label">Durée (minutes) <span class="text-danger">*</span></label>
                <input type="number" id="duree_minutes" name="duree_minutes" class="form-control" step="5" min="5" required value="<?= old('duree_minutes', $regimeSport['duree_minutes']) ?>">
            </div>

            <div class="col-md-4 mb-3">
                <label for="intensite" class="form-label">Intensité <span class="text-danger">*</span></label>
                <select id="intensite" name="intensite" class="form-select" required>
                    <option value="faible" <?= old('intensite', $regimeSport['intensite']) === 'faible' ? 'selected' : '' ?>>Faible</option>
                    <option value="modérée" <?= old('intensite', $regimeSport['intensite']) === 'modérée' ? 'selected' : '' ?>>Modérée</option>
                    <option value="élevée" <?= old('intensite', $regimeSport['intensite']) === 'élevée' ? 'selected' : '' ?>>Élevée</option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
            <a href="/regime-sport/<?= $regime['id'] ?>" class="btn btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>
<?php $this->endSection() ?>
