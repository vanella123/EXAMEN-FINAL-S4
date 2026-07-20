<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil — Vola+</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('vola.css') ?>" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-vola" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="bi bi-wallet2"></i> Vola+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublic">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navPublic">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>"><i class="bi bi-person-circle"></i> Espace client</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/login') ?>"><i class="bi bi-speedometer2"></i> Espace opérateur</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <section class="hero-vola">
      <div class="container hero-content text-center">
        <span class="badge rounded-pill bg-white text-vola px-3 py-2 mb-3"><i class="bi bi-shield-check"></i> Simulateur mobile money</span>
        <h1>Envoyez, recevez et gérez votre argent avec Vola+</h1>
        <p class="col-lg-7 mx-auto">Dépôts, retraits et transferts instantanés depuis votre téléphone. Choisissez votre espace pour commencer.</p>
      </div>
    </section>

    <section class="selector-section">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div class="col-md-5">
            <a href="<?= base_url('login') ?>" class="text-decoration-none">
              <div class="card card-link-select">
                <div class="card-body text-center py-5">
                  <div class="icon-badge mx-auto mb-3"><i class="bi bi-person-circle"></i></div>
                  <h3 class="mb-2">Espace Client</h3>
                  <p class="text-secondary mb-4">Consultez votre solde, effectuez un dépôt, un retrait ou un transfert en quelques secondes.</p>
                  <span class="btn btn-vola-primary">Accéder à mon compte <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-5">
            <a href="<?= base_url('admin/login') ?>" class="text-decoration-none">
              <div class="card card-link-select">
                <div class="card-body text-center py-5">
                  <div class="icon-badge gold mx-auto mb-3"><i class="bi bi-speedometer2"></i></div>
                  <h3 class="mb-2">Espace Opérateur</h3>
                  <p class="text-secondary mb-4">Configurez les préfixes, les barèmes de frais et suivez les gains et les comptes clients.</p>
                  <span class="btn btn-vola-gold">Ouvrir le back-office <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="section-gap">
      <div class="container">
        <div class="row g-4 text-center">
          <div class="col-md-4">
            <div class="icon-badge sm mx-auto mb-3"><i class="bi bi-lightning-charge"></i></div>
            <h5>Instantané</h5>
            <p class="text-secondary small">Toutes les opérations sont traitées immédiatement, sans délai d'attente.</p>
          </div>
          <div class="col-md-4">
            <div class="icon-badge sm blue mx-auto mb-3"><i class="bi bi-percent"></i></div>
            <h5>Frais transparents</h5>
            <p class="text-secondary small">Un barème clair par tranche de montant, affiché avant chaque validation.</p>
          </div>
          <div class="col-md-4">
            <div class="icon-badge sm teal mx-auto mb-3"><i class="bi bi-clock-history"></i></div>
            <h5>Historique complet</h5>
            <p class="text-secondary small">Retrouvez à tout moment le détail de vos dépôts, retraits et transferts.</p>
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
