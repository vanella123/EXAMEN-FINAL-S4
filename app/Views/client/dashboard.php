<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>Tableau de bord</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>Mobile Money</h3>

        </div>

        <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('success') ?>

            </div>

        <?php endif; ?>
            <h5>Bienvenue</h5>

            <p>
                <strong>Numéro :</strong>
                <?= esc($numero) ?>
            </p>

            <p>
                <strong>Solde :</strong>

                <span class="badge bg-success fs-6">
                    <?= number_format($solde,0,' ',' ') ?> Ar
                </span>

            </p>

            <hr>

            <div class="d-flex gap-3">

                <a href="<?= base_url('depot') ?>" class="btn btn-success">
                    Dépôt
                </a>

                <a href="<?= base_url('retrait') ?>" class="btn btn-warning">
                    Retrait
                </a>

                <a href="<?= base_url('transfert') ?>" class="btn btn-info">
                    Transfert
                </a>

                <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                    Déconnexion
                </a>

            </div>

            <hr>

            <h4>Historique</h4>

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th>Date</th>
                    <th>Opération</th>
                    <th>Montant</th>
                    <th>Solde après</th>

                </tr>

                </thead>

                <tbody>

                <?php if(empty($historique)): ?>

                    <tr>
                        <td colspan="4" class="text-center">
                            Aucune opération.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach($historique as $ligne): ?>

                        <tr>

                            <td><?= $ligne['date_operation'] ?></td>

                            <td><?= $ligne['type_operation'] ?></td>

                            <td><?= number_format($ligne['montant_mouvement'],0,' ',' ') ?> Ar</td>

                            <td><?= number_format($ligne['solde_apres'],0,' ',' ') ?> Ar</td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>