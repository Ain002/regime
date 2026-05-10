<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Modifier régime</h6>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/regime/update/' . $regime['id']) ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= esc($regime['nom']) ?>" required>
            </div>
            <div class="form-group">
                <label>Durée (jours)</label>
                <input type="number" name="duree" class="form-control" value="<?= esc($regime['duree']) ?>" min="1" required>
            </div>
            <div class="form-group">
                <label>Variation poids (kg)</label>
                <input type="number" step="0.1" name="variation_poids" class="form-control" value="<?= esc($regime['variation_poids']) ?>" required>
            </div>
            <div class="form-group">
                <label>Prix (Ar)</label>
                <input type="number" step="0.01" min="0" name="prix" class="form-control" value="<?= esc($regime['prix']) ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= esc($regime['description']) ?></textarea>
            </div>
            <h5 class="mt-4">Aliments et pourcentages</h5>
            <p class="text-muted">La somme des pourcentages doit être égale à 100%</p>
            <?php foreach ($aliments as $aliment): ?>
                <div class="form-group">
                    <label><?= esc($aliment['nom']) ?> (<?= esc($aliment['type_aliment'] ?? '') ?>)</label>
                    <input type="number" step="0.01" min="0" max="100" class="form-control" name="percentage[<?= $aliment['id'] ?>]" value="<?= $regime_aliments[$aliment['id']] ?? 0 ?>">
                </div>
            <?php endforeach; ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href="<?= site_url('admin/regime') ?>" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
