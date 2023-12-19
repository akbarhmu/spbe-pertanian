<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('page_title') ?>
Laporan Mingguan
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/assets/vendors/simple-datatables/style.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Laporan Mingguan</h3>
        <p class="text-subtitle text-muted">Laporan Mingguan</p>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-3">
                <form action="" method="get">
                    <div class="card">
                        <div class="card-header">
                            Filter Laporan
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select" required>
                                    <option value="">Pilih Bulan</option>
                                    <?php foreach ($months as $month) : ?>
                                        <option value="<?= $month ?>" <?= ($bulan == $month) ? 'selected' : '' ?>><?= $month ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_desa">Desa</label>
                                <select name="id_desa" id="id_desa" class="form-select" required>
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    <?php foreach ($desa as $row) : ?>
                                        <option value="<?= $row['id_desa'] ?>" <?= ($id_desa == $row['id_desa']) ? 'selected' : '' ?>><?= $row['nm_desa'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Jenis Lahan</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="">Pilih Lahan</option>
                                    <option value="Sawah" <?= ($type == 'Sawah') ? 'selected' : '' ?>>Sawah</option>
                                    <option value="Tegal" <?= ($type == 'Tegal') ? 'selected' : '' ?>>Tegal</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-block" id="btn-filter">Lihat</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-header">
                        Daftar Laporan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bulan</th>
                                        <th>Minggu</th>
                                        <th>Komoditas</th>
                                        <th>Luas (Ha)</th>
                                        <th>Justifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($reports as $report) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $report['bulan'] ?></td>
                                            <td><?= $report['minggu'] ?></td>
                                            <td><?= $report['name'] ?></td>
                                            <td><?= $report['luas'] ?></td>
                                            <td><?= $report['justifikasi'] ?: '-' ?></td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="/assets/js/feather-icons/feather.min.js"></script>
<script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    let table = document.querySelector('#table-datatable');
    let dataTable = new simpleDatatables.DataTable(table);
</script>
<?= $this->endSection() ?>