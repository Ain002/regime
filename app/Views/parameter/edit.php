<h2>Modifier paramètre</h2>

<?php if (session()->has('success')): ?>
    <div style="color: green;">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="/parameter/update/<?= $parameter['id'] ?>">
    <?= csrf_field() ?>

    <div>
        <label>Clé</label>
        <input type="text" value="<?= esc($parameter['key']) ?>" disabled>
    </div>

    <div>
        <label>Valeur</label>
        <textarea name="value" required><?= esc($parameter['value']) ?></textarea>
    </div>

    <div>
        <label>Description</label>
        <textarea name="description"><?= esc($parameter['description']) ?></textarea>
    </div>

    <button type="submit">Modifier</button>
</form>

<a href="/parameter">Retour</a>
