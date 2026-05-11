<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Modifier paramètre</h6>
    </div>
    <div class="card-body">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/parameter/update/' . $parameter['id']) ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Clé</label>
                <input type="text" class="form-control" value="<?= esc($parameter['key']) ?>" disabled>
            </div>
            <div class="form-group">
                <label for="value">Valeur</label>
                <textarea id="value" name="value" class="form-control" required><?= esc($parameter['value']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"><?= esc($parameter['description']) ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">✅ Modifier</button>
                <a href="<?= site_url('admin/parameter') ?>" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php $this->endSection() ?>
