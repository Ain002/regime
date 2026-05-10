<h2>Créer un nouveau paramètre</h2>

<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/parameter/store" method="POST" class="form">
    <div class="mb-3">
        <label for="key" class="form-label">Clé du paramètre</label>
        <input type="text" id="key" name="key" class="form-control" required value="<?= old('key') ?>">
        <small class="text-muted">Exemples: prix_base_court, prix_base_moyen, prix_base_long</small>
    </div>

    <div class="mb-3">
        <label for="value" class="form-label">Valeur</label>
        <input type="text" id="value" name="value" class="form-control" required value="<?= old('value') ?>">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description (optionnel)</label>
        <textarea id="description" name="description" class="form-control" rows="3"><?= old('description') ?></textarea>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">✅ Créer</button>
        <a href="/parameter" class="btn btn-secondary">❌ Annuler</a>
    </div>
</form>
