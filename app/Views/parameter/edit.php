<h2>Modifier paramètre</h2>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/parameter/update/<?= $parameter['id'] ?>" class="form">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Clé</label>
        <input type="text" class="form-control" value="<?= esc($parameter['key']) ?>" disabled>
    </div>

    <div class="mb-3">
        <label for="value" class="form-label">Valeur</label>
        <textarea id="value" name="value" class="form-control" required><?= esc($parameter['value']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control"><?= esc($parameter['description']) ?></textarea>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">✅ Modifier</button>
        <a href="/parameter" class="btn btn-secondary">❌ Annuler</a>
    </div>
</form>
