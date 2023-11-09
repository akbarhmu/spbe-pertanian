<?= $this->extend('layouts/auth') ?>

<?= $this->section('page_title') ?>
Daftar
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
                            <h3>Daftar Akun</h3>
                            <p>Lengkapi data-data dibawah ini</p>
                        </div>
                        <form action="<?= url_to('user.store') ?>" method="post">
                            <?= show_alert_message() ?>
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="name">Nama Lengkap</label>
                                        <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Nama Lengkap") ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="email">Email</label>
                                        <?= form_input_with_validation(type: "email", id: "email", required: true, placeholder: "contoh@email.com") ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="phoneNumber">No. Telp Aktif</label>
                                        <?= form_input_with_validation(type: "tel", id: "phoneNumber", required: true, placeholder: "Minimal 8-14 Angka") ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="form-select <?= (isset(validation_errors()['kecamatan'])) ? 'is-invalid' : '' ?>" required>
                                            <?php foreach ($kecamatans as $kecamatan) : ?>
                                                <option value=<?= $kecamatan['id_kec'] ?> <?= ($kecamatan['id_kec'] == old('kecamatan') ? 'selected' : '') ?>><?= $kecamatan['nm_kec'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?= validation_show_error('kecamatan', 'single_error') ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="password">Password</label>
                                        <?= form_input_with_validation(type: "password", id: "password", required: true, placeholder: "Minimal 8 karakter & berisi alfanumerik") ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group is-required">
                                        <label for="retypePassword">Password Confirmation</label>
                                        <?= form_input_with_validation(type: "password", id: "retypePassword", required: true, placeholder: "Minimal 8 karakter & berisi alfanumerik") ?>
                                    </div>
                                </div>
                            </diV>

                            <a href="<?= url_to('login') ?>">Sudah punya akun? Masuk</a>
                            <div class="clearfix">
                                <button class="btn btn-primary float-end">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>