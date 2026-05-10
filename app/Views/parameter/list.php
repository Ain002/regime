<h2>Paramètres</h2>

<a href="/parameter/create" class="btn btn-primary mb-3">➕ Ajouter un paramètre</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Clé</th>
            <th>Valeur</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($parameters as $param): ?>
            <tr>
                <td><?= esc($param['key']) ?></td>
                <td><?= esc($param['value']) ?></td>
                <td><?= esc($param['description']) ?></td>
                <td>
                    <a href="/parameter/edit/<?= $param['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                    <a href="/parameter/delete/<?= $param['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
