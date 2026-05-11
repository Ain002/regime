<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Gestion des codes porte-monnaie</h6>
        <div>
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/wallet?filter=pending') ?>">En attente</a>
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/wallet?filter=approved') ?>">Approuvés</a>
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/wallet?filter=rejected') ?>">Rejetés</a>
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/wallet?filter=used') ?>">Utilisés</a>
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/wallet?filter=all') ?>">Tous</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>User ID</th>
                        <th>Statut</th>
                        <th>Demandé le</th>
                        <th>Approuvé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($codes)): ?>
                        <?php foreach ($codes as $code): ?>
                            <tr>
                                <td><?= esc($code['code']) ?></td>
                                <td><?= esc($code['value']) ?> Ar</td>
                                <td><?= esc($code['user_id'] ?? '-') ?></td>
                                <td><span class="badge badge-info"><?= esc($code['status']) ?></span></td>
                                <td><?= esc($code['requested_at'] ?? '-') ?></td>
                                <td><?= esc($code['approved_at'] ?? '-') ?></td>
                                <td>
                                    <?php if (($code['status'] ?? '') === 'pending'): ?>
                                        <a class="btn btn-sm btn-success" href="<?= site_url('admin/wallet/approve/' . $code['id']) ?>">Approuver</a>
                                        <a class="btn btn-sm btn-danger" href="<?= site_url('admin/wallet/reject/' . $code['id']) ?>">Rejeter</a>
                                    <?php elseif (($code['status'] ?? '') === 'approved'): ?>
                                        <a class="btn btn-sm btn-warning" href="<?= site_url('admin/wallet/mark-used/' . $code['id']) ?>">Marquer utilisé</a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Aucun code pour le moment</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
