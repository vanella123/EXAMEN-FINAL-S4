<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gains — Vola+</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/baremes') ?>"><i class="bi bi-percent"></i> Barèmes</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/comptes') ?>"><i class="bi bi-people"></i> Comptes</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/gains') ?>"><i class="bi bi-graph-up-arrow"></i> Gains</a></li>
        </ul>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-logout mt-3 mt-lg-0"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>

  <main>
    <div class="container">
      <div class="page-header">
        <span class="text-eyebrow">Suivi financier</span>
        <h1>Situation des gains</h1>
        <p>Revenus générés par les frais sur les opérations de retrait et de transfert.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-lg-5">
          <div class="balance-card h-100">
            <i class="bi bi-cash-coin balance-card-icon"></i>
            <div class="position-relative">
              <div class="balance-label"><i class="bi bi-graph-up-arrow"></i> Gain total cumulé</div>
              <div class="balance-amount mt-2 mb-3"><?= number_format($total_gains, 0, ' ', ' ') ?> <span class="fs-5 fw-normal">Ar</span></div>
              <span class="badge bg-white text-vola rounded-pill px-3 py-2"><i class="bi bi-calendar3"></i> Depuis le lancement</span>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="row g-4 h-100">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body stat-card">
                  <div class="icon-badge amber"><i class="bi bi-arrow-up-circle"></i></div>
                  <div>
                    <div class="stat-value"><?= number_format($gains_retrait, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                    <div class="stat-label">Gains sur les retraits</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body stat-card">
                  <div class="icon-badge blue"><i class="bi bi-send"></i></div>
                  <div>
                    <div class="stat-value"><?= number_format($gains_transfert, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                    <div class="stat-label">Gains sur les transferts</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <h5 class="mb-3">Détail des gains par type d'opération</h5>
      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Type d'opération</th>
                <th>Nombre d'opérations</th>
                <th>Gain total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($gains as $g): ?>
              <tr>
                <td>
                  <?php $badge = match($g['type_operation']) {
                    'RETRAIT' => 'badge-retrait',
                    'DEPOT' => 'badge-depot',
                    default => 'badge-transfert'
                  }; ?>
                  <span class="badge-op <?= $badge ?>"><?= esc($g['type_operation']) ?></span>
                </td>
                <td><?= number_format((int)$g['nombre_operations'], 0, ' ', ' ') ?></td>
                <td class="fw-semibold text-vola"><?= number_format((float)$g['total_frais'], 0, ' ', ' ') ?> Ar</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="table-light">
                <td class="fw-bold">Total</td>
                <td class="fw-bold"><?= array_sum(array_column($gains, 'nombre_operations')) ?></td>
                <td class="fw-bold text-vola"><?= number_format($total_gains, 0, ' ', ' ') ?> Ar</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer-vola"><div class="container"><div class="row gy-4"><div class="col-lg-4"><div class="footer-brand"><i class="bi bi-wallet2"></i> Vola+</div><p class="mt-3 small">Le porte-monnaie mobile qui simplifie vos dépôts, retraits et transferts, partout à Madagascar.</p></div><div class="col-lg-2 col-6"><h6>Client</h6><a href="<?= base_url('login') ?>" class="d-block">Connexion</a><a href="<?= base_url('client/dashboard') ?>" class="d-block">Tableau de bord</a></div><div class="col-lg-2 col-6"><h6>Opérateur</h6><a href="<?= base_url('admin/dashboard') ?>" class="d-block">Statistiques</a><a href="<?= base_url('admin/baremes') ?>" class="d-block">Barèmes</a><a href="<?= base_url('admin/comptes') ?>" class="d-block">Comptes</a></div><div class="col-lg-4"><h6>Assistance</h6><p class="small mb-1"><i class="bi bi-telephone"></i> 034 00 000 00</p><p class="small mb-1"><i class="bi bi-envelope"></i> contact@volaplus.mg</p></div></div><hr><div class="d-flex flex-column flex-md-row justify-content-between footer-bottom"><span>&copy; 2026 Vola+. Projet pédagogique — simulateur mobile money.</span><span>Fait avec <i class="bi bi-heart-fill text-gold"></i> à Madagascar</span></div></div></footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>