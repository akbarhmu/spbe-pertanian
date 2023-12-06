<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dashboard</h3>
        <!-- <p class="text-subtitle text-muted">A good dashboard to display your statistics</p> -->
        <h3>Sasaran Areal Tanam Bulan <?= $bulan ?></h3>
        <p class="text-subtitle text-muted">Data Terakhir Tanggal <?= $latest_updated_at ?></p>
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
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <div class="card" style="width: 43rem;">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title"> Komoditas Kabupaten Malang </h4>
                                <div class="d-flex ">

                                </div>
                            </div>
                            <div class="card-body px-0 pb-0">
                                <div class="table-responsive">
                                    <table class='table mb-0' id="table1">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Komoditas</th>
                                                <th>Jumlah Luas Terakhir (Ha)</th>
                                                <th>Perubahan (Ha)</th>
                                                <!-- <th>Perubahan (%)</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($komoditas as $komod) : ?>

                                                <tr>
                                                    <td>
                                                        <?= $i;
                                                        $i++ ?>
                                                    </td>
                                                    <?php
                                                    $month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                                                    $luas = $reports->where('nama_komoditas', $komod['name'])->where('YEAR(created_at)', date('Y'))->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                    if (date('m') == 1) {
                                                        $luasBulan[0] = $reports->where('nama_komoditas', $komod['name'])->where('bulan', $month[date('m') - 1])->where('YEAR(created_at)', date('Y'))->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                        $luasBulan[1] = $reports->where('nama_komoditas', $komod['name'])->where('bulan', $month[11])->where('YEAR(created_at)', date('Y') - 1)->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                    } else {
                                                        $luasBulan[0] = $reports->where('nama_komoditas', $komod['name'])->where('bulan', $month[date('m') - 1])->where('YEAR(created_at)', date('Y'))->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                        $luasBulan[1] = $reports->where('nama_komoditas', $komod['name'])->where('bulan', $month[date('m') - 2])->where('YEAR(created_at)', date('Y'))->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                    }

                                                    // dd($luasBulan)
                                                    ?>
                                                    <td>
                                                        <a href="/dashboard/report?tanaman=<?= $komod["name"] ?>"><?= $komod["name"] ?></a>
                                                    </td>
                                                    <td><?= $luas['luas'] ?></td>
                                                    <td><?= $luasBulan[0]['luas'] - $luasBulan[1]["luas"] ?></td>
                                                </tr>
                                            <?php endforeach ?>

                                        </tbody>
                                    </table>
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