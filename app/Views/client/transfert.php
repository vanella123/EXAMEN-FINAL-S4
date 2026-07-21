<?php $this->setVar('title', 'Transfert client') ?>
<?php $this->setVar('currentPage', 'transfert') ?>
<?= $this->include('client/layouts/header') ?>


  <main>
    <div class="container">
      <div class="page-header text-center">
        <span class="text-eyebrow">Opération</span>
        <h1>Faire un transfert</h1>
        <p>Solde disponible : <strong><?= number_format($solde, 0, ' ', ' ') ?> Ar</strong></p>
      </div>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <!-- Onglets: Simple / Multiple -->
      <ul class="nav nav-tabs nav-justified mb-4" id="transfertTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="simple-tab" data-bs-toggle="tab" data-bs-target="#simple" type="button" role="tab">
            <i class="bi bi-send me-1"></i> Transfert simple
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="multiple-tab" data-bs-toggle="tab" data-bs-target="#multiple" type="button" role="tab">
            <i class="bi bi-send-plus me-1"></i> Transfert multiple
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- ============================================================ -->
        <!-- TRANSFERT SIMPLE -->
        <!-- ============================================================ -->
        <div class="tab-pane fade show active" id="simple" role="tabpanel">
          <div class="form-card mb-5">
            <div class="card">
              <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('transfert/save') ?>" method="post" id="formTransfert">
                  <?= csrf_field() ?>
                  <div class="mb-3">
                    <label for="destinataire" class="form-label">Numéro du destinataire</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                      <input type="tel" class="form-control" id="destinataire" name="destinataire" placeholder="Ex: 033 45 678 90" maxlength="10" required>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="montant" class="form-label" id="labelMontant">Montant à transférer</label>
                    <div class="input-group">
                      <span class="input-group-text">Ar</span>
                      <input type="number" min="100" step="any" class="form-control" id="montant" name="montant" placeholder="Ex: 25000" required>
                    </div>
                  </div>

                  <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="inclureFrais" name="inclure_frais">
                    <label class="form-check-label" for="inclureFrais">
                      Inclure les frais de retrait du destinataire
                    </label>
                    <div class="form-text small text-secondary">
                      L'expéditeur prend en charge les frais de retrait. Le destinataire reçoit le montant intégral.
                    </div>
                  </div>

                  <div class="recap-card mb-4">
                    <div class="recap-row">
                      <span class="text-secondary" id="labelRecapMontant">Montant envoyé</span>
                      <span class="fw-semibold" id="recapMontant">0 Ar</span>
                    </div>
                    <div class="recap-row">
                      <span class="text-secondary">Frais de transfert</span>
                      <span class="fw-semibold" id="recapFrais">0 Ar</span>
                    </div>
                    <div class="recap-row" id="rowFraisRetrait" style="display:none;">
                      <span class="text-secondary">Frais retrait inclus</span>
                      <span class="fw-semibold" id="recapFraisRetrait">0 Ar</span>
                    </div>
                    <div class="recap-row total">
                      <span>Total débité</span>
                      <span id="recapTotal">0 Ar</span>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-vola-primary w-100">
                    <i class="bi bi-send-check me-1"></i> Transférer
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================ -->
        <!-- TRANSFERT MULTIPLE -->
        <!-- ============================================================ -->
        <div class="tab-pane fade" id="multiple" role="tabpanel">
          <div class="form-card mb-5">
            <div class="card">
              <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('transfert/save-multiple') ?>" method="post" id="formTransfertMultiple">
                  <?= csrf_field() ?>
                  <div class="mb-3">
                    <label for="montant_total" class="form-label">Montant total à envoyer</label>
                    <div class="input-group">
                      <span class="input-group-text">Ar</span>
                      <input type="number" min="100" step="any" class="form-control" id="montant_total" name="montant_total" placeholder="Ex: 30000" required>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="destinataires" class="form-label">Destinataires (un par ligne)</label>
                    <textarea class="form-control" id="destinataires" name="destinataires" rows="4" placeholder="0341111111&#10;0322222222&#10;0333333333" required></textarea>
                    <div class="form-text small text-secondary">
                      Saisissez un numéro par ligne. Le montant sera divisé équitablement.
                    </div>
                  </div>

                  <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="inclureFraisMultiple" name="inclure_frais_multiple">
                    <label class="form-check-label" for="inclureFraisMultiple">
                      Inclure les frais de retrait des destinataires
                    </label>
                    <div class="form-text small text-secondary">
                      Les frais de retrait de chaque destinataire sont ajoutés au total débité.
                    </div>
                  </div>

                  <div class="recap-card mb-4">
                    <div class="recap-row">
                      <span class="text-secondary">Montant total</span>
                      <span class="fw-semibold" id="recapTotalMultiple">0 Ar</span>
                    </div>
                    <div class="recap-row">
                      <span class="text-secondary">Nombre de destinataires</span>
                      <span class="fw-semibold" id="recapNbDest">0</span>
                    </div>
                    <div class="recap-row">
                      <span class="text-secondary">Montant par personne</span>
                      <span class="fw-semibold" id="recapParPersonne">0 Ar</span>
                    </div>
                    <div class="recap-row">
                      <span class="text-secondary">Frais de transfert</span>
                      <span class="fw-semibold" id="recapFraisMultiple">0 Ar</span>
                    </div>
                    <div class="recap-row" id="rowFraisRetraitMultiple" style="display:none;">
                      <span class="text-secondary">Frais retrait inclus (x<span id="recapNbDestFrais">0</span>)</span>
                      <span class="fw-semibold" id="recapFraisRetraitMultiple">0 Ar</span>
                    </div>
                    <div class="recap-row total">
                      <span>Total débité</span>
                      <span id="recapTotalDebiteMultiple">0 Ar</span>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-vola-primary w-100">
                    <i class="bi bi-send-check me-1"></i> Envoyer à tous
                  </button>
                </form>
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

  <script src="<?= base_url('css/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script>
    const montantInput = document.getElementById('montant');
    const recapMontant = document.getElementById('recapMontant');
    const recapFrais = document.getElementById('recapFrais');
    const recapTotal = document.getElementById('recapTotal');
    const recapFraisRetrait = document.getElementById('recapFraisRetrait');
    const rowFraisRetrait = document.getElementById('rowFraisRetrait');
    const labelMontant = document.getElementById('labelMontant');
    const labelRecapMontant = document.getElementById('labelRecapMontant');
    const inclureFrais = document.getElementById('inclureFrais');

    function formatAr(n) {
      return new Intl.NumberFormat('fr-FR').format(n) + ' Ar';
    }

    function estimerFraisTransfert(montant) {
      if (montant <= 0) return 0;
      if (montant <= 5000) return 50;
      if (montant <= 15000) return 150;
      if (montant <= 50000) return 400;
      return 4000;
    }

    function estimerFraisRetrait(montant) {
      if (montant <= 0) return 0;
      if (montant <= 5000) return 100;
      if (montant <= 15000) return 300;
      if (montant <= 50000) return 700;
      return 4000;
    }

    function mettreAJourRecapSimple() {
      const montant = parseFloat(montantInput?.value) || 0;
      const fraisTransfert = estimerFraisTransfert(montant);
      const avecRetrait = inclureFrais?.checked || false;
      const fraisRetrait = avecRetrait ? estimerFraisRetrait(montant) : 0;

      recapMontant.textContent = formatAr(montant);
      recapFrais.textContent = formatAr(fraisTransfert);

      if (avecRetrait) {
        rowFraisRetrait.style.display = '';
        recapFraisRetrait.textContent = formatAr(fraisRetrait);
      } else {
        rowFraisRetrait.style.display = 'none';
      }

      recapTotal.textContent = formatAr(montant + fraisTransfert + fraisRetrait);
    }

    montantInput?.addEventListener('input', mettreAJourRecapSimple);

    inclureFrais?.addEventListener('change', () => {
      if (inclureFrais.checked) {
        labelMontant.textContent = 'Montant à recevoir par le destinataire';
        labelRecapMontant.textContent = 'Montant reçu';
      } else {
        labelMontant.textContent = 'Montant à transférer';
        labelRecapMontant.textContent = 'Montant envoyé';
      }
      mettreAJourRecapSimple();
    });

    // --- TRANSFERT MULTIPLE ---
    const montantTotalInput = document.getElementById('montant_total');
    const destinatairesTextarea = document.getElementById('destinataires');
    const recapTotalMultiple = document.getElementById('recapTotalMultiple');
    const recapNbDest = document.getElementById('recapNbDest');
    const recapNbDestFrais = document.getElementById('recapNbDestFrais');
    const recapParPersonne = document.getElementById('recapParPersonne');
    const recapFraisMultiple = document.getElementById('recapFraisMultiple');
    const recapFraisRetraitMultiple = document.getElementById('recapFraisRetraitMultiple');
    const rowFraisRetraitMultiple = document.getElementById('rowFraisRetraitMultiple');
    const recapTotalDebiteMultiple = document.getElementById('recapTotalDebiteMultiple');
    const inclureFraisMultiple = document.getElementById('inclureFraisMultiple');

    function mettreAJourRecapMultiple() {
      const total = parseFloat(montantTotalInput?.value) || 0;
      const lignes = destinatairesTextarea?.value.split('\n').filter(l => l.trim() !== '') || [];
      const nb = lignes.length;
      const parPersonne = nb > 0 ? total / nb : 0;
      const fraisTransfert = estimerFraisTransfert(total);
      const avecRetrait = inclureFraisMultiple?.checked || false;
      const fraisRetraitParPersonne = avecRetrait ? estimerFraisRetrait(parPersonne) : 0;
      const fraisRetraitTotal = fraisRetraitParPersonne * nb;

      recapTotalMultiple.textContent = formatAr(total);
      recapNbDest.textContent = nb;
      recapNbDestFrais.textContent = nb;
      recapParPersonne.textContent = formatAr(parPersonne);
      recapFraisMultiple.textContent = formatAr(fraisTransfert);

      if (avecRetrait && nb > 0) {
        rowFraisRetraitMultiple.style.display = '';
        recapFraisRetraitMultiple.textContent = formatAr(fraisRetraitTotal);
      } else {
        rowFraisRetraitMultiple.style.display = 'none';
      }

      recapTotalDebiteMultiple.textContent = formatAr(total + fraisTransfert + fraisRetraitTotal);
    }

    montantTotalInput?.addEventListener('input', mettreAJourRecapMultiple);
    destinatairesTextarea?.addEventListener('input', mettreAJourRecapMultiple);
    inclureFraisMultiple?.addEventListener('change', mettreAJourRecapMultiple);
  </script>
</body>
</html>
