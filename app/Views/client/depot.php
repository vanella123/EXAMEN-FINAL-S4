<?php $this->setVar('title', 'Depot client') ?>
<?php $this->setVar('currentPage', 'depot') ?>
<?= $this->include('client/layouts/header') ?>

  <main>
    <div class="container">
      <div class="page-header text-center">
        <span class="text-eyebrow">Opération</span>
        <h1>Faire un dépôt</h1>
        <p>Le montant sera crédité immédiatement sur votre compte.</p>
      </div>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="form-card mb-5">
        <div class="card">
          <div class="card-body p-4 p-md-5">
            <form action="<?= base_url('depot/save') ?>" method="post">
              <?= csrf_field() ?>
              <div class="mb-3">
                <label class="form-label">Numéro de compte</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                  <input type="tel" class="form-control" value="<?= esc($numero) ?>" readonly>
                </div>
              </div>

              <div class="mb-4">
                <label for="montant" class="form-label">Montant à déposer</label>
                <div class="input-group">
                  <span class="input-group-text">Ar</span>
                  <input type="number" min="1" step="any" class="form-control" id="montant" name="montant" placeholder="Ex: 50000" required>
                </div>
              </div>

              <button type="submit" class="btn btn-vola-primary w-100">
                <i class="bi bi-check2-circle me-1"></i> Confirmer le dépôt
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
</body>
</html>