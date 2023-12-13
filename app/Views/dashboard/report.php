<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('page_title') ?>
Tanaman <?= $komoditas ?> Kabupaten Malang
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    td {
        text-align: center
    }

    th {
        text-align: center;
        vertical-align: middle;
    }
</style>
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


                                <select class="form-select" id="tahunSelect">
                                    <?php
                                    if (!isset($_GET['tahun'])) {
                                        $_GET['tahun'] = date('Y');
                                    }
                                    foreach ($years as $year) :
                                    ?>
                                        <?php $selected = ($year['years'] == $_GET['tahun']) ? 'selected' : ''; ?>
                                        <option value="<?= $year['years'] ?>" <?= $selected ?>><?= $year['years'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <script>
                                    document.getElementById('tahunSelect').addEventListener('change', function() {
                                        var selectedYear = this.value;
                                        var komoditas = "<?= $komoditas ?>";
                                        window.location.href = "/dashboard/report?tanaman=" + komoditas + "&tahun=" + selectedYear;
                                    });
                                </script>

                                <button class="btn btn-primary ms-3 btn-icon" onclick="ExportToExcel('xlsx')"><i data-feather="download"></i> Excel</button>
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
                                        <?php foreach ($reports as $report) : ?>

                                            <tr>
                                                <td>
                                                    <?= $i;
                                                    $i++ ?>
                                                </td>
                                                <td>
                                                    <?= $report['namaKec'] ?>
                                                </td>
                                                <?php $luasSawahSebelumnya = 0; ?>
                                                <?php $luasTegalSebelumnya = 0; ?>

                                                <?php foreach ($report['luasBulanan'] as $luas) : ?>
                                                    <?php

                                                    $perubahanLuasSawah = $luas['sawah'] - $luasSawahSebelumnya;
                                                    $perubahanLuasTegal = $luas['tegal'] - $luasTegalSebelumnya;
                                                    ?>

                                                    <td class="p-2" data-v="<?= $luas['sawah'] ?>">
                                                        <a class="btn-luas" <?= ($luas['sawah'] != 0) ? 'data-bs-toggle="modal" data-bs-target="#modalDetailLuasPerBulan"' : '' ?> data-nama-kecamatan="<?= $report['namaKec'] ?>" data-kecamatan="<?= $report['idKec'] ?>" data-tahun="<?= $tahun ?>" data-bulan="<?= $luas['bulan'] ?>" data-komoditas="<?= $komoditas ?>" data-type="Sawah">
                                                            <?php if ($perubahanLuasSawah > 0) : ?>
                                                                <p class="text-success mb-0" style="font-size: 0.8rem">
                                                                    ▲ +<?= $perubahanLuasSawah ?>
                                                                </p>
                                                            <?php elseif ($perubahanLuasSawah < 0) : ?>
                                                                <p class="text-danger mb-0" style="font-size: 0.8rem">
                                                                    ▼ <?= $perubahanLuasSawah ?>
                                                                </p>
                                                            <?php else : // $perubahanLuasSawah == 0 
                                                            ?>
                                                                <p class="text-secondary mb-0" style="font-size: 0.8rem">
                                                                    =
                                                                </p>
                                                            <?php endif; ?>
                                                            <h4 class="text-dark text-bold text-underlined"><?= $luas['sawah'] ?></h4>
                                                        </a>
                                                    </td>
                                                    <td class="p-2" data-v="<?= $luas['tegal'] ?>">
                                                        <a class="btn-luas" <?= ($luas['tegal'] != 0) ? 'data-bs-toggle="modal" data-bs-target="#modalDetailLuasPerBulan"' : '' ?> data-nama-kecamatan="<?= $report['namaKec'] ?>" data-kecamatan="<?= $report['idKec'] ?>" data-tahun="<?= $tahun ?>" data-bulan="<?= $luas['bulan'] ?>" data-komoditas="<?= $komoditas ?>" data-type="Tegal">
                                                            <?php if ($perubahanLuasTegal > 0) : ?>
                                                                <p class="text-success mb-0" style="font-size: 0.8rem">
                                                                    ▲ +<?= $perubahanLuasTegal ?>
                                                                </p>
                                                            <?php elseif ($perubahanLuasTegal < 0) : ?>
                                                                <p class="text-danger mb-0" style="font-size: 0.8rem">
                                                                    ▼ <?= $perubahanLuasTegal ?>
                                                                </p>
                                                            <?php else : // $perubahanLuasTegal == 0 
                                                            ?>
                                                                <p class="text-secondary mb-0" style="font-size: 0.8rem">
                                                                    =
                                                                </p>
                                                            <?php endif; ?>
                                                            <h4 class="text-dark text-bold text-underlined"><?= $luas['tegal'] ?></h4>
                                                        </a>
                                                    </td>
                                                <?php
                                                    $luasSawahSebelumnya = $luas['sawah'];
                                                    $luasTegalSebelumnya = $luas['tegal'];
                                                endforeach;
                                                ?>
                                                <td><?= $report['totalLuas'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <?php foreach ($jumlah['bulanan'] as $bulanan) : ?>
                                                <td><?= $bulanan['sawah'] ?></td>
                                                <td><?= $bulanan['tegal'] ?></td>
                                            <?php endforeach ?>
                                            <td><?= $jumlah['total'] ?></td>
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
                                    <h1 class='mt-5'><?= $jumlah['total'] ?> (Ha)</h1>
                                    <!-- <p class='text-xs'><span class="text-green"><i data-feather="bar-chart" width="15"></i> +19%</span> than last month</p> -->
                                    <div class="legends">
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-green me-2'></div><span class='text-xs'>Luas Tertinggi</span>
                                        </div>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-red me-2'></div><span class='text-xs'>Luas Terendah</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <canvas id="bar"></canvas>
                                <?php
                                $luas = [];
                                foreach ($jumlah['bulanan'] as $bulanan) {
                                    $luas[] = $bulanan['sawah'] + $bulanan['tegal'];
                                }
                                ?>
                                <script>
                                    var ctxBar = document.getElementById('bar').getContext('2d');
                                    var chartLabels = <?= json_encode($months); ?>;
                                    var data = <?= json_encode($luas) ?>;
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
            </div>
        </div>
    </section>

    <!-- Modal Detail Luas Per Bulan -->
    <div class="modal fade" id="modalDetailLuasPerBulan" tabindex="-1" role="dialog" aria-labelledby="modalDetailLuasPerBulanTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
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
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>
<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table1');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        var ws = wb.Sheets["sheet1"];
        var wscols = [ {wch:10}, {wch:20}, {wch:10}, {wch:10},{wch:10}, {wch:10}];
        ws['!cols'] = wscols;
        
        for (i in ws) {
            if (typeof(ws[i]) != "object") continue;
            let cell = XLSX.utils.decode_cell(i);

            ws[i].s = { // styling for all cells
                font: {
                    name: "arial"
                },
                alignment: {
                    vertical: "center",
                    horizontal: "center",
                    wrapText: '0', // any truthy value here
                },
                border: {
                    right: {
                        style: "thin",
                        color: "000000"
                    },
                    left: {
                        style: "thin",
                        color: "000000"
                    },
                    top: {
                        style: "thin",
                        color: "000000"
                    },
                    bottom: {
                        style: "thin",
                        color: "000000"
                    }
                }
            };

            if (cell.r == 0 || cell.r == 1) { // first row
                ws[i].s.font.bold = true;
            }
        }

        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('Sasaran Areal Tanaman <?= $komoditas ?> (Ha) Kabupaten Malang <?= $tahun ?>.' + (type || 'xlsx')));
    }

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
                url: '<?= route_to('ajax.get-detail-luas-per-bulan') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    kecamatan: namaKecamatan,
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