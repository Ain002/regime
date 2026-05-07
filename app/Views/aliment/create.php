<h2>Ajouter un aliment</h2>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/aliment/store">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label>
        <input type="text" name="nom" value="<?= old('nom') ?>" required>
    </div>

    <div>
        <label>Type</label>
        <select name="type_aliment" required>
            <option value="">-- Choisir --</option>
            <option value="viande" <?= old('type_aliment') === 'viande' ? 'selected' : '' ?>>Viande</option>
            <option value="poisson" <?= old('type_aliment') === 'poisson' ? 'selected' : '' ?>>Poisson</option>
            <option value="volaille" <?= old('type_aliment') === 'volaille' ? 'selected' : '' ?>>Volaille</option>
            <option value="legume" <?= old('type_aliment') === 'legume' ? 'selected' : '' ?>>Legume</option>
            <option value="fruit" <?= old('type_aliment') === 'fruit' ? 'selected' : '' ?>>Fruit</option>
            <option value="autre" <?= old('type_aliment') === 'autre' ? 'selected' : '' ?>>Autre</option>
        </select>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"><?= old('description') ?></textarea>
    </div>

    <div>
        <label>Image (nom de fichier ou URL)</label>
        <input type="text" name="image" value="<?= old('image') ?>">
    </div>

    <button type="submit">Ajouter</button>
</form>

<p><a href="/aliment">Retour à la liste</a></p>
