<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ajouter un aliment</h6>
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

        <form method="post" action="<?= site_url('admin/aliment/store') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= old('nom') ?>" required>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type_aliment" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="viande" <?= old('type_aliment') === 'viande' ? 'selected' : '' ?>>Viande</option>
                    <option value="poisson" <?= old('type_aliment') === 'poisson' ? 'selected' : '' ?>>Poisson</option>
                    <option value="volaille" <?= old('type_aliment') === 'volaille' ? 'selected' : '' ?>>Volaille</option>
                    <option value="legume" <?= old('type_aliment') === 'legume' ? 'selected' : '' ?>>Legume</option>
                    <option value="fruit" <?= old('type_aliment') === 'fruit' ? 'selected' : '' ?>>Fruit</option>
                    <option value="autre" <?= old('type_aliment') === 'autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= old('description') ?></textarea>
            </div>
            <div class="form-group">
                <label>Image (nom de fichier ou URL)</label>
                <input type="text" name="image" class="form-control" value="<?= old('image') ?>">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="<?= site_url('admin/aliment') ?>" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
