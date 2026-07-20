<?php $this->setVar('title', 'Types d\'opérations') ?>
<?php $this->setVar('currentPage', 'types-operations') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Configuration</span>
          <h1>Types d'opérations</h1>
          <p>Gérez les opérations disponibles pour les clients Vola+.</p>
        </div>
        <button type="button" class="btn btn-vola-primary" data-bs-toggle="modal" data-bs-target="#modalAjoutType">
          <i class="bi bi-plus-lg me-1"></i> Ajouter un type
        </button>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Code</th>
                <th>Libellé</th>
                <th>Frais applicable</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($types as $t): ?>
              <tr>
                <td><span class="fw-semibold"><?= esc($t['code']) ?></span></td>
                <td><?= esc($t['libelle']) ?></td>
                <td>
                  <?php if($t['frais_applicable']): ?>
                    <span class="badge rounded-pill text-bg-success">Oui</span>
                  <?php else: ?>
                    <span class="badge rounded-pill text-bg-secondary">Non</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <button class="btn btn-sm btn-vola-outline" data-bs-toggle="modal"
                    data-bs-target="#modalModifierType"
                    data-id="<?= $t['id_type_operation'] ?>"
                    data-code="<?= $t['code'] ?>"
                    data-libelle="<?= $t['libelle'] ?>"
                    data-frais="<?= $t['frais_applicable'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('admin/types-operations/delete/' . $t['id_type_operation']) ?>" class="btn btn-sm btn-vola-danger" onclick="return confirm('Supprimer ce type ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Ajouter -->
      <div class="modal fade" id="modalAjoutType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/types/create') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-plus-circle text-vola me-1"></i> Ajouter un type d'opération</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Code</label>
              <input type="text" class="form-control" name="code" placeholder="Ex: RETRAIT" maxlength="20" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Libellé</label>
              <input type="text" class="form-control" name="libelle" placeholder="Ex: Retrait" maxlength="50" required>
            </div>
            <div class="mb-1">
              <label class="form-label">Frais applicable</label>
              <select class="form-select" name="frais_applicable">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
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
  <div class="modal fade" id="modalModifierType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/types/update') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="id_type_operation" id="edit-id">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil-square text-vola me-1"></i> Modifier le type d'opération</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Code</label>
              <input type="text" class="form-control" name="code" id="edit-code" maxlength="20" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Libellé</label>
              <input type="text" class="form-control" name="libelle" id="edit-libelle" maxlength="50" required>
            </div>
            <div class="mb-1">
              <label class="form-label">Frais applicable</label>
              <select class="form-select" name="frais_applicable" id="edit-frais">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
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
  document.getElementById('modalModifierType')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-code').value = btn.dataset.code;
    document.getElementById('edit-libelle').value = btn.dataset.libelle;
    document.getElementById('edit-frais').value = btn.dataset.frais;
  });
  </script>

<?= $this->include('admin/layouts/admin_footer') ?>