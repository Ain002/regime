<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connexion</title>

    <!-- Fonts & styles from template -->
    <link href="<?= base_url('template/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="<?= base_url('template/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        .error-text { color: #d32f2f; font-size: 12px; margin-top: 5px; display: none; }
        .is-invalid { border-color: #d32f2f !important; }
        .is-invalid + .error-text { display: block; }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Connexion</h1>
                                    </div>

                                    <?php if (session()->has('error')): ?>
                                        <div class="alert alert-danger" role="alert"><?php echo session('error'); ?></div>
                                    <?php endif; ?>

                                    <?php if (session()->has('errors')): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php foreach (session('errors') as $err): ?>
                                                <div><?= $err ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" method="POST" action="<?= base_url('/auth/authenticate') ?>" id="loginForm">
                                        <?= csrf_field() ?>

                                        <!-- Indicateur d'étape -->
                                        <div class="progress mb-4" style="height: 25px;">
                                            <div class="progress-bar progress-bar-striped bg-primary step-progress" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                <span class="progress-text">Étape <span class="current-step">1</span>/2</span>
                                            </div>
                                        </div>

                                        <!-- Étape 1: Email -->
                                        <div class="form-step" data-step="1">
                                            <h5 class="text-gray-800 mb-3">Entrez votre email</h5>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Entrez votre email..." value="<?= old('email') ?>" required autocomplete="email">
                                                <span class="error-text" id="emailError">Email invalide</span>
                                            </div>
                                        </div>

                                        <!-- Étape 2: Mot de passe -->
                                        <div class="form-step" data-step="2" style="display: none;">
                                            <h5 class="text-gray-800 mb-3">Entrez votre mot de passe</h5>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Mot de passe" required autocomplete="current-password">
                                                <span class="error-text" id="passwordError">Mot de passe requis (min 6 caractères)</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                    <label class="custom-control-label" for="remember">Se souvenir de moi</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Boutons de navigation -->
                                        <div class="form-group form-nav-buttons">
                                            <button type="button" class="btn btn-secondary btn-user btn-block" id="prevBtn" style="display: none; margin-bottom: 10px;">← Retour</button>
                                            <button type="button" class="btn btn-primary btn-user btn-block" id="nextBtn">Suivant →</button>
                                        </div>
                                        <hr>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('/forgot-password') ?>">Mot de passe oublié ?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('/register') ?>">Créer un compte !</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= base_url('template/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('template/js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('js/multi-step-forms.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            if (form) {
                initializeMultiStepForm(form, 2);
            }
        });
    </script>

</body>

</html>
