<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mon Portefeuille - Régime App</title>
    
    <link href="/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/template/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/recommendation">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Régime App</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="/recommendation">
                    <i class="fas fa-fw fa-fire"></i>
                    <span>Recommandations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/wallet">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Portefeuille</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </li>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="d-sm-flex align-items-center justify-content-between ml-auto">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            👤 <?= esc($user['prenom'] ?? '') ?> <?= esc($user['nom'] ?? '') ?>
                        </span>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            💰 Solde: <strong><?= number_format($solde ?? 0, 2) ?> Ar</strong>
                        </span>
                    </div>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">💳 Mon Portefeuille</h1>
                    </div>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ <?= session('success') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ❌ <?= session('error') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Solde Card -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-success font-weight-bold text-uppercase mb-1">💰 Solde Actuel</div>
                                    <div class="h2 mb-0 text-gray-800"><?= number_format($solde ?? 0, 2) ?> Ar</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <a href="/code" class="btn btn-primary btn-lg btn-block h-100">
                                <i class="fas fa-plus-circle"></i> Recharger
                            </a>
                        </div>
                        <div class="col-md-4 mb-4">
                            <a href="/recommendation" class="btn btn-info btn-lg btn-block h-100">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">📊 Historique des Transactions</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($transactions)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction): ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($transaction['type'] === 'recharge'): ?>
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-plus"></i> Recharge
                                                            </span>
                                                        <?php elseif ($transaction['type'] === 'achat'): ?>
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-shopping-cart"></i> Achat
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">
                                                                <?= esc($transaction['type']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <strong>
                                                            <?php if ($transaction['type'] === 'recharge'): ?>
                                                                +<?= number_format($transaction['montant'], 2) ?> Ar
                                                            <?php else: ?>
                                                                -<?= number_format($transaction['montant'], 2) ?> Ar
                                                            <?php endif; ?>
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small>—</small>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if ($pager): ?>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center">
                                            <?= $pager->links() ?>
                                        </ul>
                                    </nav>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucune transaction pour le moment.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Régime App 2026</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="/template/vendor/jquery/jquery.min.js"></script>
    <script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/template/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/template/js/sb-admin-2.min.js"></script>
</body>
</html>
