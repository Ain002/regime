<h2>Demander un code porte-monnaie</h2>

<?php if (session()->has('success')): ?>
    <div style="color: green;">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div style="color: red;">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="/wallet/request/code">
    <?= csrf_field() ?>

    <div>
        <label>Code</label>
        <input type="text" name="code" placeholder="Entrez votre code" value="<?= old('code') ?>" required>
    </div>

    <button type="submit">Soumettre la demande</button>
</form>

<p>Entrez le code que vous avez reçu. Il sera soumis à l'approbation de l'administrateur.</p>
