<?php $this->setVar('title', 'Historique  transaction') ?>
<?php $this->setVar('currentPage', 'historique') ?>
<?= $this->include('client/layouts/header') ?>


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

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
</body>
</html>