<h2>Gestion des codes porte-monnaie</h2>

<div>
    <a href="?filter=pending">En attente (<?= count(array_filter($codes, fn($c) => $c['status'] === 'pending')) ?>)</a>
    <a href="?filter=approved">Approuvés</a>
    <a href="?filter=rejected">Rejetés</a>
    <a href="?filter=used">Utilisés</a>
    <a href="?filter=all">Tous</a>
</div>

<table border="1">
    <tr>
        <th>Code</th>
        <th>Montant</th>
        <th>User ID</th>
        <th>Statut</th>
        <th>Demandé le</th>
        <th>Approuvé le</th>
        <th>Actions</th>
    </tr>

    <?php foreach($codes as $code): ?>
        <tr>
            <td><?= esc($code['code']) ?></td>
            <td><?= $code['value'] ?> Ar</td>
            <td><?= $code['user_id'] ?></td>
            <td><?= esc($code['status']) ?></td>
            <td><?= $code['requested_at'] ?></td>
            <td><?= $code['approved_at'] ?></td>
            <td>
                <?php if ($code['status'] === 'pending'): ?>
                    <a href="/admin/wallet/approve/<?= $code['id'] ?>">Approuver</a>
                    <a href="/admin/wallet/reject/<?= $code['id'] ?>">Rejeter</a>
                <?php elseif ($code['status'] === 'approved'): ?>
                    <a href="/admin/wallet/mark-used/<?= $code['id'] ?>">Marquer utilisé</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
