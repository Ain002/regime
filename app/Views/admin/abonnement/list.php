<?php $this->extend('layouts/admin') ?>

<?php $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gestion des Abonnements</h1>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Abonnements</h6>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Prix (Ar)</th>
                        <th>Réduction (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($abonnements as $abonnement): ?>
                        <tr>
                            <td><?= htmlspecialchars($abonnement['libelle']) ?></td>
                            <td><?= number_format((float)$abonnement['prix'], 0, ',', ' ') ?></td>
                            <td><?= number_format((float)$abonnement['reduction'], 2) ?> %</td>
                            <td>
                                <a href="<?= site_url('admin/abonnements/' . $abonnement['id'] . '/edit') ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Éditer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
