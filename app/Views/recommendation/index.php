<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mes Recommandations</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px 15px 0 0 !important;
            color: white;
        }
        .btn-logout {
            background: #dc3545;
            border: none;
        }
        .info-card {
            border-left: 5px solid #667eea;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand"><i class="fas fa-heartbeat"></i> Régime App</span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="navbar-text text-white me-3"><?= esc($user['prenom'] ?? '') ?> <?= esc($user['nom'] ?? '') ?></span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-logout btn-sm" href="/logout">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Titre et Info Utilisateur -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-white mb-4">Vos Recommandations Personnalisées</h1>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card info-card">
                    <div class="card-body">
                        <h6 class="card-title text-muted">👤 Utilisateur</h6>
                        <p class="card-text"><?= esc($user['prenom'] ?? '') ?> <?= esc($user['nom'] ?? '') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card info-card">
                    <div class="card-body">
                        <h6 class="card-title text-muted">📊 IMC</h6>
                        <p class="card-text"><?= $imc ?> <small class="text-muted">(<?= $etat ?>)</small></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card info-card">
                    <div class="card-body">
                        <h6 class="card-title text-muted">🎯 Objectif</h6>
                        <p class="card-text"><?= esc($objectif) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Régimes -->
        <div class="row">
            <?php if (!empty($programmes)): ?>
                <?php foreach ($programmes as $prog): ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><?= esc($prog['nom']) ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small"><i class="fas fa-calendar"></i> Durée: <?= $prog['duree'] ?> jours</p>

                                <h6 class="mt-3"><i class="fas fa-utensils"></i> Composition</h6>
                                <ul class="small">
                                    <?php foreach ($prog['aliments'] as $al): ?>
                                        <li><?= esc($al['nom']) ?>: <?= $al['pourcentage'] ?>%</li>
                                    <?php endforeach; ?>
                                </ul>

                                <h6 class="mt-3"><i class="fas fa-running"></i> Activités</h6>
                                <div class="small">
                                    <?php foreach ($prog['sports'] as $sp): ?>
                                        <div class="mb-2 p-2 bg-light rounded">
                                            <strong><?= esc($sp['nom']) ?></strong><br>
                                            <small>
                                                📊 Impact: ±<?= $sp['variation_poids'] ?> kg<br>
                                                📅 Fréq: <?= $sp['frequence_semaine'] ?>x/semaine<br>
                                                ⏱️ Durée: <?= $sp['duree_minutes'] ?> min<br>
                                                💪 Intensité: <?= ucfirst($sp['intensite']) ?>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <hr>

                                <div class="text-center">
                                    <?php if ($prog['is_gold_applied']): ?>
                                        <small class="text-muted text-decoration-line-through"><?= number_format($prog['prix_final'] / 0.85, 0, ',', ' ') ?> Ar</small><br>
                                        <span class="badge bg-warning">Gold -15%</span><br>
                                    <?php endif; ?>
                                    <h5 class="text-primary font-weight-bold mt-2"><?= number_format($prog['prix_final'], 0, ',', ' ') ?> Ar</h5>
                                </div>

                                <div class="d-grid gap-2 mt-3">
                                    <a href="<?= base_url('recommendation/export/' . $prog['id']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-file-pdf"></i> Exporter PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Aucun régime ne correspond à vos critères pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>