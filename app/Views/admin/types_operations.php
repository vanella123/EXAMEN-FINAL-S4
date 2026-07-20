<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Types d'opérations — Vola+</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
   <link rel="stylesheet" href="<?=base_url('css/bootstrap/css/bootstrap.min.css')?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('vola.css') ?>" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-vola" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-wallet2"></i> Vola+ <span class="fw-normal fs-6 ms-1 opacity-75">Opérateur</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navAdmin">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/prefixes') ?>"><i class="bi bi-sim"></i> Préfixes</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/types-operations') ?>"><i class="bi bi-tags"></i> Types d'opérations</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/baremes') ?>"><i class="bi bi-percent"></i> Barèmes</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/comptes') ?>"><i class="bi bi-people"></i> Comptes</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/gains') ?>"><i class="bi bi-graph-up-arrow"></i> Gains</a></li>
        </ul>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-logout mt-3 mt-lg-0"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>

  <main>
    <div class="container">
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success mt-3"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
      <?php if($errors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger mt-3">
          <?php foreach($errors as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

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
    </div>
  </main>

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

  <footer class="footer-vola"><div class="container"><div class="row gy-4"><div class="col-lg-4"><div class="footer-brand"><i class="bi bi-wallet2"></i> Vola+</div><p class="mt-3 small">Le porte-monnaie mobile qui simplifie vos dépôts, retraits et transferts, partout à Madagascar.</p></div><div class="col-lg-2 col-6"><h6>Client</h6><a href="<?= base_url('login') ?>" class="d-block">Connexion</a><a href="<?= base_url('client/dashboard') ?>" class="d-block">Tableau de bord</a></div><div class="col-lg-2 col-6"><h6>Opérateur</h6><a href="<?= base_url('admin/dashboard') ?>" class="d-block">Statistiques</a><a href="<?= base_url('admin/baremes') ?>" class="d-block">Barèmes</a><a href="<?= base_url('admin/comptes') ?>" class="d-block">Comptes</a></div><div class="col-lg-4"><h6>Assistance</h6><p class="small mb-1"><i class="bi bi-telephone"></i> 034 00 000 00</p><p class="small mb-1"><i class="bi bi-envelope"></i> contact@volaplus.mg</p></div></div><hr><div class="d-flex flex-column flex-md-row justify-content-between footer-bottom"><span>&copy; 2026 Vola+. Projet pédagogique — simulateur mobile money.</span><span>Fait avec <i class="bi bi-heart-fill text-gold"></i> à Madagascar</span></div></div></footer>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script>
  document.getElementById('modalModifierType')?.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-code').value = btn.dataset.code;
    document.getElementById('edit-libelle').value = btn.dataset.libelle;
    document.getElementById('edit-frais').value = btn.dataset.frais;
  });
  </script>
</body>
</html>