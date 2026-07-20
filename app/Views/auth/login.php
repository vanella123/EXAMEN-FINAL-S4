<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Client</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f4f6f9;
        }

        .login-card{
            max-width:420px;
            margin:auto;
            margin-top:100px;
            border:none;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,.15);
        }

        .login-header{
            background:#0d6efd;
            color:white;
            padding:20px;
            border-radius:15px 15px 0 0;
            text-align:center;
        }

        .btn-login{
            width:100%;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="card login-card">

        <div class="login-header">
            <h3>Mobile Money</h3>
            <p class="mb-0">Connexion Client</p>
        </div>

        <div class="card-body p-4">

            <?php if(session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <?= session()->getFlashdata('error') ?>

                </div>

            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">

                    <label class="form-label">
                        Numéro de téléphone
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="numero"
                        placeholder="0331234567"
                        maxlength="10"
                        required>

                </div>

                <button class="btn btn-primary btn-login">

                    Se connecter

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>