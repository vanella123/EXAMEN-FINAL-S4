<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>Transfert</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-info text-white">

            <h3>Effectuer un transfert</h3>

        </div>

        <div class="card-body">

            <?php if(session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <?= session()->getFlashdata('error') ?>

                </div>

            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>

                <div class="alert alert-success">

                    <?= session()->getFlashdata('success') ?>

                </div>

            <?php endif; ?>

            <form action="<?= base_url('transfert/save') ?>" method="post">

                <div class="mb-3">

                    <label class="form-label">
                        Numéro du destinataire
                    </label>

                    <input
                        type="text"
                        name="numero"
                        class="form-control"
                        placeholder="Ex : 0331234567"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Montant
                    </label>

                    <input
                        type="number"
                        name="montant"
                        class="form-control"
                        min="100"
                        required>

                </div>

                <button type="submit" class="btn btn-primary">

                    Transférer

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