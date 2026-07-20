<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord opérateur — Vola+</title>
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
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/prefixes') ?>"><i class="bi bi-sim"></i> Préfixes</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/types-operations') ?>"><i class="bi bi-tags"></i> Types d'opérations</a></li>
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
      <div class="page-header">
        <span class="text-eyebrow">Vue d'ensemble</span>
        <h1>Tableau de bord opérateur</h1>
        <p>Statistiques globales de la plateforme Vola+.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge blue"><i class="bi bi-people-fill"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_clients, 0, ' ', ' ') ?></div>
                <div class="stat-label">Comptes clients</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge teal"><i class="bi bi-arrow-left-right"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_operations, 0, ' ', ' ') ?></div>
                <div class="stat-label">Opérations réalisées</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge gold"><i class="bi bi-cash-coin"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_gains, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Total des gains</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge amber"><i class="bi bi-send-fill"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_transferts, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Montants transférés</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-lg-7">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="mb-3"><i class="bi bi-clock-history text-vola"></i> Dernières opérations sur la plateforme</h6>
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Client</th>
                      <th>Type</th>
                      <th>Montant</th>
                      <th>Frais</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($dernieres_operations)): ?>
                      <tr><td colspan="4" class="text-center">Aucune opération.</td></tr>
                    <?php else: ?>
                      <?php foreach($dernieres_operations as $op): ?>
                      <tr>
                        <td><?= esc($op['numero_telephone']) ?></td>
                        <td>
                          <?php $badge = match($op['type_operation']) {
                            'Depot' => 'badge-depot',
                            'Retrait' => 'badge-retrait',
                            default => 'badge-transfert'
                          }; ?>
                          <span class="badge-op <?= $badge ?>"><?= esc($op['type_operation']) ?></span>
                        </td>
                        <td><?= number_format((float)$op['montant'], 0, ' ', ' ') ?> Ar</td>
                        <td><?= number_format((float)$op['frais'], 0, ' ', ' ') ?> Ar</td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="mb-3"><i class="bi bi-pie-chart text-vola"></i> Répartition des gains</h6>
              <?php $totalGains = $gains_retrait + $gains_transfert; ?>
              <?php $pctRetrait = $totalGains > 0 ? round($gains_retrait / $totalGains * 100) : 0; ?>
              <?php $pctTransfert = $totalGains > 0 ? round($gains_transfert / $totalGains * 100) : 0; ?>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span><span class="badge-op badge-retrait me-2"><i class="bi bi-arrow-up-circle"></i></span>Retraits</span>
                <strong><?= number_format($gains_retrait, 0, ' ', ' ') ?> Ar</strong>
              </div>
              <div class="progress mb-4" style="height:8px;">
                <div class="progress-bar" style="width:<?= $pctRetrait ?>%; background-color: var(--vola-green-700);"></div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span><span class="badge-op badge-transfert me-2"><i class="bi bi-send"></i></span>Transferts</span>
                <strong><?= number_format($gains_transfert, 0, ' ', ' ') ?> Ar</strong>
              </div>
              <div class="progress" style="height:8px;">
                <div class="progress-bar" style="width:<?= $pctTransfert ?>%; background-color: var(--vola-gold);"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

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
        </div>
        <div class="col-lg-2 col-6">
          <h6>Opérateur</h6>
          <a href="<?= base_url('admin/dashboard') ?>" class="d-block">Statistiques</a>
          <a href="<?= base_url('admin/baremes') ?>" class="d-block">Barèmes</a>
          <a href="<?= base_url('admin/comptes') ?>" class="d-block">Comptes</a>
        </div>
        <div class="col-lg-4">
          <h6>Assistance</h6>
          <p class="small mb-1"><i class="bi bi-telephone"></i> 034 00 000 00</p>
          <p class="small mb-1"><i class="bi bi-envelope"></i> contact@volaplus.mg</p>
        </div>
      </div>
      <hr>
      <div class="d-flex flex-column flex-md-row justify-content-between footer-bottom">
        <span>&copy; 2026 Vola+. Projet pédagogique — simulateur mobile money.</span>
        <span>Fait avec <i class="bi bi-heart-fill text-gold"></i> à Madagascar</span>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>