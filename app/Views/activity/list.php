<h2>Liste des activités sportives</h2>

<a href="/activity/create">Ajouter une activité</a>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Variation poids</th>
        <th>Durée</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php foreach($activities as $activity): ?>
        <tr>
            <td><?= esc($activity['nom']) ?></td>
            <td><?= $activity['variation_poids'] ?> kg</td>
            <td><?= $activity['duree'] ?> min</td>
            <td><?= esc($activity['description']) ?></td>
            <td>
                <a href="/activity/edit/<?= $activity['id'] ?>">Edit</a>
                <form method="post" action="/activity/delete/<?= $activity['id'] ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" onclick="return confirm('Confirmer la suppression ?')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
