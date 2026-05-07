<h2>Liste des aliments</h2>

<?php if (session()->has('success')): ?>
    <div style="color: green;">
        <?= esc(session('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div style="color: red;">
        <?= esc(session('error')) ?>
    </div>
<?php endif; ?>

<p><a href="/aliment/create">Ajouter un aliment</a></p>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Type</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($aliments as $a): ?>
        <tr>
            <td><?= esc($a['nom']) ?></td>
            <td><?= esc($a['type_aliment']) ?></td>
            <td><?= esc($a['description']) ?></td>
            <td><?= esc($a['image']) ?></td>
            <td>
                <a href="/aliment/edit/<?= $a['id'] ?>">Edit</a>
                <form method="post" action="/aliment/delete/<?= $a['id'] ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" onclick="return confirm('Confirmer la suppression ?')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
