<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Dépôt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h3>Effectuer un dépôt</h3>

        </div>

        <div class="card-body">

            <?php if(session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <?= session()->getFlashdata('error') ?>

                </div>

            <?php endif; ?>

            <form method="post" action="<?= base_url('depot/save') ?>">

                <?= csrf_field() ?>

                <div class="mb-3">

                    <label class="form-label">

                        Montant

                    </label>

                    <input
                        type="number"
                        min="1"
                        name="montant"
                        class="form-control"
                        required>

                </div>

                <button class="btn btn-success">

                    Déposer

                </button>

                <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary">

                    Retour

                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>