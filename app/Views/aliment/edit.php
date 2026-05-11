<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Modifier un aliment</h6>
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

        <form method="post" action="<?= site_url('admin/aliment/update/' . $aliment['id']) ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= esc($aliment['nom']) ?>" required>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type_aliment" class="form-control" required>
                    <option value="viande" <?= $aliment['type_aliment'] === 'viande' ? 'selected' : '' ?>>Viande</option>
                    <option value="poisson" <?= $aliment['type_aliment'] === 'poisson' ? 'selected' : '' ?>>Poisson</option>
                    <option value="volaille" <?= $aliment['type_aliment'] === 'volaille' ? 'selected' : '' ?>>Volaille</option>
                    <option value="legume" <?= $aliment['type_aliment'] === 'legume' ? 'selected' : '' ?>>Legume</option>
                    <option value="fruit" <?= $aliment['type_aliment'] === 'fruit' ? 'selected' : '' ?>>Fruit</option>
                    <option value="autre" <?= $aliment['type_aliment'] === 'autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= esc($aliment['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Image (nom de fichier ou URL)</label>
                <input type="text" name="image" class="form-control" value="<?= esc($aliment['image']) ?>">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href="<?= site_url('admin/aliment') ?>" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
