<?php $this->setVar('title', 'pourcentage client') ?>
<?php $this->setVar('currentPage', 'pourcentage') ?>
<?= $this->include('client/layouts/header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Configuration</span>
          <h1>Pourcentage Client client</h1>
          <p>Définissez les Pourcentage Client applicables à chaque opérateur pour les transferts inter-client.</p>
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
              <tr>
                <td class="fw-semibold"><?= esc($c['client']) ?></td>
                <td class="fw-semibold"><?= esc($c['pourcentage_epargne']) ?> %</td>
                
              </tr>
            </tbody>
          </table>
        </div>
      </div>

  <!-- Modal Ajouter -->
  <div class="modal fade" id="modalAjout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= base_url('admin/Pourcentage Client/create') ?>" method="post">
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
        <form action="<?= base_url('admin/Pourcentage Client/update') ?>" method="post">
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


  <footer class="footer-vola">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4">
          <div class="footer-brand"><i class="bi bi-wallet2"></i> Vola+</div>
          <p class="mt-3 small">Le porte-monnaie mobile qui simplifie vos dépôts, retraits et transferts, partout à Madagascar.</p>
        </div>
        <div class="col-lg-2 col-6">
          <h6>Client</h6>
          <a href="<?= base_url('login') ?>" class="d-block">Connexion</a>
          <a href="<?= base_url('client/dashboard') ?>" class="d-block">Tableau de bord</a>
          <a href="<?= base_url('historique') ?>" class="d-block">Historique</a>
        </div>
        <div class="col-lg-4">
          <h6>Assistance</h6>
          <p class="small mb-1"><i class="bi bi-telephone"></i> 034 00 000 00</p>
          <p class="small mb-1"><i class="bi bi-envelope"></i> contact@volaplus.mg</p>
          <p class="small"><i class="bi bi-geo-alt"></i> Antananarivo, Madagascar</p>
        </div>
      </div>
      <hr>
      <div class="d-flex flex-column flex-md-row justify-content-between footer-bottom">
        <span>&copy; 2026 Vola+. Projet pédagogique — simulateur mobile money.</span>
        <span>Fait avec <i class="bi bi-heart-fill text-gold"></i> à Madagascar</span>
      </div>
    </div>
  </footer>

  <script>
  document.getElementById('modalModifier')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-operateur').value = btn.dataset.operateur;
    document.getElementById('edit-commission').value = btn.dataset.commission;
  });
  </script>    
</body>
</html>