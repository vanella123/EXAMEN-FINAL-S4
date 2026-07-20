<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion client — Vola+</title>
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublic">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navPublic">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('login') ?>"><i class="bi bi-person-circle"></i> Espace client</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <section class="section-gap">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
              <div class="icon-badge mx-auto mb-3"><i class="bi bi-telephone-fill"></i></div>
              <span class="text-eyebrow">Espace client</span>
              <h1 class="h3 mt-1">Connexion rapide</h1>
              <p class="text-secondary">Aucune inscription requise. Entrez votre numéro pour accéder à votre compte.</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
              <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('login') ?>" method="post">
                  <?= csrf_field() ?>
                  <label for="telephone" class="form-label">Numéro de téléphone</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                    <input type="tel" class="form-control" id="telephone" name="numero" placeholder="034 12 345 67" maxlength="10" required>
                  </div>
                  <div class="form-text mb-4">Préfixes acceptés : 033, 034, 037, 038.</div>
                  <button type="submit" class="btn btn-vola-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                  </button>
                </form>
              </div>
            </div>

            <p class="text-center text-secondary small mt-4">
              <i class="bi bi-info-circle"></i> Votre compte est créé automatiquement dès votre première connexion.
            </p>
          </div>
        </div>
      </div>
    </section>
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