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
        .recap-item { margin-bottom: 6px; }
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

                                <!-- Indicateur d'étape -->
                                <div class="progress mb-4" style="height: 25px;">
                                    <div class="progress-bar progress-bar-striped bg-primary step-progress" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <span class="progress-text">Étape <span class="current-step">1</span>/4</span>
                                    </div>
                                </div>

                                <!-- Étape 1: Infos perso -->
                                <div class="form-step" data-step="1">
                                    <h5 class="text-gray-800 mb-3">Infos perso</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="nom" name="nom" placeholder="Nom" value="<?= old('nom') ?>" required>
                                            <span class="error-text" id="nomError">Le nom est requis (min 2 caractères)</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="prenom" name="prenom" placeholder="Prénom" value="<?= old('prenom') ?>" required>
                                            <span class="error-text" id="prenomError">Le prénom est requis (min 2 caractères)</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= old('date_naissance') ?>" required>
                                            <span class="error-text" id="date_naissanceError">La date de naissance est requise</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="genre" id="genre" required>
                                                <option value="">Genre</option>
                                                <option value="H" <?= old('genre') === 'H' ? 'selected' : '' ?>>Homme</option>
                                                <option value="F" <?= old('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                                            </select>
                                            <span class="error-text" id="genreError">Le genre est requis</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 2: Infos santé -->
                                <div class="form-step" data-step="2" style="display: none;">
                                    <h5 class="text-gray-800 mb-3">Infos santé</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="number" step="0.1" min="1" class="form-control form-control-user" id="taille" name="taille" placeholder="Taille (cm)" value="<?= old('taille') ?>" required>
                                            <span class="error-text" id="tailleError">Taille invalide</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" step="0.1" min="1" class="form-control form-control-user" id="poids" name="poids" placeholder="Poids (kg)" value="<?= old('poids') ?>" required>
                                            <span class="error-text" id="poidsError">Poids invalide</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 3: Objectif -->
                                <div class="form-step" data-step="3" style="display: none;">
                                    <h5 class="text-gray-800 mb-3">Choisissez votre objectif</h5>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio mb-2">
                                            <input class="custom-control-input" type="radio" name="objectif" id="objectif_perte" value="lose_weight" <?= old('objectif') === 'lose_weight' ? 'checked' : '' ?> required>
                                            <label class="custom-control-label" for="objectif_perte">Perdre de poids</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-2">
                                            <input class="custom-control-input" type="radio" name="objectif" id="objectif_imc" value="ideal_bmi" <?= old('objectif') === 'ideal_bmi' ? 'checked' : '' ?> required>
                                            <label class="custom-control-label" for="objectif_imc">Atteindre son IMC idéal</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" name="objectif" id="objectif_gain" value="gain_weight" <?= old('objectif') === 'gain_weight' ? 'checked' : '' ?> required>
                                            <label class="custom-control-label" for="objectif_gain">Gagner de poids</label>
                                        </div>
                                        <span class="error-text" id="objectifError">Veuillez choisir un objectif</span>
                                    </div>
                                </div>

                                <!-- Étape 4: Récap + identifiants -->
                                <div class="form-step" data-step="4" style="display: none;">
                                    <h5 class="text-gray-800 mb-3">Récapitulatif & validation</h5>

                                    <div class="alert alert-light border mb-3" role="alert">
                                        <div class="recap-item"><strong>Nom :</strong> <span id="recapNom">-</span></div>
                                        <div class="recap-item"><strong>Prénom :</strong> <span id="recapPrenom">-</span></div>
                                        <div class="recap-item"><strong>Date de naissance :</strong> <span id="recapDateNaissance">-</span></div>
                                        <div class="recap-item"><strong>Genre :</strong> <span id="recapGenre">-</span></div>
                                        <div class="recap-item"><strong>Taille :</strong> <span id="recapTaille">-</span></div>
                                        <div class="recap-item"><strong>Poids :</strong> <span id="recapPoids">-</span></div>
                                        <div class="recap-item"><strong>Objectif :</strong> <span id="recapObjectif">-</span></div>
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
                                            <input type="password" class="form-control form-control-user" id="password_confirm" name="password_confirm" placeholder="Confirmer le mot de passe" required>
                                            <span class="error-text" id="password_confirmError">La confirmation doit correspondre au mot de passe</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons de navigation -->
                                <div class="mb-2">
                                    <a href="<?= base_url('/choose') ?>" class="btn btn-light btn-sm">← Retour au choix</a>
                                </div>
                                <div class="form-group form-nav-buttons">
                                    <button type="button" class="btn btn-secondary btn-user btn-block" id="prevBtn" style="display: none; margin-bottom: 10px;">← Retour</button>
                                    <button type="button" class="btn btn-primary btn-user btn-block" id="nextBtn">Suivant →</button>
                                </div>
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
    <script src="<?= base_url('js/multi-step-forms.js') ?>"></script>
    <script>
        function updateRegisterRecap(form) {
            const objectifLabels = {
                lose_weight: 'Perdre de poids',
                ideal_bmi: 'Atteindre son IMC idéal',
                gain_weight: 'Gagner de poids'
            };

            const objectifChecked = form.querySelector('input[name="objectif"]:checked');
            const genreValue = form.querySelector('#genre')?.value || '';

            document.getElementById('recapNom').textContent = form.querySelector('#nom')?.value || '-';
            document.getElementById('recapPrenom').textContent = form.querySelector('#prenom')?.value || '-';
            document.getElementById('recapDateNaissance').textContent = form.querySelector('#date_naissance')?.value || '-';
            document.getElementById('recapGenre').textContent = genreValue === 'H' ? 'Homme' : (genreValue === 'F' ? 'Femme' : '-');
            document.getElementById('recapTaille').textContent = (form.querySelector('#taille')?.value || '-') + ' cm';
            document.getElementById('recapPoids').textContent = (form.querySelector('#poids')?.value || '-') + ' kg';
            document.getElementById('recapObjectif').textContent = objectifChecked ? (objectifLabels[objectifChecked.value] || '-') : '-';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            if (form) {
                initializeMultiStepForm(form, 4, {
                    onStepChange: function(step) {
                        if (step === 4) {
                            updateRegisterRecap(form);
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
