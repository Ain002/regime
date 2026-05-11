<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mes Recommandations - Régime App</title>

    <link href="/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
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

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header text-white py-3">
                            <h4 class="mb-0"><i class="fas fa-user-edit mr-2"></i> Paramètres du Profil</h4>
                        </div>
                        <div class="card-body p-4 p-md-5">

                            <!-- Alertes -->
                            <?php if (session()->has('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= session('success') ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= site_url('profile/update') ?>" method="POST">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Nom</label>
                                        <input type="text" name="nom" class="form-control"
                                            value="<?= esc($user['nom']) ?>" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold">Prénom</label>
                                        <input type="text" name="prenom" class="form-control"
                                            value="<?= esc($user['prenom']) ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label class="font-weight-bold">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?= esc($user['email']) ?>" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Genre</label>
                                        <select name="genre" class="form-control">
                                            <option value="H" <?= $user['genre'] == 'H' ? 'selected' : '' ?>>Homme</option>
                                            <option value="F" <?= $user['genre'] == 'F' ? 'selected' : '' ?>>Femme</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Taille (cm)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="taille" class="form-control"
                                                value="<?= esc($user['taille']) ?>">
                                            <div class="input-group-append"><span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Poids (kg)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="poids" class="form-control"
                                                value="<?= esc($user['poids']) ?>">
                                            <div class="input-group-append"><span class="input-group-text">kg</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Date de naissance</label>
                                        <input type="date" name="date_naissance" class="form-control"
                                            value="<?= esc($user['date_naissance']) ?>">
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="font-weight-bold">Changer le mot de passe</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Laissez vide pour conserver l'actuel">
                                    <small class="form-text text-muted">Sécurité : utilisez au moins 8
                                        caractères.</small>
                                </div>

                                <div class="mt-5">
                                    <button type="submit" class="btn btn-primary btn-icon-split btn-lg">
                                        <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                        <span class="text">Enregistrer les modifications</span>
                                    </button>
                                    <a href="<?= site_url('recommendation') ?>"
                                        class="btn btn-light btn-lg ml-2">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/template/vendor/jquery/jquery.min.js"></script>
        <script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>