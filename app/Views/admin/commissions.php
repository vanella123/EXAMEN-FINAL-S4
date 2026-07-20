<?php $this->setVar('title', 'Commissions opérateurs') ?>
<?php $this->setVar('currentPage', 'commissions') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Configuration</span>
          <h1>Commissions opérateurs</h1>
          <p>Définissez les commissions applicables à chaque opérateur pour les transferts inter-opérateurs.</p>
        </div>
        <button type="button" class="btn btn-vola-primary" data-bs-toggle="modal" data-bs-target="#modalAjout">
          <i class="bi bi-plus-lg me-1"></i> Ajouter une commission
        </button>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Opérateur</th>
                <th>Commission (%)</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($commissions as $c): ?>
              <tr>
                <td class="fw-semibold"><?= esc($c['operateur']) ?></td>
                <td class="fw-semibold"><?= esc($c['pourcentage_commission']) ?> %</td>
                <td class="text-end">
                  <button class="btn btn-sm btn-vola-outline" data-bs-toggle="modal"
                    data-bs-target="#modalModifier"
                    data-id="<?= $c['id_commission_operateur'] ?>"
                    data-operateur="<?= $c['id_operateur'] ?>"
                    data-commission="<?= $c['pourcentage_commission'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('admin/commissions/delete/' . $c['id_commission_operateur']) ?>" class="btn btn-sm btn-vola-danger" onclick="return confirm('Supprimer cette commission ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

  <!-- Modal Ajouter -->
  <div class="modal fade" id="modalAjout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/commissions/create') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-plus-circle text-vola me-1"></i> Ajouter une commission</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Opérateur</label>
              <select name="id_operateur" class="form-select" required>
                <option value="">Choisir...</option>
                <?php foreach($operateurs as $op): ?>
                <option value="<?= $op['id_operateur'] ?>"><?= esc($op['libelle']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-1">
              <label class="form-label">Commission (%)</label>
              <input type="number" step="0.01" name="pourcentage_commission" class="form-control" placeholder="Ex: 2.50" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-vola-outline" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-vola-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Modifier -->
  <div class="modal fade" id="modalModifier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/commissions/update') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="id_commission_operateur" id="edit-id">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil-square text-vola me-1"></i> Modifier la commission</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Opérateur</label>
              <select name="id_operateur" class="form-select" id="edit-operateur" required>
                <?php foreach($operateurs as $op): ?>
                <option value="<?= $op['id_operateur'] ?>"><?= esc($op['libelle']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-1">
              <label class="form-label">Commission (%)</label>
              <input type="number" step="0.01" name="pourcentage_commission" class="form-control" id="edit-commission" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-vola-outline" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-vola-primary">Mettre à jour</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  document.getElementById('modalModifier')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-operateur').value = btn.dataset.operateur;
    document.getElementById('edit-commission').value = btn.dataset.commission;
  });
  </script>

<?= $this->include('admin/layouts/admin_footer') ?>
