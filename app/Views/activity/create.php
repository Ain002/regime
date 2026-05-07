<h2>Ajouter une activité sportive</h2>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/activity/store">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" placeholder="Nom de l'activité" value="<?= old('nom') ?>" required>
    </div>

    <div>
        <label>Variation poids (kg)</label>
        <input type="number" step="0.1" name="variation_poids" placeholder="Ex: -0.5" value="<?= old('variation_poids') ?>" required>
    </div>

    <div>
        <label>Durée (minutes)</label>
        <input type="number" name="duree" min="1" placeholder="Ex: 30" value="<?= old('duree') ?>" required>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description" placeholder="Description de l'activité"><?= old('description') ?></textarea>
    </div>

    <button type="submit">Créer activité</button>
</form>
