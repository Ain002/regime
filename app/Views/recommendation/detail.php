<!DOCTYPE html>
<html lang="en">
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

<div class="container-fluid">

<div class="card shadow mb-4">

    <div class="card-header bg-primary text-white py-3">

        <h3 class="mb-0">
            <?= esc($programme['nom']) ?>
        </h3>

    </div>

    <div class="card-body">

        <!-- Description -->
        <p class="text-muted">
            <?= esc($programme['description']) ?>
        </p>

        <!-- Informations -->
        <div class="row mb-4">

            <div class="col-md-3">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted d-block">
                        Durée
                    </small>

                    <h5>
                        <?= $programme['duree'] ?> semaines
                    </h5>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted d-block">
                        Variation
                    </small>

                    <h5>
                        <?= $programme['variation_totale'] ?> kg
                    </h5>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted d-block">
                        Sports
                    </small>

                    <h5>
                        <?= count($programme['sports']) ?>
                    </h5>

                </div>

            </div>

            <div class="col-md-3">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted d-block">
                        Prix
                    </small>

                    <h5 class="text-success">

                        <?= number_format($programme['prix_final'], 0, ',', ' ') ?>

                        Ar

                    </h5>

                </div>

            </div>

        </div>

        <!-- Aliments -->
        <h4 class="mb-3">
            🍽️ Composition Alimentaire
        </h4>

        <div class="row mb-5">

            <?php foreach($programme['aliments'] as $aliment): ?>

                <div class="col-md-4 mb-3">

                    <div class="card border-left-success shadow-sm">

                        <div class="card-body">

                            <h6 class="font-weight-bold">
                                <?= esc($aliment['nom']) ?>
                            </h6>

                            <small class="text-muted">

                                <?= esc($aliment['type_aliment']) ?>

                            </small>

                            <div class="mt-2">

                                <span class="badge badge-success">

                                    <?= $aliment['pourcentage'] ?>%

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Sports -->
        <h4 class="mb-3">
            ⚽ Programme Sportif
        </h4>

        <div class="row mb-5">

            <?php foreach($programme['sports'] as $sport): ?>

                <div class="col-md-6 mb-3">

                    <div class="card border-left-primary shadow-sm">

                        <div class="card-body">

                            <h5 class="font-weight-bold">

                                <?= esc($sport['nom']) ?>

                            </h5>

                            <p class="text-muted small mb-3">

                                <?= esc($sport['description']) ?>

                            </p>

                            <div class="row text-center">

                                <div class="col-4">

                                    <small class="text-muted d-block">
                                        Fréquence
                                    </small>

                                    <strong>
                                        <?= $sport['frequence_semaine'] ?>x
                                    </strong>

                                </div>

                                <div class="col-4">

                                    <small class="text-muted d-block">
                                        Durée
                                    </small>

                                    <strong>
                                        <?= $sport['duree_minutes'] ?> min
                                    </strong>

                                </div>

                                <div class="col-4">

                                    <small class="text-muted d-block">
                                        Intensité
                                    </small>

                                    <strong>
                                        <?= esc($sport['intensite']) ?>
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Actions -->
        <div class="row">

            <div class="col-md-6 mb-3">

                <a
                    href="/recommendation/export/<?= $programme['id'] ?>"
                    class="btn btn-info btn-lg btn-block"
                >
                    <i class="fas fa-file-pdf mr-2"></i>

                    Exporter PDF

                </a>

            </div>

            <div class="col-md-6 mb-3">

                <a
                    href="/recommendation/buy/<?= $programme['id'] ?>"
                    class="btn btn-success btn-lg btn-block"
                >
                    <i class="fas fa-shopping-cart mr-2"></i>

                    Acheter le Programme

                </a>

            </div>

        </div>

    </div>

</div>

</div>



</body>
</html>