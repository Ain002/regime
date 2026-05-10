<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="container-fluid mt-5">
    <h1 class="mb-4">📊 Dashboard Administrateur</h1>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">👥 Utilisateurs</h5>
                    <h2><?= $totalUsers ?? 0 ?></h2>
                    <small>Utilisateurs actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">💪 Régimes</h5>
                    <h2><?= $totalRegimes ?? 0 ?></h2>
                    <small>Régimes disponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">⭐ Gold Premium</h5>
                    <h2><?= $goldPurchases ?? 0 ?></h2>
                    <small>Abonnements actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">💰 Transactions</h5>
                    <h2><?= $totalTransactions ?? 0 ?></h2>
                    <small>Portefeuille</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Codes de Recharge -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🔑 Codes de Recharge</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h6 class="text-muted">Total généré</h6>
                            <h3><?= $totalCodes ?? 0 ?></h3>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Utilisés</h6>
                            <h3><?= $codesUsed ?? 0 ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">Codes en attente:</small>
                        <h4><?= $codesPending ?? 0 ?></h4>
                    </div>
                    <a href="/admin/wallet" class="btn btn-sm btn-primary mt-3 w-100">Gérer les codes</a>
                </div>
            </div>
        </div>

        <!-- Revenus par type -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💵 Revenus par type</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($revenueByType)): ?>
                        <ul class="list-unstyled">
                            <?php foreach ($revenueByType as $type => $amount): ?>
                                <li class="d-flex justify-content-between mb-2">
                                    <span><?= ucfirst($type) ?></span>
                                    <strong><?= formatPrice($amount) ?></strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Aucune transaction</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📈 Dernières Transactions (10)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $trans): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($trans['created_at'])) ?></td>
                                <td>
                                    <small class="text-muted">#<?= $trans['user_id'] ?? 'N/A' ?></small>
                                </td>
                                <td>
                                    <?php if ($trans['type'] === 'recharge'): ?>
                                        <span class="badge bg-info">💰 Recharge</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">🛒 Achat</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= formatPrice($trans['montant']) ?></strong>
                                </td>
                                <td>
                                    <small class="text-muted">ID: <?= $trans['id'] ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucune transaction</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="/regime" class="btn btn-outline-primary w-100">
                💪 Gérer les Régimes
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="/aliment" class="btn btn-outline-success w-100">
                🍽️ Gérer les Aliments
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="/activity" class="btn btn-outline-info w-100">
                ⚽ Gérer les Activités
            </a>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
