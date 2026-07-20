<h2>Faire un retrait</h2>


<?php if(session()->getFlashdata('error')): ?>

<p>
<?= session()->getFlashdata('error') ?>
</p>

<?php endif; ?>


<?php if(session()->getFlashdata('success')): ?>

<p>
<?= session()->getFlashdata('success') ?>
</p>

<?php endif; ?>


<form action="<?= base_url('retrait/save') ?>" method="post">

<label>
Montant :
</label>


<input 
type="number"
name="montant"
min="100"
required
>


<button type="submit">
Retirer
</button>


</form>