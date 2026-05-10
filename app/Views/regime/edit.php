<h2>Modifier régime</h2>

<?php if (session()->has('error')): ?>
    <div style="color: red;">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="/regime/update/<?= $regime['id'] ?>">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" value="<?= esc($regime['nom']) ?>" required>
    </div>

    <div>
        <label>Durée (jours)</label>
        <input type="number" name="duree" value="<?= $regime['duree'] ?>" min="1" required>
    </div>

    <div>
        <label>Variation poids (kg)</label>
        <input type="number" step="0.1" name="variation_poids" value="<?= $regime['variation_poids'] ?>" required>
    </div>

    <div>
        <label>Prix (Ar)</label>
        <input type="number" step="0.01" min="0" name="prix" value="<?= $regime['prix'] ?>" required>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"><?= esc($regime['description']) ?></textarea>
    </div>

    <h3>Aliments et pourcentages</h3>
    <p><small>La somme des pourcentages doit être égale à 100%</small></p>

    <?php foreach ($aliments as $aliment): ?>
        <div>
            <label><?= esc($aliment['nom']) ?> (<?= esc($aliment['type_aliment'] ?? '') ?>)</label>
            <input type="number" step="0.01" min="0" max="100" 
                   name="percentage[<?= $aliment['id'] ?>]" 
                   placeholder="%" 
                   value="<?= $regime_aliments[$aliment['id']] ?? 0 ?>">
        </div>
    <?php endforeach; ?>

    <button type="submit">Modifier</button>
</form>