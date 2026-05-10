<h2>Ajouter un régime</h2>

<p><a href="/aliment/create">Ajouter un aliment</a></p>

<?php if (session()->has('error')): ?>
    <div style="color: red;">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="/regime/store">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" placeholder="Nom du régime" value="<?= old('nom') ?>" required>
        <?php if (session('errors.nom')): ?>
            <small style="color: red;"><?= session('errors.nom') ?></small>
        <?php endif; ?>
    </div>

    <div>
        <label>Durée (jours)</label>
        <input type="number" name="duree" placeholder="Durée en jours" min="1" value="<?= old('duree') ?>" required>
        <?php if (session('errors.duree')): ?>
            <small style="color: red;"><?= session('errors.duree') ?></small>
        <?php endif; ?>
    </div>

    <div>
        <label>Variation poids (kg)</label>
        <input type="number" step="0.1" name="variation_poids" placeholder="Ex: +2 ou -1.5" value="<?= old('variation_poids') ?>" required>
    </div>

    <div>
        <label>Prix (Ar)</label>
        <input type="number" step="0.01" min="0" name="prix" placeholder="Prix du régime" value="<?= old('prix') ?>" required>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description" placeholder="Description du régime"><?= old('description') ?></textarea>
    </div>

    <h3>Aliments et pourcentages</h3>
    <p><small>La somme des pourcentages doit être égale à 100%</small></p>

    <?php foreach ($aliments as $aliment): ?>
        <div>
            <label><?= esc($aliment['nom']) ?> (<?= esc($aliment['type_aliment'] ?? '') ?>)</label>
            <input type="number" step="0.01" min="0" max="100" 
                   name="percentage[<?= $aliment['id'] ?>]" 
                   placeholder="%" 
                   value="<?= old('percentage.' . $aliment['id'], 0) ?>">
        </div>
    <?php endforeach; ?>

    <button type="submit">Créer régime</button>
</form>