<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choix : Admin ou Client</title>
    <link href="<?= base_url('template/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        .choice-card { max-width: 540px; margin: 80px auto; }
        .choice-btn { padding: 20px; font-size: 18px; }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card choice-card shadow-lg">
            <div class="card-body text-center">
                <h3 class="mb-4">Accès</h3>
                <p>Choisissez votre accès :</p>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <a href="<?= base_url('/auth/admin-login') ?>" class="btn btn-dark btn-block choice-btn">Admin</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('/register') ?>" class="btn btn-primary btn-block choice-btn">Client</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>