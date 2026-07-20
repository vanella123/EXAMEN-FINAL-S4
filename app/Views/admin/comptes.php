<?php $this->setVar('title', 'Comptes clients') ?>
<?php $this->setVar('currentPage', 'comptes') ?>
<?= $this->include('admin/layouts/admin_header') ?>

      <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <span class="text-eyebrow">Suivi</span>
          <h1>Comptes clients</h1>
          <p>Situation des comptes ouverts automatiquement sur Vola+.</p>
        </div>
        <form method="get" class="input-group" style="max-width: 320px;">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" name="search" placeholder="Rechercher un numéro..." value="<?= esc($search) ?>">
        </form>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body stat-card">
              <div class="icon-badge blue"><i class="bi bi-people-fill"></i></div>
              <div>
                <div class="stat-value"><?= number_format($total_clients, 0, ' ', ' ') ?></div>
                <div class="stat-label">Comptes actifs</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body stat-card">
              <div class="icon-badge"><i class="bi bi-cash-stack"></i></div>
              <div>
                <div class="stat-value"><?= number_format($solde_total, 0, ' ', ' ') ?> <span class="fs-6">Ar</span></div>
                <div class="stat-label">Solde total cumulé</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body stat-card">
              <div class="icon-badge teal"><i class="bi bi-person-plus"></i></div>
              <div>
                <div class="stat-value"><?= $nouveaux_7j ?></div>
                <div class="stat-label">Nouveaux comptes (7 jours)</div>
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
                <th>Téléphone</th>
                <th>Solde</th>
                <th>Date de création</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($clients as $c): ?>
              <tr>
                <td class="fw-semibold"><?= esc($c['numero_telephone']) ?></td>
                <td><?= number_format((float)$c['solde'], 0, ' ', ' ') ?> Ar</td>
                <td><?= esc($c['date_creation']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

<?= $this->include('admin/layouts/admin_footer') ?>