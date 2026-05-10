<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Paramètres</h6>
        <a href="<?= site_url('admin/parameter/create') ?>" class="btn btn-primary btn-sm">➕ Ajouter un paramètre</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Clé</th>
                        <th>Valeur</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($parameters as $param): ?>
                        <tr>
                            <td><?= esc($param['key']) ?></td>
                            <td><?= esc($param['value']) ?></td>
                            <td><?= esc($param['description']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/parameter/edit/' . $param['id']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <a href="<?= site_url('admin/parameter/delete/' . $param['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
