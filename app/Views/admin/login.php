<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion opérateur — Vola+</title>
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
    </div>
  </nav>

  <main>
    <section class="section-gap">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
              <div class="icon-badge gold mx-auto mb-3"><i class="bi bi-shield-lock-fill"></i></div>
              <span class="text-eyebrow">Epace opérateur</span>
              <h1 class="h3 mt-1">Connexion administrateur</h1>
              <p class="text-secondary">Accès réservé aux opérateurs Vola+.</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
              <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('admin/login') ?>" method="post">
                  <?= csrf_field() ?>
                  <div class="mb-3">
                    <label class="form-label">Identifiant</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                      <input type="text" class="form-control" name="login" placeholder="admin" required>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                      <input type="password" class="form-control" name="mot_de_passe" placeholder="••••••••" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-vola-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                  </button>
                </form>
              </div>
            </div>
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
        </div>
        <div class="col-lg-2 col-6">
          <h6>Opérateur</h6>
          <a href="<?= base_url('admin/dashboard') ?>" class="d-block">Statistiques</a>
          <a href="<?= base_url('admin/baremes') ?>" class="d-block">Barèmes</a>
          <a href="<?= base_url('admin/comptes') ?>" class="d-block">Comptes</a>
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