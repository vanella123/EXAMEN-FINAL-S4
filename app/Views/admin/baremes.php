<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barèmes de frais — Vola+</title>
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/types-operations') ?>"><i class="bi bi-tags"></i> Types d'opérations</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/baremes') ?>"><i class="bi bi-percent"></i> Barèmes</a></li>
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
    </div>
  </main>

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

  <footer class="footer-vola"><div class="container"><div class="row gy-4"><div class="col-lg-4"><div class="footer-brand"><i class="bi bi-wallet2"></i> Vola+</div><p class="mt-3 small">Le porte-monnaie mobile qui simplifie vos dépôts, retraits et transferts, partout à Madagascar.</p></div><div class="col-lg-2 col-6"><h6>Client</h6><a href="<?= base_url('login') ?>" class="d-block">Connexion</a><a href="<?= base_url('client/dashboard') ?>" class="d-block">Tableau de bord</a></div><div class="col-lg-2 col-6"><h6>Opérateur</h6><a href="<?= base_url('admin/dashboard') ?>" class="d-block">Statistiques</a><a href="<?= base_url('admin/baremes') ?>" class="d-block">Barèmes</a><a href="<?= base_url('admin/comptes') ?>" class="d-block">Comptes</a></div><div class="col-lg-4"><h6>Assistance</h6><p class="small mb-1"><i class="bi bi-telephone"></i> 034 00 000 00</p><p class="small mb-1"><i class="bi bi-envelope"></i> contact@volaplus.mg</p></div></div><hr><div class="d-flex flex-column flex-md-row justify-content-between footer-bottom"><span>&copy; 2026 Vola+. Projet pédagogique — simulateur mobile money.</span><span>Fait avec <i class="bi bi-heart-fill text-gold"></i> à Madagascar</span></div></div></footer>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
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
</body>
</html>