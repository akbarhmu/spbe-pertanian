<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('page_title') ?>
Pengguna
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="/assets/vendors/simple-datatables/style.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Pengguna</h3>
        <p class="text-subtitle text-muted">Kelola Pengguna</p>
    </div>
    <section class="section">
        <div class="table-responsive">
            <table class="table" id="table-datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kecamatan</th>
                        <th>Hak Akses</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['kecamatan']['nm_kec'] ?></td>
                            <td>
                                <?php
                                    switch ($user['role']) {
                                        case 'admin':
                                            echo '<span class="badge bg-dark">Admin</span>';
                                            break;
                                        case 'koordinator':
                                            echo '<span class="badge bg-primary">Koordinator</span>';
                                            break;
                                        case 'penyuluh':
                                            echo '<span class="badge bg-info">Penyuluh</span>';
                                            break;
                                        default:
                                            echo '-';
                                            break;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if ($user['verified_at'] == null) {
                                        echo '<span class="badge bg-danger">Belum Diverifikasi</span>';
                                    } else {
                                        echo '<span class="badge bg-success">Sudah Diverifikasi</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php if ($user['verified_at'] == null) : ?>
                                    <button type="button" class="btn btn-primary btn-sm round icon icon-left" data-bs-toggle="modal" data-bs-target="#verificationModal<?=$user['id']?>">
                                        <i data-feather="edit"></i> Verifikasi
                                    </button>
                                    <!-- Modal Verifikasi Pengguna -->
                                    <div class="modal fade" id="verificationModal<?=$user['id']?>" tabindex="-1" role="dialog" aria-labelledby="verificationModalTitle<?=$user['id']?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="verificationModalTitle<?=$user['id']?>">Verifikasi Pengguna</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <td><?=$user['name']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td><?=$user['email']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>No. Telepon</th>
                                                                    <td><?=$user['phone_number']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kecamatan</th>
                                                                    <td><?=$user['kecamatan']['nm_kec']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal Registrasi</th>
                                                                    <td><?=$user['created_at']?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Hak Akses</th>
                                                                    <td>
                                                                        <?php
                                                                            switch ($user['role']) {
                                                                                case 'admin':
                                                                                    echo '<span class="badge bg-dark">Admin</span>';
                                                                                    break;
                                                                                case 'koordinator':
                                                                                    echo '<span class="badge bg-primary">Koordinator</span>';
                                                                                    break;
                                                                                case 'penyuluh':
                                                                                    echo '<span class="badge bg-info">Penyuluh</span>';
                                                                                    break;
                                                                                default:
                                                                                    echo '-';
                                                                                    break;
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                        <i class="d-block d-sm-none" data-feather="x"></i>
                                                        <span class="d-none d-sm-block">Batal</span>
                                                    </button>
                                                    <form action="<?=route_to('users.destroy', $user['id'])?>" method="post">
                                                        <?=csrf_field()?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                                            <i class="d-block d-sm-none" data-feather="trash"></i>
                                                            <span class="d-none d-sm-block">Hapus Pengguna</span>
                                                        </button>
                                                    </form>
                                                    <form action="<?=route_to('users.verify', $user['id'])?>" method="post">
                                                        <?=csrf_field()?>
                                                        <button type="submit" class="btn btn-primary ml-1">
                                                            <i class="d-block d-sm-none" data-feather="user-check"></i>
                                                            <span class="d-none d-sm-block">Verifikasi</span>
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
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
