<?php $this->setVar('title', 'Gains') ?>
<?php $this->setVar('currentPage', 'gains') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header">
        <span class="text-eyebrow">Suivi financier</span>
        <h1>Situation des gains</h1>
        <p>Revenus générés par les frais sur les opérations de retrait et de transfert.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-lg-5">
          <div class="balance-card h-100">
            <i class="bi bi-cash-coin balance-card-icon"></i>
            <div class="position-relative">
              <div class="balance-label"><i class="bi bi-graph-up-arrow"></i> Gain total cumulé</div>
              <div class="balance-amount mt-2 mb-3"><?= number_format($total_gains, 0, ' ', ' ') ?> <span class="fs-5 fw-normal">Ar</span></div>
              <span class="badge bg-white text-vola rounded-pill px-3 py-2"><i class="bi bi-calendar3"></i> Depuis le lancement</span>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="row g-4 h-100">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body stat-card">
                  <div class="icon-badge amber"><i class="bi bi-arrow-up-circle"></i></div>
                  <div>
                    <div class="stat-value"><?= number_format($gains_retrait, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                    <div class="stat-label">Gains sur les retraits</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body stat-card">
                  <div class="icon-badge blue"><i class="bi bi-send"></i></div>
                  <div>
                    <div class="stat-value"><?= number_format($gains_transfert, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                    <div class="stat-label">Gains sur les transferts</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <h5 class="mb-3">Détail des gains par type d'opération</h5>
      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Type d'opération</th>
                <th>Nombre d'opérations</th>
                <th>Gain total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($gains as $g): ?>
              <tr>
                <td>
                  <?php $badge = match($g['type_operation']) {
                    'RETRAIT' => 'badge-retrait',
                    'DEPOT' => 'badge-depot',
                    default => 'badge-transfert'
                  }; ?>
                  <span class="badge-op <?= $badge ?>"><?= esc($g['type_operation']) ?></span>
                </td>
                <td><?= number_format((int)$g['nombre_operations'], 0, ' ', ' ') ?></td>
                <td class="fw-semibold text-vola"><?= number_format((float)$g['total_frais'], 0, ' ', ' ') ?> Ar</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="table-light">
                <td class="fw-bold">Total</td>
                <td class="fw-bold"><?= array_sum(array_column($gains, 'nombre_operations')) ?></td>
                <td class="fw-bold text-vola"><?= number_format($total_gains, 0, ' ', ' ') ?> Ar</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- ============================================================ -->
      <!-- A) SITUATION DES GAINS DE MON OPERATEUR (INTERNE) -->
      <!-- ============================================================ -->
      <div class="mt-5">
        <h4 class="mb-1">A) Situation des gains de mon opérateur</h4>
        <p class="text-secondary mb-3">Opérations internes (même opérateur).</p>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Opérateur</th>
                <th>Type opération</th>
                <th>Nombre opérations</th>
                <th>Total frais</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($gains_internes)): ?>
                <tr><td colspan="4" class="text-center">Aucune opération interne.</td></tr>
              <?php else: ?>
                <?php foreach($gains_internes as $gi): ?>
                <tr>
                  <td class="fw-semibold"><?= esc($gi['operateur']) ?></td>
                  <td>
                    <?php $badge = $gi['type_operation'] === 'RETRAIT' ? 'badge-retrait' : 'badge-transfert'; ?>
                    <span class="badge-op <?= $badge ?>"><?= esc($gi['type_operation']) ?></span>
                  </td>
                  <td><?= number_format((int)$gi['nombre_operations'], 0, ' ', ' ') ?></td>
                  <td class="fw-semibold text-vola"><?= number_format((float)$gi['total_frais'], 0, ' ', ' ') ?> Ar</td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ============================================================ -->
      <!-- B) SITUATION DES GAINS AVEC LES AUTRES OPERATEURS -->
      <!-- ============================================================ -->
      <div class="mt-5">
        <h4 class="mb-1">B) Situation des gains avec les autres opérateurs</h4>
        <p class="text-secondary mb-3">Transferts entre opérateurs différents (inter-opérateur).</p>
      </div>

      <div class="table-card mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Opérateur source</th>
                <th>Opérateur destinataire</th>
                <th>Nombre transferts</th>
                <th>Montant total transféré</th>
                <th>Commission %</th>
                <th>Commission gagnée</th>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($gains_externes)): ?>
                <tr><td colspan="6" class="text-center">Aucun transfert externe.</td></tr>
              <?php else: ?>
                <?php foreach($gains_externes as $ge): ?>
                <tr>
                  <td class="fw-semibold"><?= esc($ge['operateur_source']) ?></td>
                  <td class="fw-semibold"><?= esc($ge['operateur_destinataire']) ?></td>
                  <td><?= number_format((int)$ge['nombre_transferts'], 0, ' ', ' ') ?></td>
                  <td><?= number_format((float)$ge['montant_total'], 0, ' ', ' ') ?> Ar</td>
                  <td><?= number_format((float)$ge['pourcentage_commission'], 2) ?> %</td>
                  <td class="fw-semibold text-vola"><?= number_format((float)$ge['total_commission'], 0, ' ', ' ') ?> Ar</td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

<?= $this->include('admin/layouts/admin_footer') ?>
