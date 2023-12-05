<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('page_title') ?>
Tanaman <?= $komoditas ?> Kabupaten Malang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// dd($reports->where('nm_kec', 'AMPELGADING')->get()->getResultArray());
?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dashboard</h3>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h4 class="card-title">Sasaran Areal Tanaman <?= $komoditas ?> (Ha) Kabupaten Malang </h4>
                            <div class="d-flex ">


                                <select class="form-select">
                                    <?php foreach ($years as $year) : ?>
                                        <option><a href="/dashboard/report?tanaman=<?= $komoditas ?>&tahun=<?= $year['years'] ?>"></a><?= $year['years'] ?></option>
                                    <?php endforeach ?>
                                </select>

                                <i data-feather="download"></i>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class='table mb-0' id="table1">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center" rowspan="2">No.</th>
                                            <th style="text-align:center" rowspan="2">Kecamatan</th>
                                            <?php foreach ($months as $month) : ?>
                                                <th colspan="2" style="text-align:center"><?= $month ?></th>
                                            <?php endforeach ?>
                                            <th rowspan="2" style="text-align:center">Total</th>
                                        </tr>

                                        <tr>
                                            <?php foreach ($months as $month) : ?>
                                                <th>Sawah</th>
                                                <th>Tegal</th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php $jumlahTotal = 0 ?>
                                        <?php foreach ($kecamatans as $kecamatan) : ?>

                                            <tr>
                                                <td>
                                                    <?= $i;
                                                    $i++ ?>
                                                </td>
                                                <td>
                                                    <?= $kecamatan["nm_kec"] ?>
                                                </td>
                                                <?php $totalLuas = 0; ?>
                                                <?php $luasSawahSebelumnya = 0; ?>
                                                <?php $luasTegalSebelumnya = 0; ?>

                                                <?php foreach ($months as $month) : ?>
                                                    <?php
                                                    $condSawah = ['nm_kec' => $kecamatan['nm_kec'], 'bulan' => $month, 'nama_komoditas' => $komoditas, 'type' => 'Sawah'];
                                                    $condTegal = ['nm_kec' => $kecamatan['nm_kec'], 'bulan' => $month, 'nama_komoditas' => $komoditas, 'type' => 'Tegal'];
                                                    $sawah = $reports->select('sum(luas) as luas')->where($condSawah)->where('YEAR(created_at)', $tahun)->get()->getRowArray();
                                                    $tegal = $reports->select('sum(luas) as luas')->where($condTegal)->where('YEAR(created_at)', $tahun)->get()->getRowArray();
                                                    $luasSawah = !empty($sawah['luas']) ? $sawah['luas'] : 0;
                                                    $luasTegal = !empty($tegal['luas']) ? $tegal['luas'] : 0;
                                                    $totalLuas += $luasTegal + $luasSawah;

                                                    $perubahanLuasSawah = $luasSawah - $luasSawahSebelumnya;
                                                    $perubahanLuasTegal = $luasTegal - $luasTegalSebelumnya;
                                                    ?>

                                                    <td>
                                                        <a class="btn btn-luas" <?=($luasSawah!=0)? 'data-bs-toggle="modal" data-bs-target="#modalDetailLuasPerBulan"' : ''?> data-nama-kecamatan="<?=$kecamatan['nm_kec']?>" data-kecamatan="<?=$kecamatan['id_kec']?>" data-tahun="<?=$tahun?>" data-bulan="<?=$month?>" data-komoditas="<?=$komoditas?>" data-type="Sawah">
                                                            <?php if ($perubahanLuasSawah > 0): ?>
                                                                <p class="text-success mb-0">
                                                                    +<?= $perubahanLuasSawah ?>
                                                                </p>
                                                            <?php elseif ($perubahanLuasSawah < 0): ?>
                                                                <p class="text-danger mb-0">
                                                                    <?= $perubahanLuasSawah ?>
                                                                </p>
                                                            <?php else: // $perubahanLuasSawah == 0 ?>
                                                                <p class="text-info mb-0">
                                                                    ±<?= $perubahanLuasSawah ?>
                                                                </p>
                                                            <?php endif; ?>
                                                            <h4 class="text-dark text-bold"><?= $luasSawah ?></h4>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-luas" <?=($luasTegal!=0)? 'data-bs-toggle="modal" data-bs-target="#modalDetailLuasPerBulan"' : ''?> data-nama-kecamatan="<?=$kecamatan['nm_kec']?>" data-kecamatan="<?=$kecamatan['id_kec']?>" data-tahun="<?=$tahun?>" data-bulan="<?=$month?>" data-komoditas="<?=$komoditas?>" data-type="Tegal">
                                                        <?php if ($perubahanLuasTegal > 0): ?>
                                                                <p class="text-success mb-0">
                                                                    +<?= $perubahanLuasTegal ?>
                                                                </p>
                                                            <?php elseif ($perubahanLuasTegal < 0): ?>
                                                                <p class="text-danger mb-0">
                                                                    <?= $perubahanLuasTegal ?>
                                                                </p>
                                                            <?php else: // $perubahanLuasTegal == 0 ?>
                                                                <p class="text-info mb-0">
                                                                    ±<?= $perubahanLuasTegal ?>
                                                                </p>
                                                            <?php endif; ?>
                                                            <h4 class="text-dark text-bold"><?= $luasTegal ?></h4>
                                                        </a>
                                                    </td>
                                                <?php 
                                                $luasSawahSebelumnya = $luasSawah;
                                                $luasTegalSebelumnya = $luasTegal;
                                                endforeach;
                                                $jumlahTotal += $totalLuas; 
                                                ?>
                                                <td><?= $totalLuas ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <?php foreach ($months as $month) :
                                                $jumlahLuasSawah = $reports->where('nama_komoditas', $komoditas)->where('bulan', $month)->where('type', 'Sawah')->where('YEAR(created_at)', $tahun)
                                                    ->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                                $jumlahLuasTegal = $reports->where('nama_komoditas', $komoditas)->where('bulan', $month)->where('type', 'Tegal')->where('YEAR(created_at)', $tahun)
                                                    ->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                            ?>
                                                <td><?= $jumlahLuasSawah['luas'] ?></td>
                                                <td><?= $jumlahLuasTegal['luas'] ?></td>
                                            <?php endforeach ?>
                                            <td><?= $jumlahTotal ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3'>Grafik </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="pl-3">
                                    <h1 class='mt-5'><?= $jumlahTotal ?> (Ha)</h1>
                                    <p class='text-xs'><span class="text-green"><i data-feather="bar-chart" width="15"></i> +19%</span> than last month</p>
                                    <div class="legends">
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-info me-2'></div><span class='text-xs'>Last Month</span>
                                        </div>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-blue me-2'></div><span class='text-xs'>Current Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <canvas id="bar"></canvas>
                                <?php
                                foreach ($months as $month) {
                                    $cond = ['bulan' => $month, 'nama_komoditas' => $komoditas];
                                    $luas[] = $reports->where($cond)->where('YEAR(created_at)', $tahun)->select('COALESCE(SUM(luas), 0) as luas')->get()->getRowArray();
                                }
                                ?>
                                <script>
                                    var ctxBar = document.getElementById('bar').getContext('2d');
                                    var chartLabels = <?= json_encode($months); ?>;
                                    var data = <?= json_encode(array_column($luas, 'luas')) ?>;
                                    var chartData = data;

                                    var maxValue = Math.max(...data);
                                    var minValue = Math.min(...data);

                                    var backgroundColors = chartData.map(function(value) {
                                        if (value === maxValue) {
                                            return chartColors.green; // Warna hijau untuk nilai tertinggi
                                        } else if (value === minValue) {
                                            return chartColors.red; // Warna merah untuk nilai terendah
                                        } else {
                                            return chartColors.grey; // Warna abu-abu untuk nilai lainnya
                                        }
                                    });
                                    setTimeout(function() {
                                        var myBar = new Chart(ctxBar, {
                                            type: 'bar',
                                            data: {
                                                labels: chartLabels,
                                                datasets: [{
                                                    label: 'Total Luas',
                                                    backgroundColor: backgroundColors,
                                                    data: chartData,
                                                }],
                                            },
                                            options: {
                                                responsive: true,
                                                barRoundness: 1,
                                                title: {
                                                    display: false,
                                                    text: 'Chart.js - Bar Chart with Rounded Tops (drawRoundedTopRectangle Method)',
                                                },
                                                legend: {
                                                    display: false,
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true,
                                                            suggestedMax: 40 + 20,
                                                            padding: 10,
                                                        },
                                                        gridLines: {
                                                            drawBorder: false,
                                                        },
                                                    }],
                                                    xAxes: [{
                                                        gridLines: {
                                                            display: false,
                                                            drawBorder: false,
                                                        },
                                                    }],
                                                },
                                            },
                                        });
                                    }, 1000);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4">
                            <div class="card ">
                                <div class="card-header">
                                    <h4>Your Earnings</h4>
                                </div>
                                <div class="card-body">
                                    <div id="radialBars"></div>
                                    <div class="text-center mb-5">
                                        <h6>From last month</h6>
                                        <h1 class='text-green'>+$2,134</h1>
                                    </div>
                                </div>
                            </div> -->
                <!-- <div class="card widget-todo">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h4 class="card-title d-flex">
                                    <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Progress
                                </h4>

                            </div>
                            <div class="card-body px-0 py-1">
                                <table class='table table-borderless'>
                                    <tr>
                                        <td class='col-3'>UI Design</td>
                                        <td class='col-6'>
                                            <div class="progress progress-info">
                                                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class='col-3 text-center'>60%</td>
                                    </tr>
                                    <tr>
                                        <td class='col-3'>VueJS</td>
                                        <td class='col-6'>
                                            <div class="progress progress-success">
                                                <div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class='col-3 text-center'>30%</td>
                                    </tr>
                                    <tr>
                                        <td class='col-3'>Laravel</td>
                                        <td class='col-6'>
                                            <div class="progress progress-danger">
                                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class='col-3 text-center'>50%</td>
                                    </tr>
                                    <tr>
                                        <td class='col-3'>ReactJS</td>
                                        <td class='col-6'>
                                            <div class="progress progress-primary">
                                                <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class='col-3 text-center'>80%</td>
                                    </tr>
                                    <tr>
                                        <td class='col-3'>Go</td>
                                        <td class='col-6'>
                                            <div class="progress progress-secondary">
                                                <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class='col-3 text-center'>65%</td>
                                    </tr>
                                </table>
                            </div>
                        </div> -->
            </div>
        </div>
    </section>

    <!-- Modal Detail Luas Per Bulan -->
    <div class="modal fade" id="modalDetailLuasPerBulan" tabindex="-1" role="dialog"
    aria-labelledby="modalDetailLuasPerBulanTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLuasPerBulanTitle">Detail Luas Lahan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class='table table-bordered mb-0' id="table1">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No.</th>
                                    <th style="text-align:center">Desa/Kelurahan</th>
                                    <th style="text-align:center">Luas</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-detail-luas-per-bulan">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align:center" colspan="2">Total</th>
                                    <th id="tfoot-total-luas-per-bulan" style="text-align:center" rowspan="2">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#modalDetailLuasPerBulan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var namaKecamatan = button.data('nama-kecamatan');
            var kecamatan = button.data('kecamatan');
            var tahun = button.data('tahun');
            var bulan = button.data('bulan');
            var komoditas = button.data('komoditas');
            var type = button.data('type');
            var modal = $(this);
            modal.find('.modal-title').text('Luas Lahan ' + type + ' ' + komoditas + ' ' + bulan + ' ' + tahun + ' - ' + namaKecamatan);
            $.ajax({
                url: '<?=route_to('ajax.get-detail-luas-per-bulan')?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    kecamatan: kecamatan,
                    tahun: tahun,
                    bulan: bulan,
                    komoditas: komoditas,
                    type: type,
                },
                success: function(response) {
                    if (response.status) {
                        var tbody = $('#tbody-detail-luas-per-bulan');
                        tbody.empty();
                        var total = 0;
                        $.each(response.data, function(index, value) {
                            tbody.append('<tr><td>' + (index + 1) + '</td><td>' + value.name + '</td><td>' + value.luas + '</td></tr>');
                            total += value.luas;
                        });
                        $('#tfoot-total-luas-per-bulan').text(total);
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
