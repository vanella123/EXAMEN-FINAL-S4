<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retrait — Vola+</title>
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
      <a class="navbar-brand" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-wallet2"></i> Vola+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navClient">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navClient">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-house-door"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('depot') ?>"><i class="bi bi-arrow-down-circle"></i> Dépôt</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('retrait') ?>"><i class="bi bi-arrow-up-circle"></i> Retrait</a></li>
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
      <div class="page-header text-center">
        <span class="text-eyebrow">Opération</span>
        <h1>Faire un retrait</h1>
        <p>Solde disponible : <strong><?= number_format($solde, 0, ' ', ' ') ?> Ar</strong></p>
      </div>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="form-card mb-5">
        <div class="card">
          <div class="card-body p-4 p-md-5">
            <form action="<?= base_url('retrait/save') ?>" method="post" id="formRetrait">
              <?= csrf_field() ?>
              <div class="mb-3">
                <label class="form-label">Numéro de compte</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input type="tel" class="form-control" value="<?= esc($numero) ?>" readonly>
                </div>
              </div>

              <div class="mb-4">
                <label for="montant" class="form-label">Montant à retirer</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" min="100" step="any" class="form-control" id="montant" name="montant" placeholder="Ex: 45000" required>
                </div>
                <div class="form-text">Les frais sont calculés automatiquement selon le barème en vigueur.</div>
              </div>

              <div class="recap-card mb-4">
                <div class="recap-row">
                  <span class="text-secondary">Montant demandé</span>
                  <span class="fw-semibold" id="recapMontant">0 Ar</span>
                </div>
                <div class="recap-row">
                  <span class="text-secondary">Frais de retrait</span>
                  <span class="fw-semibold" id="recapFrais">0 Ar</span>
                </div>
                <div class="recap-row total">
                  <span>Total débité</span>
                  <span id="recapTotal">0 Ar</span>
                </div>
              </div>

              <button type="submit" class="btn btn-vola-primary w-100">
                <i class="bi bi-check2-circle me-1"></i> Confirmer le retrait
              </button>
            </form>
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

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script>
    const montantInput = document.getElementById('montant');
    const recapMontant = document.getElementById('recapMontant');
    const recapFrais = document.getElementById('recapFrais');
    const recapTotal = document.getElementById('recapTotal');

    function formatAr(n) {
      return new Intl.NumberFormat('fr-FR').format(n) + ' Ar';
    }

    function estimerFrais(montant) {
      if (montant <= 0) return 0;
      if (montant <= 5000) return 100;
      if (montant <= 15000) return 300;
      if (montant <= 50000) return 700;
      return 0;
    }

    montantInput?.addEventListener('input', () => {
      const montant = parseFloat(montantInput.value) || 0;
      const frais = estimerFrais(montant);
      recapMontant.textContent = formatAr(montant);
      recapFrais.textContent = formatAr(frais);
      recapTotal.textContent = formatAr(montant + frais);
    });
  </script>
</body>
</html>