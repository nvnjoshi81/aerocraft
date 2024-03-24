<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-body">
    <h1 class="fw-bold">Welcome, Aerocraft <?= $session->get('login_name') ?>!</h1>
    </div>
</div>
<?= $this->endSection() ?>