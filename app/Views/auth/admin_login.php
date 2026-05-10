<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Connexion</title>
    <link href="<?= base_url('template/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        .login-card { max-width: 420px; margin: 80px auto; }
    </style>
</head>
<body class="bg-gradient-dark">
    <div class="container">
        <div class="card login-card shadow-lg">
            <div class="card-body p-4">
                <h4 class="text-center mb-3">Connexion Admin</h4>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('/auth/admin-authenticate') ?>">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" value="admin" required>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" value="123456" required>
                    </div>
                    <button class="btn btn-dark btn-block mt-3">Se connecter</button>
                    <a href="<?= base_url('/choose') ?>" class="btn btn-link btn-block mt-2">Retour</a>
                </form>

            </div>
        </div>
    </div>
</body>
</html>