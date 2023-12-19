<?= $this->extend('layouts/auth') ?>

<?= $this->section('page_title') ?>
Formulir Lahan Desa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="assets/images/logo.png" height="48" class='mb-4'>
                            <h3>Laporan Mingguan Realisasi UPSUS LTT Tahun 2023 Kabupaten Malang</h3>
                            <p>Lengkapi data-data dibawah ini</p>
                        </div>
                        <form action="<?= url_to('lahan.store') ?>" method="post">
                            <?= show_alert_message() ?>
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Data Petugas</h6>
                                    </div>
                                    <div class="form-group is-required">
                                        <label for="name">Nama Petugas</label>
                                        <input type="text" id="name" class="form-control $classAttribute $isInvalid" name="$id" value="<?= $name ?>" placeholder="" disabled>
                                    </div>
                                    <div class="form-group is-required">
                                        <label for="month">Laporan Bulan</label>
                                        <select id="month" name="month" class="form-select" required>
                                            <?php foreach ($months as $month) : ?>
                                                <option value=<?= $month ?> <?= ($month == old('month') ? 'selected' : '') ?>><?= $month ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group is-required">
                                        <label for="week">Minggu ke-</label>
                                        <select id="week" name="week" class="form-select" required>
                                            <?php foreach ($weeks as $week) : ?>
                                                <option value=<?= $week ?> <?= ($week == old('week') ? 'selected' : '') ?>><?= $week ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group is-required">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="form-select <?= (isset(validation_errors()['kecamatan'])) ? 'is-invalid' : '' ?>" required disabled>
                                            <?php foreach ($kecamatans as $kecamatan) : ?>
                                                <option value=<?= $kecamatan['id'] ?> <?= ($kecamatan['id'] == old('kecamatan') ? 'selected' : '') ?>><?= $kecamatan['nm_kec'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?= validation_show_error('kecamatan', 'single_error') ?>
                                    </div>
                                    <div class="form-group is-required">
                                        <label for="kelurahan">Desa/Kelurahan</label>
                                        <select id="kelurahan" name="kelurahan" class="form-select <?= (isset(validation_errors()['kelurahan'])) ? 'is-invalid' : '' ?>" required>
                                            <?php foreach ($kelurahans as $kelurahan) : ?>
                                                <option value=<?= $kelurahan['id_desa'] ?> <?= ($kelurahan['id_desa'] == old('kelurahan') ? 'selected' : '') ?>><?= $kelurahan['nm_desa'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?= validation_show_error('kelurahan', 'single_error') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="justifikasi">Justifikasi</label>
                                        <textarea name="justifikasi" id="justifikasi" class="form-control <?= (isset(validation_errors()['justifikasi'])) ? 'is-invalid' : '' ?>" rows="3" placeholder="Masukan keterangan justifikasi jika diperlukan"><?=old('justifikasi')?></textarea>
                                        <?= validation_show_error('justifikasi', 'single_error') ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Komoditas Utama</h6>
                                    </div>
                                    <?php foreach ($mandatoryCommodities as $mandatoryCommodity) { ?>
                                        <div class="form-group is-required">
                                            <label for="lahan[<?= $mandatoryCommodity['id'] ?>]">Luas Tanaman <?= $mandatoryCommodity['name'] ?> Lahan <?= $mandatoryCommodity['type'] ?> (Ha)</label>
                                            <?= form_input_with_validation(type: "text", id: "lahan[" . $mandatoryCommodity['id'] . "]", required: false, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Komoditas Unggulan</h6>
                                        <d class="d-flex">
                                            <button type="button" class="btn btn-icon btn-sm text-primary p-0" data-bs-toggle="modal" data-bs-target="#addCommodityFieldModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </d>
                                    </div>

                                    <div id="inputArea"></div>
                                </div>

                                <div class="clearfix">
                                    <button class="btn btn-primary float-end">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Commodity Field Modal -->

<div class="modal fade" id="addCommodityFieldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Input Komoditas</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="commodity">Komoditas</label>
                    <select class="form-select" id="commodity">
                        <option value="">Pilih Jenis Tanaman</option>
                        <?php foreach ($commodities as $row) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?> Lahan <?= $row['type'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" onclick="addCommodityField()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Tambah</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function addCommodityField() {
        var commodityId = document.getElementById('commodity').value;
        var commodityName = document.getElementById('commodity').options[document.getElementById('commodity').selectedIndex].text;
        var inputArea = document.getElementById('inputArea');

        if (commodityId == '') {
            alert('Pilih komoditas terlebih dahulu');
            return;
        }

        var newDiv = document.createElement('div');
        newDiv.setAttribute('class', 'row');
        newDiv.innerHTML = `
            <div class="col-12">
                <div class="form-group is-required">
                    <label for="">Luas Tanaman ` + commodityName + ` (Ha)</label>
                    <div class="input-group is-required">
                        <input type="number" name="lahan[` + commodityId + `]" class="form-control" placeholder="Isi luas tanah dalam satuan (Ha)" required>
                        <button class="btn btn-danger" type="button" onclick="this.parentElement.parentElement.remove();restoreCommodityOption(` + commodityId + `, '` + commodityName + `');">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
        inputArea.appendChild(newDiv);

        document.getElementById('commodity').options[document.getElementById('commodity').selectedIndex].remove();

        $('#addCommodityFieldModal').modal('hide');
    }

    function restoreCommodityOption($id, $name) {
        var select = document.getElementById('commodity');
        var option = document.createElement('option');
        option.value = $id;
        option.text = $name;
        select.appendChild(option);
    }
</script>
<?= $this->endSection() ?>