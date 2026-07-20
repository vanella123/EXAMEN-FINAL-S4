<?php $this->setVar('title', 'Préfixes') ?>
<?php $this->setVar('currentPage', 'prefixes') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Configuration</span>
          <h1>Préfixes opérateur</h1>
          <p>Définissez les préfixes téléphoniques reconnus par Vola+.</p>
        </div>
        <button type="button" class="btn btn-vola-primary" data-bs-toggle="modal" data-bs-target="#modalAjoutPrefixe">
          <i class="bi bi-plus-lg me-1"></i> Ajouter un préfixe
        </button>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Préfixe</th>
                <th>Statut</th>
                <th>Opérateur</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($prefixes as $p): ?>
              <tr>
                <td class="fw-semibold"><?= esc($p['prefixe']) ?></td>
                <td class="fw-semibold">
                  <?php if($p['actif']): ?>
                    <span class="badge rounded-pill text-bg-success">Actif</span>
                  <?php else: ?>
                    <span class="badge rounded-pill text-bg-secondary">Inactif</span>
                  <?php endif; ?>

                </td>
                <td class="fw-semibold">
                    <?= esc($p['operateur']); ?>
                </td>
                <td class="text-end">
                  <button class="btn btn-sm btn-vola-outline" data-bs-toggle="modal"
                    data-bs-target="#modalModifierPrefixe"
                    data-id="<?= $p['id_prefixe'] ?>"
                    data-prefixe="<?= $p['prefixe'] ?>"
                    data-actif="<?= $p['actif'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('admin/prefixes/delete/' . $p['id_prefixe']) ?>" class="btn btn-sm btn-vola-danger" onclick="return confirm('Supprimer ce préfixe ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Ajouter -->
      <div class="modal fade" id="modalAjoutPrefixe" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/prefixes/create') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-plus-circle text-vola me-1"></i> Ajouter un préfixe</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Préfixe</label>
              <input type="text" class="form-control" name="prefixe" placeholder="Ex: 034" maxlength="3" required>
            </div>
            <div class="mb-1">
              <label class="form-label">Statut</label>
              <select class="form-select" name="actif">
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
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
  <div class="modal fade" id="modalModifierPrefixe" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/prefixes/update') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="id_prefixe" id="edit-id">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil-square text-vola me-1"></i> Modifier le préfixe</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Préfixe</label>
              <input type="text" class="form-control" name="prefixe" id="edit-prefixe" maxlength="3" required>
            </div>
            <div class="mb-1">
              <label class="form-label">Statut</label>
              <select class="form-select" name="actif" id="edit-actif">
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
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
  document.getElementById('modalModifierPrefixe')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-prefixe').value = btn.dataset.prefixe;
    document.getElementById('edit-actif').value = btn.dataset.actif;
  });
  </script>

<?= $this->include('admin/layouts/admin_footer') ?>