<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recharger avec un Code - Régime App</title>
    
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
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </div>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">💳 Recharger votre Portefeuille</h1>
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

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary">
                                    <h6 class="m-0 font-weight-bold text-white">
                                        <i class="fas fa-key"></i> Entrer votre code de recharge
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/code/validate">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <label for="code"><strong>Code de Recharge:</strong></label>
                                            <input 
                                                type="text" 
                                                class="form-control form-control-lg" 
                                                id="code" 
                                                name="code" 
                                                placeholder="Ex: XXXX-XXXX-XXXX-XXXX" 
                                                required
                                                autofocus
                                            >
                                            <small class="form-text text-muted">
                                                Entrez le code reçu pour recharger votre compte.
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            <i class="fas fa-check"></i> Valider le Code
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="/recommendation" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                            </div>
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
