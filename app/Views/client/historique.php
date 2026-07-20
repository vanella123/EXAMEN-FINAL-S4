<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historique — Vola+</title>
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-house-door"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('depot') ?>"><i class="bi bi-arrow-down-circle"></i> Dépôt</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('retrait') ?>"><i class="bi bi-arrow-up-circle"></i> Retrait</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('transfert') ?>"><i class="bi bi-send"></i> Transfert</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('historique') ?>"><i class="bi bi-clock-history"></i> Historique</a></li>
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
      <div class="page-header">
        <span class="text-eyebrow">Suivi</span>
        <h1>Historique des opérations</h1>
        <p>Toutes vos opérations effectuées sur votre compte Vola+.</p>
      </div>

      <?php if(empty($operations)): ?>
      <div class="alert alert-info">Aucune opération trouvée.</div>
      <?php else: ?>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Solde après</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($operations as $ligne): ?>
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
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>

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