<?= $this->extend('layouts/auth') ?>

<?= $this->section('page_title') ?>
Formulir Lahan Desa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="assets/images/logo_diskominfo.png" height="48" class='mb-4'>
                            <h3>Laporan Mingguan Realisasi UPSUS LTT Tahun 2023 Kabupaten Malang</h3>
                            <p>Lengkapi data-data dibawah ini</p>
                        </div>
                        <form action="<?= url_to('user.store') ?>" method="post">
                            <?= show_alert_message() ?>
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Nama Petugas</label>
                                        <input type="text" id="name" class="form-control $classAttribute $isInvalid" name="$id" value="<?= $name ?>" placeholder="" disabled>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="month">Laporan Bulan</label>
                                        <select id="month" name="month" class="form-select" required>
                                            <?php foreach ($months as $month) : ?>
                                                <option value=<?= $month ?> <?= ($month == old('month') ? 'selected' : '') ?>><?= $month ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="week">Minggu ke-</label>
                                        <select id="week" name="week" class="form-select" required>
                                            <?php foreach ($weeks as $week) : ?>
                                                <option value=<?= $week ?> <?= ($week == old('week') ? 'selected' : '') ?>><?= $week ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="form-select <?= (isset(validation_errors()['kecamatan'])) ? 'is-invalid' : '' ?>" required disabled>
                                            <?php foreach ($kecamatans as $kecamatan) : ?>
                                                <option value=<?= $kecamatan['id'] ?> <?= ($kecamatan['id'] == old('kecamatan') ? 'selected' : '') ?>><?= $kecamatan['nm_kec'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?= validation_show_error('kecamatan', 'single_error') ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="kelurahan">Kelurahan</label>
                                        <select id="kelurahan" name="kelurahan" class="form-select <?= (isset(validation_errors()['kelurahan'])) ? 'is-invalid' : '' ?>" required>
                                            <?php foreach ($kelurahans as $kelurahan) : ?>
                                                <option value=<?= $kelurahan['id_desa'] ?> <?= ($kelurahan['id_desa'] == old('kelurahan') ? 'selected' : '') ?>><?= $kelurahan['nm_desa'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?= validation_show_error('kelurahan', 'single_error') ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Padi Lahan Sawah</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Padi Lahan Tegal</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Jagung Lahan Sawah</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Jagung Lahan Tegal</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Kedelai Lahan Sawah</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Luas Tanaman Kedelai Lahan Tegal</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Isi luas tanah dalam satuan (Ha)") ?>
                                    </div>
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
<?= $this->endSection() ?>