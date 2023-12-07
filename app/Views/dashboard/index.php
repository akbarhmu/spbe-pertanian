<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Sasaran Areal Tanam Bulan <?= $bulan ?></h3>

    </div>
    <section class="section">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($komoditas as $row) : ?>
                <div class="col">
                    <a href="/dashboard/report?tanaman=<?= $row['name'] ?>">
                        <div class="card shadow-sm">
                            <div class="card-content">
                                <img class="card-img-top img-fluid lazy" src="<?= $row['image'] ?>" alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title"><?= $row['name'] ?></h4>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <span class="badge bg-primary"><?= $row['totalBulanIni'] ?> Ha</span>
                                        </div>
                                        <div align="right">sebelumnya <?= $row['totalBulanLalu'] ?> Ha | <p class="text-<?= $row['class'] ?>"><?= $row['icon'] ?> <?= $row['perubahanTotalLuas'] ?> Ha | <?= $row['persentasePerubahan'] ?>%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>