<?php $this->setVar('title', 'Montants à envoyer') ?>
<?php $this->setVar('currentPage', 'montants') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header">
        <span class="text-eyebrow">Suivi financier</span>
        <h1>Montants à envoyer aux opérateurs</h1>
        <p>Montants que chaque opérateur doit recevoir suite aux transferts externes.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge blue"><i class="bi bi-send"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_transferts, 0, ' ', ' ') ?></div>
                <div class="stat-label">Total transferts externes</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge gold"><i class="bi bi-cash-coin"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_montant, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Montant total à envoyer</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge amber"><i class="bi bi-percent"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_commission, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Total commissions</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Opérateur destinataire</th>
                <th>Nombre transferts</th>
                <th>Montant total à envoyer</th>
                <th>Total commissions</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($montants)): ?>
                <tr><td colspan="4" class="text-center">Aucun transfert externe.</td></tr>
              <?php else: ?>
                <?php foreach($montants as $m): ?>
                <tr>
                  <td class="fw-semibold"><?= esc($m['operateur_destinataire']) ?></td>
                  <td><?= number_format((int)$m['nombre_transferts'], 0, ' ', ' ') ?></td>
                  <td class="fw-semibold"><?= number_format((float)$m['montant_total'], 0, ' ', ' ') ?> Ar</td>
                  <td class="fw-semibold text-vola"><?= number_format((float)$m['total_commission'], 0, ' ', ' ') ?> Ar</td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr class="table-light">
                <td class="fw-bold">Total</td>
                <td class="fw-bold"><?= number_format($total_transferts, 0, ' ', ' ') ?></td>
                <td class="fw-bold"><?= number_format($total_montant, 0, ' ', ' ') ?> Ar</td>
                <td class="fw-bold text-vola"><?= number_format($total_commission, 0, ' ', ' ') ?> Ar</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

<?= $this->include('admin/layouts/admin_footer') ?>
