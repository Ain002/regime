<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>🏃 Sports du régime: <?= esc($regime['nom']) ?></h2>
            <p class="text-muted">Gérez les activités sportives associées à ce régime</p>
        </div>
        <a href="/regime-sport/create/<?= $regime['id'] ?>" class="btn btn-primary">➕ Ajouter un sport</a>
    </div>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($sports)): ?>
        <div class="row">
            <?php foreach ($sports as $sport): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                🏋️ <?= esc($sport['nom']) ?>
                            </h5>
                            <p class="card-text text-muted small"><?= esc($sport['description']) ?></p>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <small class="text-muted">📅 Fréquence</small><br>
                                    <strong><?= $sport['frequence_semaine'] ?> fois/semaine</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">⏱️ Durée</small><br>
                                    <strong><?= $sport['duree_minutes'] ?> min</strong>
                                </div>
                            </div>

                            <div class="row mt-2 mb-3">
                                <div class="col-6">
                                    <small class="text-muted">💪 Intensité</small><br>
                                    <strong><?= ucfirst($sport['intensite']) ?></strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">📊 Impact poids</small><br>
                                    <strong>±<?= $sport['variation_poids'] ?> kg</strong>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="/regime-sport/edit/<?= $regime['id'] ?>/<?= $sport['sport_id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <a href="/regime-sport/delete/<?= $regime['id'] ?>/<?= $sport['sport_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucun sport assigné à ce régime. <a href="/regime-sport/create/<?= $regime['id'] ?>" class="btn btn-sm btn-primary">Ajouter un sport</a>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/regime" class="btn btn-secondary">← Retour aux régimes</a>
    </div>
</div>
<?php $this->endSection() ?>
