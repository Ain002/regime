<h2>Modifier activité</h2>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/activity/update/<?= $activity['id'] ?>">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" value="<?= esc($activity['nom']) ?>" required>
    </div>

    <div>
        <label>Variation poids (kg)</label>
        <input type="number" step="0.1" name="variation_poids" value="<?= $activity['variation_poids'] ?>" required>
    </div>

    <div>
        <label>Durée (minutes)</label>
        <input type="number" name="duree" min="1" value="<?= $activity['duree'] ?>" required>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"><?= esc($activity['description']) ?></textarea>
    </div>

    <button type="submit">Modifier</button>
</form>
