

<h2>Liste des régimes</h2>

<a href="/regime/create">Ajouter un régime</a>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Durée</th>
        <th>Variation poids</th>
        <th>Prix</th>
        <th>Aliments</th>
        <th>Actions</th>
    </tr>

    <?php foreach($regimes as $r): ?>
        <tr>
            <td><?= esc($r['nom']) ?></td>
            <td><?= $r['duree'] ?> jours</td>
            <td><?= $r['variation_poids'] ?> kg</td>
            <td><?= $r['prix'] ?> Ar</td>
            <td>
                <?php foreach ($r['aliments'] as $a): ?>
                    <div><?= esc($a['nom']) ?>: <?= $a['pourcentage'] ?>%</div>
                <?php endforeach; ?>
            </td>
            <td>
                <a href="/regime/edit/<?= $r['id'] ?>">Edit</a>
                <form method="post" action="/regime/delete/<?= $r['id'] ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" onclick="return confirm('Confirmer la suppression ?')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>