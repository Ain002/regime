<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mes Recommandations - Régime App</title>
    
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
                <a class="nav-link" href="/wallet">
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
                        <h1 class="h3 mb-0 text-gray-800">🎯 Vos Recommandations Personnalisées</h1>
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

                    <!-- User Info Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-primary font-weight-bold text-uppercase mb-1">IMC</div>
                                    <div class="h3 mb-0 text-gray-800"><?= $imc ?></div>
                                    <small class="text-muted"><?= $etat ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-success font-weight-bold text-uppercase mb-1">Poids</div>
                                    <div class="h3 mb-0 text-gray-800"><?= $user['poids'] ?> kg</div>
                                    <small class="text-muted">Taille: <?= $user['taille'] ?> cm</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-warning font-weight-bold text-uppercase mb-1">Objectif</div>
                                    <div class="h5 mb-0 text-gray-800"><?= esc($objectif) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-info font-weight-bold text-uppercase mb-1">Solde</div>
                                        <div class="h3 mb-0 text-gray-800"><?= number_format($solde ?? 0, 2) ?> Ar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Recharge & Gold Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary">
                                    <h6 class="m-0 font-weight-bold text-white">💳 Recharger le Portefeuille</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/code/validate">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <label for="code">Code de Recharge:</label>
                                            <input type="text" class="form-control" id="code" name="code" placeholder="Entrez votre code" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-check"></i> Valider le Code
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-warning">
                                    <h6 class="m-0 font-weight-bold text-white">⭐ Devenir Gold (15% de réduction)</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Profitez de 15% de réduction sur tous les régimes!</p>
                                    <div class="alert alert-info mb-3">
                                        <i class="fas fa-star"></i> Avantages Gold:
                                        <ul class="mb-0 mt-2">
                                            <li>15% de réduction immédiate</li>
                                            <li>Régimes premium</li>
                                            <li>Support prioritaire</li>
                                        </ul>
                                    </div>
                                    <form method="POST" action="/subscription/gold">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-warning btn-block btn-lg">
                                            <i class="fas fa-crown"></i> Devenir Gold
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Régimes Recommandés -->
                    <div class="row">
                        <?php if (!empty($programmes)): ?>
                            <?php foreach ($programmes as $prog): ?>
                                <div class="col-lg-4 mb-4">
                                    <div class="card shadow h-100">
                                        <div class="card-header py-3 bg-primary">
                                            <h6 class="m-0 font-weight-bold text-white">
                                                💪 <?= esc($prog['nom']) ?>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted small"><?= esc($prog['description']) ?></p>
                                            
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">📅 Durée</small>
                                                    <p class="font-weight-bold"><?= $prog['duree'] ?> sem</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">⚖️ Variation</small>
                                                    <p class="font-weight-bold"><?= $prog['variation_poids'] ?> kg</p>
                                                </div>
                                            </div>

                                            <!-- Composition -->
                                            <?php if (!empty($prog['aliments'])): ?>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block mb-2">🍽️ Aliments:</small>
                                                    <ul class="small mb-0">
                                                        <?php foreach (array_slice($prog['aliments'], 0, 3) as $aliment): ?>
                                                            <li><?= esc($aliment['nom']) ?></li>
                                                        <?php endforeach; ?>
                                                        <?php if (count($prog['aliments']) > 3): ?>
                                                            <li class="text-muted">+ <?= count($prog['aliments']) - 3 ?> autres...</li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Sports -->
                                            <?php if (!empty($prog['sports'])): ?>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block mb-2">⚽ Sports:</small>
                                                    <ul class="small mb-0">
                                                        <?php foreach (array_slice($prog['sports'], 0, 2) as $sport): ?>
                                                            <li><?= esc($sport['nom']) ?> (<?= $sport['frequence_semaine'] ?>x/sem)</li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <hr>

                                            <!-- Price -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Prix:</span>
                                                    <h5 class="mb-0">
                                                        <?= $prog['prix_final'] ?> Ar
                                                        <?php if ($prog['is_gold_applied']): ?>
                                                            <span class="badge badge-success ml-2">-15%</span>
                                                        <?php endif; ?>
                                                    </h5>
                                                </div>
                                            </div>

                                            <a href="/recommendation/export/<?= $prog['id'] ?>" class="btn btn-info btn-sm btn-block mb-2">
                                                <i class="fas fa-download"></i> Exporter PDF
                                            </a>
                                            <a href="/recommendation/buy/<?= $prog['id'] ?>" class="btn btn-success btn-sm btn-block">
                                                <i class="fas fa-shopping-cart"></i> Acheter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucun régime ne correspond à vos critères. 
                                    Veuillez mettre à jour votre profil ou vos objectifs.
                                </div>
                            </div>
                        <?php endif; ?>
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
