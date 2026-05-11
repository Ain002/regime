<?php $this->extend('layouts/admin') ?>

<?php $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Éditer Abonnement</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="<?= site_url('admin/abonnements') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                <div><?= $field . ': ' . $error ?></div>
            <?php endforeach; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= htmlspecialchars($abonnement['libelle']) ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/abonnements/' . $abonnement['id'] . '/update') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control" id="libelle" name="libelle" 
                           value="<?= old('libelle', htmlspecialchars($abonnement['libelle'])) ?>" required>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (Ar)</label>
                    <input type="number" step="0.01" class="form-control" id="prix" name="prix" 
                           value="<?= old('prix', (float)$abonnement['prix']) ?>" required>
                    <small class="form-text text-muted">
                        Prix actuel: <?= number_format((float)$abonnement['prix'], 0, ',', ' ') ?> Ar
                    </small>
                </div>

                <div class="form-group">
                    <label for="reduction">Réduction (%)</label>
                    <input type="number" step="0.01" class="form-control" id="reduction" name="reduction" 
                           value="<?= old('reduction', (float)$abonnement['reduction']) ?>">
                    <small class="form-text text-muted">Laissez vide ou 0 pour aucune réduction</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="<?= site_url('admin/abonnements') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
