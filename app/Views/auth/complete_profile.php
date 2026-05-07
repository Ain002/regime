<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compléter le profil</title>

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
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Complétez votre profil</h1>
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

                            <form class="user" method="POST" action="<?= base_url('/profile/complete') ?>" id="profileForm">
                                <?= csrf_field() ?>

                                <!-- Indicateur d'étape -->
                                <div class="progress mb-4" style="height: 25px;">
                                    <div class="progress-bar progress-bar-striped bg-primary step-progress" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        <span class="progress-text">Étape <span class="current-step">1</span>/2</span>
                                    </div>
                                </div>

                                <!-- Étape 1: Mesures physiques -->
                                <div class="form-step" data-step="1">
                                    <h5 class="text-gray-800 mb-3">Vos mesures</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label>Taille (cm)</label>
                                            <input type="text" class="form-control form-control-user" id="taille" name="taille" value="<?= old('taille', isset($user['taille']) ? $user['taille'] : '') ?>" required>
                                            <span class="error-text" id="tailleError">Taille invalide (nombre requis)</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Poids (kg)</label>
                                            <input type="text" class="form-control form-control-user" id="poids" name="poids" value="<?= old('poids', isset($user['poids']) ? $user['poids'] : '') ?>" required>
                                            <span class="error-text" id="poidsError">Poids invalide (nombre requis)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 2: Abonnement -->
                                <div class="form-step" data-step="2" style="display: none;">
                                    <h5 class="text-gray-800 mb-3">Choisir un abonnement</h5>
                                    <div class="form-group">
                                        <label>Abonnement (optionnel)</label>
                                        <select name="abonnement_id" class="form-control">
                                            <option value="">Aucun abonnement</option>
                                            <!-- Optionnel: si vous avez la table abonnement, vous pouvez charger les options depuis le modèle -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Boutons de navigation -->
                                <div class="form-group form-nav-buttons">
                                    <button type="button" class="btn btn-secondary btn-user btn-block" id="prevBtn" style="display: none; margin-bottom: 10px;">← Retour</button>
                                    <button type="button" class="btn btn-primary btn-user btn-block" id="nextBtn">Suivant →</button>
                                </div>
                            </form>

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
    <script src="<?= base_url('js/multi-step-forms.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profileForm');
            if (form) {
                initializeMultiStepForm(form, 2);
            }
        });
    </script>

</html>
