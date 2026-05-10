<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">📊 Tableau de bord</h1>
    <a href="<?= site_url('admin/wallet') ?>" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-wallet fa-sm text-white-50"></i> Gérer les codes recharge
    </a>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">👥 Utilisateurs</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?? 0 ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">🍽️ Régimes</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $totalRegimes ?? 0 ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">⭐ Abonnements Gold</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $goldPurchases ?? 0 ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">💳 Transactions</div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $totalTransactions ?? 0 ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">📊 Répartition des revenus</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">🎟️ Codes recharge</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-3 pb-2">
                    <canvas id="codeStatusChart"></canvas>
                </div>
                <div class="mt-4 small text-center">
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Disponibles <?= $codesAvailable ?? 0 ?></span>
                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Utilisés <?= $codesUsed ?? 0 ?></span>
                    <span class="mr-2"><i class="fas fa-circle text-warning"></i> En attente <?= $codesPending ?? 0 ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">💰 10 dernières transactions</h6>
                <a href="<?= site_url('admin/wallet') ?>" class="btn btn-sm btn-outline-primary">Voir les codes</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentTransactions)): ?>
                                <?php foreach ($recentTransactions as $trans): ?>
                                    <tr>
                                        <td><?= esc($trans['id']) ?></td>
                                        <td><?= esc($trans['user_id'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge badge-info"><?= esc(ucfirst($trans['type'] ?? 'N/A')) ?></span>
                                        </td>
                                        <td><strong><?= number_format((float) ($trans['montant'] ?? 0), 0, ',', ' ') ?> Ar</strong></td>
                                        <td><small><?= esc($trans['created_at'] ?? 'N/A') ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Aucune transaction pour le moment</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4 mb-3">
        <a href="<?= site_url('admin/regime') ?>" class="btn btn-outline-primary w-100">💪 Gérer les régimes</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="<?= site_url('admin/aliment') ?>" class="btn btn-outline-success w-100">🍽️ Gérer les aliments</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="<?= site_url('admin/activity') ?>" class="btn btn-outline-info w-100">🏃 Gérer les activités</a>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            searching: false,
            ordering: false,
            info: false
        });
    });

    Chart.defaults.font.family = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.color = '#858796';

    const revenueLabels = <?= json_encode(array_values(array_map(static fn($label) => ucfirst((string) $label), array_keys($revenueByType ?? [])))) ?>;
    const revenueValues = <?= json_encode(array_values($revenueByType ?? [])) ?>;
    const chartLabels = revenueLabels.length ? revenueLabels : ['Aucune donnée'];
    const chartValues = revenueValues.length ? revenueValues : [0];

    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Revenus (Ar)',
                tension: 0.3,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: chartValues
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 8 } },
                y: { ticks: { beginAtZero: true } }
            }
        }
    });

    new Chart(document.getElementById('codeStatusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Disponibles', 'Utilisés', 'En attente'],
            datasets: [{
                data: [
                    <?= (int) ($codesAvailable ?? 0) ?>,
                    <?= (int) ($codesUsed ?? 0) ?>,
                    <?= (int) ($codesPending ?? 0) ?>
                ],
                backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
<?php $this->endSection() ?>
