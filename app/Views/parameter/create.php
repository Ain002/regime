<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Créer un nouveau paramètre</h6>
    </div>
    <div class="card-body">
        <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/parameter/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="key">Clé du paramètre</label>
                <input type="text" id="key" name="key" class="form-control" required value="<?= old('key') ?>">
            </div>
            <div class="form-group">
                <label for="value">Valeur</label>
                <input type="text" id="value" name="value" class="form-control" required value="<?= old('value') ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?= old('description') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✅ Créer</button>
                <a href="<?= site_url('admin/parameter') ?>" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
