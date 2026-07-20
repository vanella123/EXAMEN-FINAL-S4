<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord — Vola+</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('vola.css') ?>" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-vola" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-wallet2"></i> Vola+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navClient">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navClient">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-house-door"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('depot') ?>"><i class="bi bi-arrow-down-circle"></i> Dépôt</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('retrait') ?>"><i class="bi bi-arrow-up-circle"></i> Retrait</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('transfert') ?>"><i class="bi bi-send"></i> Transfert</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('historique') ?>"><i class="bi bi-clock-history"></i> Historique</a></li>
        </ul>
        <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
          <span class="phone-chip"><i class="bi bi-telephone-fill"></i> <?= esc($numero) ?></span>
          <a href="<?= base_url('logout') ?>" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
      </div>
    </div>
  </nav>

  <main>
    <div class="container">
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success mt-3"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <div class="page-header">
        <span class="text-eyebrow">Bienvenue</span>
        <h1>Bonjour, <?= esc($numero) ?></h1>
        <p>Voici un aperçu de votre compte Vola+.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-lg-7">
          <div class="balance-card h-100">
            <i class="bi bi-wallet2 balance-card-icon"></i>
            <div class="position-relative">
              <div class="balance-label"><i class="bi bi-shield-check"></i> Solde disponible</div>
              <div class="balance-amount mt-2 mb-3"><?= number_format($solde, 0, ' ', ' ') ?> <span class="fs-5 fw-normal">Ar</span></div>
              <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-vola rounded-pill px-3 py-2"><i class="bi bi-telephone-fill"></i> <?= esc($numero) ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <h5 class="mb-3">Actions rapides</h5>
      <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
          <a href="<?= base_url('depot') ?>" class="card card-link-select text-decoration-none">
            <div class="quick-action">
              <div class="icon-badge"><i class="bi bi-arrow-down-circle"></i></div>
              <span>Dépôt</span>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="<?= base_url('retrait') ?>" class="card card-link-select text-decoration-none">
            <div class="quick-action">
              <div class="icon-badge amber"><i class="bi bi-arrow-up-circle"></i></div>
              <span>Retrait</span>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="<?= base_url('transfert') ?>" class="card card-link-select text-decoration-none">
            <div class="quick-action">
              <div class="icon-badge blue"><i class="bi bi-send"></i></div>
              <span>Transfert</span>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-3">
          <a href="<?= base_url('historique') ?>" class="card card-link-select text-decoration-none">
            <div class="icon-badge teal"><i class="bi bi-clock-history"></i></div>
            <span>Historique</span>
          </a>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Dernières opérations</h5>
        <a href="<?= base_url('historique') ?>" class="small">Voir tout l'historique <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Solde après</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($historique)): ?>
                <tr><td colspan="4" class="text-center">Aucune opération.</td></tr>
              <?php else: ?>
                <?php foreach($historique as $ligne): ?>
                <tr>
                  <td><?= esc($ligne['date_operation']) ?></td>
                  <td>
                    <?php $badgeClass = match($ligne['type_operation']) {
                      'Dépôt', 'Depot' => 'badge-depot',
                      'Retrait' => 'badge-retrait',
                      default => 'badge-transfert'
                    }; ?>
                    <span class="badge-op <?= $badgeClass ?>"><?= esc($ligne['type_operation']) ?></span>
                  </td>
                  <td><?= number_format((float)$ligne['montant_mouvement'], 0, ' ', ' ') ?> Ar</td>
                  <td><?= number_format((float)$ligne['solde_apres'], 0, ' ', ' ') ?> Ar</td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>