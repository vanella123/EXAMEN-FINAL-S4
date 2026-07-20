<?php $this->setVar('title', 'Barèmes de frais') ?>
<?php $this->setVar('currentPage', 'baremes') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Configuration</span>
          <h1>Barèmes des frais</h1>
          <p>Définissez les frais par tranche de montant pour chaque type d'opération.</p>
        </div>
        <button type="button" class="btn btn-vola-primary" data-bs-toggle="modal" data-bs-target="#modalAjoutBareme">
          <i class="bi bi-plus-lg me-1"></i> Ajouter un barème
        </button>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Type</th>
                <th>Montant minimum</th>
                <th>Montant maximum</th>
                <th>Frais</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($baremes as $b): ?>
              <tr>
                <td>
                  <?php $badge = match($b['code']) {
                    'RETRAIT' => 'badge-retrait',
                    'DEPOT' => 'badge-depot',
                    default => 'badge-transfert'
                  }; ?>
                  <span class="badge-op <?= $badge ?>"><?= esc($b['libelle']) ?></span>
                </td>
                <td><?= number_format((float)$b['montant_min'], 0, ' ', ' ') ?> Ar</td>
                <td><?= number_format((float)$b['montant_max'], 0, ' ', ' ') ?> Ar</td>
                <td class="fw-semibold"><?= number_format((float)$b['frais'], 0, ' ', ' ') ?> Ar</td>
                <td class="text-end">
                  <button class="btn btn-sm btn-vola-outline" data-bs-toggle="modal"
                    data-bs-target="#modalModifierBareme"
                    data-id="<?= $b['id_bareme'] ?>"
                    data-type="<?= $b['id_type_operation'] ?>"
                    data-min="<?= $b['montant_min'] ?>"
                    data-max="<?= $b['montant_max'] ?>"
                    data-frais="<?= $b['frais'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('admin/baremes/delete/' . $b['id_bareme']) ?>" class="btn btn-sm btn-vola-danger" onclick="return confirm('Supprimer ce barème ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Ajouter -->
      <div class="modal fade" id="modalAjoutBareme" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/baremes/create') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-plus-circle text-vola me-1"></i> Ajouter un barème</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Type d'opération</label>
              <select class="form-select" name="id_type_operation" required>
                <option value="">Choisir...</option>
                <?php foreach($types as $t): ?>
                <option value="<?= $t['id_type_operation'] ?>"><?= esc($t['libelle']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label">Montant minimum</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" class="form-control" name="montant_min" placeholder="0" required>
                </div>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">Montant maximum</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" class="form-control" name="montant_max" placeholder="20000" required>
                </div>
              </div>
            </div>
            <div class="mb-1">
              <label class="form-label">Frais</label>
              <div class="input-group">
                <span class="input-group-text">Ar</span>
                <input type="number" class="form-control" name="frais" placeholder="200" required>
              </div>
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
  <div class="modal fade" id="modalModifierBareme" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/baremes/update') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="id_bareme" id="edit-id">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil-square text-vola me-1"></i> Modifier le barème</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Type d'opération</label>
              <select class="form-select" name="id_type_operation" id="edit-type" required>
                <?php foreach($types as $t): ?>
                <option value="<?= $t['id_type_operation'] ?>"><?= esc($t['libelle']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label">Montant minimum</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" class="form-control" name="montant_min" id="edit-min" required>
                </div>
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">Montant maximum</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" class="form-control" name="montant_max" id="edit-max" required>
                </div>
              </div>
            </div>
            <div class="mb-1">
              <label class="form-label">Frais</label>
              <div class="input-group">
                <span class="input-group-text">Ar</span>
                <input type="number" class="form-control" name="frais" id="edit-frais" required>
              </div>
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
  document.getElementById('modalModifierBareme')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-type').value = btn.dataset.type;
    document.getElementById('edit-min').value = btn.dataset.min;
    document.getElementById('edit-max').value = btn.dataset.max;
    document.getElementById('edit-frais').value = btn.dataset.frais;
  });
  </script>

<?= $this->include('admin/layouts/admin_footer') ?>