<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>🍽️ Composition: <?= esc($regime['nom']) ?></h2>
            <p class="text-muted">Gérez la composition des aliments du régime (% viande, poisson, volaille)</p>
        </div>
        <a href="<?= site_url('admin/regime-aliment/create/' . $regime['id']) ?>" class="btn btn-primary">➕ Ajouter un aliment</a>
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

    <!-- Composition Summary -->
    <div class="card mb-4 bg-light">
        <div class="card-body">
            <h5 class="card-title">📊 Composition totale</h5>
            <div class="row text-center">
                <div class="col-md-4">
                    <h6>🥩 Viande</h6>
                    <strong class="display-6"><?= $totalComposition['viande'] ?>%</strong>
                </div>
                <div class="col-md-4">
                    <h6>🐟 Poisson</h6>
                    <strong class="display-6"><?= $totalComposition['poisson'] ?>%</strong>
                </div>
                <div class="col-md-4">
                    <h6>🍗 Volaille</h6>
                    <strong class="display-6"><?= $totalComposition['volaille'] ?>%</strong>
                </div>
            </div>
            <div class="mt-3">
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-danger" style="width: <?= $totalComposition['viande'] ?>%;" role="progressbar">
                        <?= $totalComposition['viande'] > 5 ? $totalComposition['viande'] . '%' : '' ?>
                    </div>
                    <div class="progress-bar bg-info" style="width: <?= $totalComposition['poisson'] ?>%;" role="progressbar">
                        <?= $totalComposition['poisson'] > 5 ? $totalComposition['poisson'] . '%' : '' ?>
                    </div>
                    <div class="progress-bar bg-warning" style="width: <?= $totalComposition['volaille'] ?>%;" role="progressbar">
                        <?= $totalComposition['volaille'] > 5 ? $totalComposition['volaille'] . '%' : '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($aliments)): ?>
        <div class="row">
            <?php foreach ($aliments as $aliment): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php 
                                    $icons = [
                                        'viande' => '🥩',
                                        'poisson' => '🐟',
                                        'volaille' => '🍗',
                                        'legume' => '🥦',
                                        'fruit' => '🍎',
                                        'autre' => '🍴'
                                    ];
                                    echo $icons[$aliment['type_aliment']] ?? '🍴';
                                ?>
                                <?= esc($aliment['nom']) ?>
                            </h5>
                            <p class="card-text text-muted small"><?= esc($aliment['description']) ?></p>

                            <div class="row mt-3 text-center">
                                <div class="col-4">
                                    <small class="text-muted">Viande</small><br>
                                    <strong><?= $aliment['pourcentage_viande'] ?>%</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Poisson</small><br>
                                    <strong><?= $aliment['pourcentage_poisson'] ?>%</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Volaille</small><br>
                                    <strong><?= $aliment['pourcentage_volaille'] ?>%</strong>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="<?= site_url('admin/regime-aliment/edit/' . $regime['id'] . '/' . $aliment['aliment_id']) ?>" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                <a href="<?= site_url('admin/regime-aliment/delete/' . $regime['id'] . '/' . $aliment['aliment_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucun aliment assigné à ce régime. <a href="<?= site_url('admin/regime-aliment/create/' . $regime['id']) ?>" class="btn btn-sm btn-primary">Ajouter un aliment</a>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?= site_url('admin/regime') ?>" class="btn btn-secondary">← Retour aux régimes</a>
        <a href="<?= site_url('admin/regime-sport/' . $regime['id']) ?>" class="btn btn-info">⚽ Voir les sports</a>
    </div>
</div>
<?php $this->endSection() ?>
