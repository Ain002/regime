

<h2>Liste des régimes</h2>

<a href="/regime/create" class="btn btn-primary mb-3">➕ Ajouter un régime</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Durée</th>
            <th>Variation poids</th>
            <th>Prix</th>
            <th>Aliments</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($regimes as $r): ?>
            <tr>
                <td><?= esc($r['nom']) ?></td>
                <td><?= $r['duree'] ?> jours</td>
                <td><?= $r['variation_poids'] ?> kg</td>
                <td><?= number_format($r['prix'], 0, ',', ' ') ?> Ar</td>
                <td>
                    <small>
                        <?php foreach ($r['aliments'] as $a): ?>
                            <div><?= esc($a['nom']) ?>: <?= $a['pourcentage'] ?>%</div>
                        <?php endforeach; ?>
                    </small>
                </td>
                <td>
                    <a href="/regime/edit/<?= $r['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                    <a href="/regime-sport/<?= $r['id'] ?>" class="btn btn-sm btn-info">🏃 Sports</a>
                    <form method="post" action="/regime/delete/<?= $r['id'] ?>" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>