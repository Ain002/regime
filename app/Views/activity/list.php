<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Liste des activités sportives</h6>
        <a href="<?= site_url('admin/activity/create') ?>" class="btn btn-primary btn-sm">Ajouter une activité</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Variation poids</th>
                        <th>Durée</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($activities as $activity): ?>
                        <tr>
                            <td><?= esc($activity['nom']) ?></td>
                            <td><?= esc($activity['variation_poids']) ?> kg</td>
                            <td><?= esc($activity['duree']) ?> min</td>
                            <td><?= esc($activity['description']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/activity/edit/' . $activity['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="post" action="<?= site_url('admin/activity/delete/' . $activity['id']) ?>" style="display:inline;">
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
