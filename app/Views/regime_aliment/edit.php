<?php $this->extend('layouts/admin') ?>
<?php $this->section('content') ?>
<div class="container mt-5">
    <h2>Modifier la composition</h2>
    <p class="text-muted">Régime: <?= esc($regime['nom']) ?> | Aliment: <?= esc($regimeAliment['nom']) ?></p>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/regime-aliment/update/<?= $regime['id'] ?>/<?= $regimeAliment['aliment_id'] ?>" method="POST" class="form mt-4">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Aliment</label>
            <input type="text" class="form-control" value="<?= esc($regimeAliment['nom']) ?>" disabled>
        </div>

        <div class="alert alert-info">
            <strong>⚠️ Important:</strong> Les pourcentages doivent totaliser <strong>100%</strong>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pourcentage_viande" class="form-label">% Viande <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" id="pourcentage_viande" name="pourcentage_viande" class="form-control" step="0.01" min="0" max="100" required value="<?= old('pourcentage_viande', $regimeAliment['pourcentage_viande']) ?>">
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="pourcentage_poisson" class="form-label">% Poisson <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" class="form-control" step="0.01" min="0" max="100" required value="<?= old('pourcentage_poisson', $regimeAliment['pourcentage_poisson']) ?>">
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="pourcentage_volaille" class="form-label">% Volaille <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" class="form-control" step="0.01" min="0" max="100" required value="<?= old('pourcentage_volaille', $regimeAliment['pourcentage_volaille']) ?>">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <div class="alert alert-secondary" role="alert">
                    <strong>Total: <span id="totalPercentage">0</span>%</strong>
                    <span id="totalStatus"></span>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
            <a href="/regime-aliment/<?= $regime['id'] ?>" class="btn btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viande = document.getElementById('pourcentage_viande');
    const poisson = document.getElementById('pourcentage_poisson');
    const volaille = document.getElementById('pourcentage_volaille');
    const totalSpan = document.getElementById('totalPercentage');
    const statusSpan = document.getElementById('totalStatus');

    function updateTotal() {
        const total = (parseFloat(viande.value) || 0) + (parseFloat(poisson.value) || 0) + (parseFloat(volaille.value) || 0);
        totalSpan.textContent = total.toFixed(2);
        
        if (Math.abs(total - 100) < 0.01) {
            statusSpan.innerHTML = '<span class="badge bg-success ms-2">✅ Valide</span>';
        } else if (total < 100) {
            statusSpan.innerHTML = '<span class="badge bg-warning ms-2">⚠️ Manquant: ' + (100 - total).toFixed(2) + '%</span>';
        } else {
            statusSpan.innerHTML = '<span class="badge bg-danger ms-2">❌ Excédent: ' + (total - 100).toFixed(2) + '%</span>';
        }
    }

    viande.addEventListener('change', updateTotal);
    poisson.addEventListener('change', updateTotal);
    volaille.addEventListener('change', updateTotal);
    
    updateTotal();
});
</script>

<?php $this->endSection() ?>
