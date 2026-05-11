<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Liste des aliments</h6>
        <a href="<?= site_url('admin/aliment/create') ?>" class="btn btn-primary btn-sm">➕ Ajouter un aliment</a>
    </div>
    <div class="card-body p-0">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success m-3"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger m-3"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aliments as $a): ?>
                        <tr>
                            <td><?= esc($a['nom']) ?></td>
                            <td><?= esc($a['type_aliment']) ?></td>
                            <td><?= esc($a['description']) ?></td>
                            <td><?= esc($a['image']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/aliment/edit/' . $a['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="<?= site_url('admin/aliment/delete/' . $a['id']) ?>" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
