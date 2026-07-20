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
  <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
