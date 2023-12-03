<?= $this->extend('layouts/auth') ?>

<?= $this->section('page_title') ?>
Masuk
<?= $this->endSection() ?>

<?= $this->section('content') ?><div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="assets/images/logo.png" height="48" class='mb-4'>
                            <h3>Masuk</h3>
                            <p>Silahkan masuk untuk melanjutkan.</p>
                        </div>
                        <?= form_open(url_to('user.login')) ?>
                        <?= show_alert_message() ?>
                        <div class="form-group position-relative has-icon-left is-required">
                            <label for="email">Email</label>
                            <div class="position-relative">
                                <?= form_input_with_validation(type: "email", id: "email", required: true, placeholder: "Masukkan email anda...") ?>
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left is-required">
                            <label for="password">Password</label>
                            <div class="position-relative">
                                <?= form_input_with_validation(type: "password", id: "password", required: true, placeholder: "Masukkan password anda...") ?>
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class='form-check clearfix my-4'>
                            <div class="checkbox float-start">
                                <?= form_checkbox('remember_me', 'true', extra: ["class" => "form-check-input"]) ?>
                                <label for="remember_me">Remember me</label>
                            </div>
                            <div class="float-end">
                                <a href="<?= url_to('register') ?>">Anda belum memiliki akun? Daftar</a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-primary float-end" type="submit">Masuk</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>