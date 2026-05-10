<?php /** Admin layout for SB Admin theme */ ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin">
    <meta name="author" content="">
    <title><?= isset($title) ? esc($title) : 'Admin' ?></title>

    <link href="<?= base_url('template/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="<?= base_url('template/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('template/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin/dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Régime <sup>Admin</sup></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/regime') ?>">
                    <i class="fas fa-fw fa-leaf"></i>
                    <span>Régimes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/activity') ?>">
                    <i class="fas fa-fw fa-running"></i>
                    <span>Activités</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/aliment') ?>">
                    <i class="fas fa-fw fa-apple-alt"></i>
                    <span>Aliments</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/wallet') ?>">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Codes Recharge</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/parameter') ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Paramètres</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link" href="<?= site_url('admin/wallet') ?>" title="Codes en attente">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter"><?= isset($codesPending) ? $codesPending : 0 ?></span>
                            </a>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle" src="<?= base_url('template/img/undraw_profile.svg') ?>">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                    <?= $this->renderSection('scripts') ?>
                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© <?= date('Y') ?> Régime</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?= base_url('template/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('template/js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
</body>

</html>
