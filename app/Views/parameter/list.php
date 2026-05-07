<h2>Paramètres</h2>

<table border="1">
    <tr>
        <th>Clé</th>
        <th>Valeur</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php foreach($parameters as $param): ?>
        <tr>
            <td><?= esc($param['key']) ?></td>
            <td><?= esc($param['value']) ?></td>
            <td><?= esc($param['description']) ?></td>
            <td>
                <a href="/parameter/edit/<?= $param['id'] ?>">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
