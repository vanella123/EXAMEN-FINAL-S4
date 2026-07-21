<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? esc($title) . ' — Vola+' : 'Vola+' ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <link rel="stylesheet" href="<?=base_url('css/bootstrap/css/bootstrap.min.css')?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('vola.css') ?>" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-vola" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-wallet2"></i> Vola+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navClient">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navClient">
        <ul class="navbar-nav mx-lg-auto gap-lg-1">
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('client/dashboard') ?>"><i class="bi bi-house-door"></i> Tableau de bord</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'depot' ? 'active' : '' ?>" href="<?= base_url('depot') ?>"><i class="bi bi-arrow-down-circle"></i> Dépôt</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'retrait' ? 'active' : '' ?>" href="<?= base_url('retrait') ?>"><i class="bi bi-arrow-up-circle"></i> Retrait</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'transfert' ? 'active' : '' ?>" href="<?= base_url('transfert') ?>"><i class="bi bi-send"></i> Transfert</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'historique' ? 'active' : '' ?>" href="<?= base_url('historique') ?>"><i class="bi bi-clock-history"></i> Historique</a></li>
          <li class="nav-item"><a class="nav-link <?= ($currentPage ?? '') === 'pourcentage' ? 'active' : '' ?>" href="<?= base_url('pourcentage') ?>"><i class="bi bi-clock-history"></i> epargne</a></li>
        </ul>
        <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
          <span class="phone-chip"><i class="bi bi-telephone-fill"></i> <?= esc($numero) ?></span>
          <a href="<?= base_url('logout') ?>" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
      </div>
    </div>
  </nav>