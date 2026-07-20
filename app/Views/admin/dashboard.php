<?php $this->setVar('title', 'Tableau de bord opérateur') ?>
<?php $this->setVar('currentPage', 'dashboard') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header">
        <span class="text-eyebrow">Vue d'ensemble</span>
        <h1>Tableau de bord opérateur</h1>
        <p>Statistiques globales de la plateforme Vola+.</p>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge blue"><i class="bi bi-people-fill"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_clients, 0, ' ', ' ') ?></div>
                <div class="stat-label">Comptes clients</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge teal"><i class="bi bi-arrow-left-right"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_operations, 0, ' ', ' ') ?></div>
                <div class="stat-label">Opérations réalisées</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge gold"><i class="bi bi-cash-coin"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_gains, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Total des gains</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card h-100">
            <div class="card-body stat-card">
              <div class="icon-badge amber"><i class="bi bi-send-fill"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_transferts, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Montants transférés</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-lg-7">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="mb-3"><i class="bi bi-clock-history text-vola"></i> Dernières opérations sur la plateforme</h6>
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Client</th>
                      <th>Type</th>
                      <th>Montant</th>
                      <th>Frais</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($dernieres_operations)): ?>
                      <tr><td colspan="4" class="text-center">Aucune opération.</td></tr>
                    <?php else: ?>
                      <?php foreach($dernieres_operations as $op): ?>
                      <tr>
                        <td><?= esc($op['numero_telephone']) ?></td>
                        <td>
                          <?php $badge = match($op['type_operation']) {
                            'Depot' => 'badge-depot',
                            'Retrait' => 'badge-retrait',
                            default => 'badge-transfert'
                          }; ?>
                          <span class="badge-op <?= $badge ?>"><?= esc($op['type_operation']) ?></span>
                        </td>
                        <td><?= number_format((float)$op['montant'], 0, ' ', ' ') ?> Ar</td>
                        <td><?= number_format((float)$op['frais'], 0, ' ', ' ') ?> Ar</td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="mb-3"><i class="bi bi-pie-chart text-vola"></i> Répartition des gains</h6>
              <?php $totalGains = $gains_retrait + $gains_transfert; ?>
              <?php $pctRetrait = $totalGains > 0 ? round($gains_retrait / $totalGains * 100) : 0; ?>
              <?php $pctTransfert = $totalGains > 0 ? round($gains_transfert / $totalGains * 100) : 0; ?>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span><span class="badge-op badge-retrait me-2"><i class="bi bi-arrow-up-circle"></i></span>Retraits</span>
                <strong><?= number_format($gains_retrait, 0, ' ', ' ') ?> Ar</strong>
              </div>
              <div class="progress mb-4" style="height:8px;">
                <div class="progress-bar" style="width:<?= $pctRetrait ?>%; background-color: var(--vola-green-700);"></div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span><span class="badge-op badge-transfert me-2"><i class="bi bi-send"></i></span>Transferts</span>
                <strong><?= number_format($gains_transfert, 0, ' ', ' ') ?> Ar</strong>
              </div>
              <div class="progress" style="height:8px;">
                <div class="progress-bar" style="width:<?= $pctTransfert ?>%; background-color: var(--vola-gold);"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?= $this->include('admin/layouts/admin_footer') ?>