<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inscription</title>

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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un compte</h1>
                            </div>

                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger"><?php echo session('error'); ?></div>
                            <?php endif; ?>

                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger">
                                    <?php foreach (session('errors') as $err): ?>
                                        <div><?= $err ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <form class="user" method="POST" action="<?= base_url('/auth/register') ?>" id="registerForm">
                                <?= csrf_field() ?>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <input type="text" class="form-control form-control-user" id="nom" name="nom" placeholder="Nom complet" value="<?= old('nom') ?>" required>
                                        <span class="error-text" id="nomError">Le nom est requis (min 2 caractères)</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Adresse email" value="<?= old('email') ?>" required>
                                    <span class="error-text" id="emailError">Email invalide ou déjà utilisé</span>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Mot de passe" required>
                                        <span class="error-text" id="passwordError">Mot de passe requis (min 6 caractères)</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="genre">
                                            <option value="">Genre (facultatif)</option>
                                            <option value="H">Homme</option>
                                            <option value="F">Femme</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">S'inscrire</button>
                                <hr>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('/login') ?>">Vous avez déjà un compte ? Connectez-vous !</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="<?= base_url('template/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('template/js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('js/register-validation.js') ?>"></script>
<body>

</html>
