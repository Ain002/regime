<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ajouter une activité sportive</h6>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/activity/store') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= old('nom') ?>" required>
            </div>
            <div class="form-group">
                <label>Variation poids (kg)</label>
                <input type="number" step="0.1" name="variation_poids" class="form-control" value="<?= old('variation_poids') ?>" required>
            </div>
            <div class="form-group">
                <label>Durée (minutes)</label>
                <input type="number" name="duree" min="1" class="form-control" value="<?= old('duree') ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= old('description') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Créer activité</button>
                <a href="<?= site_url('admin/activity') ?>" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
