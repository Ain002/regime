<h2>Modifier un aliment</h2>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/aliment/update/<?= $aliment['id'] ?>">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" value="<?= esc($aliment['nom']) ?>" required>
    </div>

    <div>
        <label>Type</label>
        <select name="type_aliment" required>
            <option value="viande" <?= $aliment['type_aliment'] === 'viande' ? 'selected' : '' ?>>Viande</option>
            <option value="poisson" <?= $aliment['type_aliment'] === 'poisson' ? 'selected' : '' ?>>Poisson</option>
            <option value="volaille" <?= $aliment['type_aliment'] === 'volaille' ? 'selected' : '' ?>>Volaille</option>
            <option value="legume" <?= $aliment['type_aliment'] === 'legume' ? 'selected' : '' ?>>Legume</option>
            <option value="fruit" <?= $aliment['type_aliment'] === 'fruit' ? 'selected' : '' ?>>Fruit</option>
            <option value="autre" <?= $aliment['type_aliment'] === 'autre' ? 'selected' : '' ?>>Autre</option>
        </select>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"><?= esc($aliment['description']) ?></textarea>
    </div>

    <div>
        <label>Image (nom de fichier ou URL)</label>
        <input type="text" name="image" value="<?= esc($aliment['image']) ?>">
    </div>

    <button type="submit">Modifier</button>
</form>

<p><a href="/aliment">Retour à la liste</a></p>
