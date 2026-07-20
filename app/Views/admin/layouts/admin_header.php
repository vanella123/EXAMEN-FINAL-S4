<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? esc($title) . ' — Vola+' : 'Vola+' ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/bootstrap/css/bootstrap.min.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('vola.css') ?>" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-vola" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-wallet2"></i> Vola+ <span class="fw-normal fs-6 ms-1 opacity-75">Opérateur</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navAdmin">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'prefixes' ? 'active' : '' ?>" href="<?= base_url('admin/prefixes') ?>"><i class="bi bi-sim"></i> Préfixes</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'types-operations' ? 'active' : '' ?>" href="<?= base_url('admin/types-operations') ?>"><i class="bi bi-tags"></i> Types d'opérations</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'baremes' ? 'active' : '' ?>" href="<?= base_url('admin/baremes') ?>"><i class="bi bi-percent"></i> Barèmes</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'comptes' ? 'active' : '' ?>" href="<?= base_url('admin/comptes') ?>"><i class="bi bi-people"></i> Comptes</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'gains' ? 'active' : '' ?>" href="<?= base_url('admin/gains') ?>"><i class="bi bi-graph-up-arrow"></i> Gains</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'commissions' ? 'active' : '' ?>" href="<?= base_url('admin/commissions') ?>"><i class="bi bi-percent"></i> Commissions</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'montants' ? 'active' : '' ?>" href="<?= base_url('admin/montants') ?>"><i class="bi bi-send"></i> Montants</a></li>
        </ul>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-logout mt-3 mt-lg-0"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>
  <main>
    <div class="container">
      <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success mt-3"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>
      <?php if($errors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger mt-3">
          <?php foreach($errors as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>
