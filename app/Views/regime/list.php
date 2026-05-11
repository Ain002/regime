<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Liste des régimes</h6>
        <a href="<?= site_url('admin/regime/create') ?>" class="btn btn-primary btn-sm">➕ Ajouter un régime</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Durée</th>
                        <th>Variation poids</th>
                        <th>Prix</th>
                        <th>Aliments</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($regimes as $r): ?>
                        <tr>
                            <td><?= esc($r['nom']) ?></td>
                            <td><?= esc($r['duree']) ?> jours</td>
                            <td><?= esc($r['variation_poids']) ?> kg</td>
                            <td><?= number_format((float) $r['prix'], 0, ',', ' ') ?> Ar</td>
                            <td>
                                <small>
                                    <?php foreach ($r['aliments'] as $a): ?>
                                        <div><?= esc($a['nom']) ?>: <?= esc($a['pourcentage']) ?>%</div>
                                    <?php endforeach; ?>
                                </small>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/regime/edit/' . $r['id']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <a href="<?= site_url('admin/regime-sport/' . $r['id']) ?>" class="btn btn-sm btn-info">🏃 Sports</a>
                                <form method="post" action="<?= site_url('admin/regime/delete/' . $r['id']) ?>" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Delete</button>
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
