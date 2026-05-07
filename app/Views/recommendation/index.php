<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Suggestions de Régimes ✨</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --kawaii-pink: #ffcce6;
            --kawaii-dark-pink: #ff85c2;
            --kawaii-bg: #fff5f8;
        }
        body {
            background-color: var(--kawaii-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background-color: white;
            padding: 30px;
            border-bottom: 5px solid var(--kawaii-pink);
            border-radius: 0 0 50px 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }
        .card-regime {
            border: none;
            border-radius: 25px;
            transition: transform 0.3s;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .card-regime:hover {
            transform: translateY(-10px);
        }
        .badge-imc {
            background-color: var(--kawaii-pink);
            color: #d63384;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
        }
        .btn-export {
            background-color: var(--kawaii-dark-pink);
            border: none;
            border-radius: 50px;
            color: white;
            padding: 10px 25px;
            font-weight: bold;
        }
        .btn-export:hover {
            background-color: #f062a1;
            color: white;
        }
        .price-tag {
            font-size: 1.5rem;
            color: #d63384;
            font-weight: bold;
        }
        .old-price {
            text-decoration: line-through;
            color: #adb5bd;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- En-tête avec résumé profil -->
    <div class="header-section text-center">
        <h1 style="color: var(--kawaii-dark-pink);">Coucou <?= esc($user['nom']) ?> ! ✨</h1>
        <p class="lead">Voici les programmes adaptés à ton objectif : <strong><?= esc($objectif) ?></strong></p>
        
        <div class="d-flex justify-content-center gap-3 mt-3">
            <div class="badge-imc">IMC : <?= $imc ?> (<?= $etat ?>)</div>
        </div>
    </div>

    <!-- Liste des suggestions -->
    <div class="row">
        <?php if (!empty($programmes)): ?>
            <?php foreach ($programmes as $prog): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-regime h-100">
                        <div class="card-body">
                            <h3 class="card-title" style="color: var(--kawaii-dark-pink);"><?= esc($prog['nom']) ?></h3>
                            <p class="text-muted small">Duree : <?= $prog['duree'] ?> jours</p>
                            
                            <hr>
                            
                            <h6>🥣 Composition :</h6>
                            <ul class="small">
                                <?php foreach ($prog['aliments'] as $al): ?>
                                    <li><?= $al['nom'] ?> : <?= $al['pourcentage'] ?>%</li>
                                <?php endforeach; ?>
                            </ul>

                            <h6>🏃 Activités recommandées :</h6>
                            <ul class="small">
                                <?php foreach ($prog['sports'] as $sp): ?>
                                    <li><?= $sp['nom'] ?> (<?= $sp['variation_poids'] ?> kg)</li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="mt-4 text-center">
                                <?php if ($prog['is_gold_applied']): ?>
                                    <span class="old-price"><?= number_format($prog['prix_final'] / 0.85, 0, ',', ' ') ?> Ar</span><br>
                                    <span class="badge bg-warning text-dark mb-1">Promo Gold -15%</span>
                                <?php endif; ?>
                                <div class="price-tag"><?= number_format($prog['prix_final'], 0, ',', ' ') ?> Ar</div>
                                
                                <div class="d-grid gap-2 mt-3">
                                    <a href="<?= base_url('recommendation/export/' . $prog['id']) ?>" class="btn btn-export">
                                        💖 Exporter en PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Aucun régime ne correspond exactement à tes critères pour le moment. ✨</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>