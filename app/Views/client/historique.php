<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Historique</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h3>Historique des opérations</h3>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

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

                            Aucun historique.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($historique as $ligne): ?>

                        <tr>

                            <td><?= esc($ligne['date_operation']) ?></td>

                            <td><?= esc($ligne['type_operation']) ?></td>

                            <td><?= number_format($ligne['montant_mouvement'],0,' ',' ') ?> Ar</td>

                            <td><?= number_format($ligne['solde_apres'],0,' ',' ') ?> Ar</td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

            <a href="<?= base_url('client/dashboard') ?>" class="btn btn-primary">

                Retour au tableau de bord

            </a>

        </div>

    </div>

</div>

</body>

</html>