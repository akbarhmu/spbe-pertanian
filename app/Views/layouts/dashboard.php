<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('page_title') ?> | Dashboard</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">

    <?= $this->renderSection('styles') ?>

    <link rel="stylesheet" href="/assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="shortcut icon" href="/assets/images/logo.svg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="/assets/js/pages/dashboard.js"></script>
</head>


<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="/assets/images/logo.png" alt="">
                </div>

                <div class=" sidebar-menu">
                    <ul class="menu">


                        <li class='sidebar-title'>Main Menu</li>



                        <li class="sidebar-item <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
                            <a href="<?= route_to('dashboard') ?>" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <li class="sidebar-item <?= uri_string() == 'dashboard/komoditas' ? 'active' : '' ?>">
                                <a href="<?= route_to('komoditas.index') ?>" class='sidebar-link'>
                                    <i data-feather="feather" width="20"></i>
                                    <span>Komoditas</span>
                                </a>
                            </li>
                            <li class="sidebar-item <?= uri_string() == 'dashboard/users' ? 'active' : '' ?>">
                                <a href="<?= route_to('users.index') ?>" class='sidebar-link'>
                                    <i data-feather="user" width="20"></i>
                                    <span>Pengguna</span>
                                </a>
                            </li>
                        <?php endif ?>
                        <?php if (session()->get('role') == 'penyuluh') : ?>
                            <li class="sidebar-item <?= uri_string() == 'formulir' ? 'active' : '' ?>">
                                <a href="<?= route_to('formulir') ?>" class='sidebar-link'>
                                    <i data-feather="clipboard" width="20"></i>
                                    <span>Formulir</span>
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="sidebar-item <?= uri_string() == 'dashboard/laporan' ? 'active' : '' ?>">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalFilterLaporan" class='sidebar-link'>
                                <i data-feather="file-text" width="20"></i>
                                <span>Laporan Mingguan</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success me-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?= form_open(url_to('user.logout'), ['id' => 'logout-form']) ?>
                        <?= form_close() ?>
                        <li class="dropdown nav-icon me-2">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="mail"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit()"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    <img src="/assets/images/avatar/avatar-s-1.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, <?= session()->get('name') ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit()"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <?= $this->renderSection('content') ?>

            <!-- Laporan Mingguan Filter Modal -->
            <form action="<?=route_to('reports')?>" method="get">
            <div class="modal fade" id="modalFilterLaporan" tabindex="-1" role="dialog" aria-labelledby="modalFilterLaporanTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFilterLaporanTitle">Laporan Mingguan</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select" required>
                                    <option value="">Pilih Bulan</option>
                                    <?php foreach ($months as $month) : ?>
                                        <option value="<?= $month ?>"><?= $month ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_desa">Desa</label>
                                <select name="id_desa" id="id_desa" class="form-select" required>
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    <?php foreach ($desa as $row) : ?>
                                        <option value="<?= $row['id_desa'] ?>"><?= $row['nm_desa'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Jenis Lahan</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="">Pilih Lahan</option>
                                    <option value="Sawah">Sawah</option>
                                    <option value="Tegal">Tegal</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Cari</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Dinas Komunikasi dan Informatika Kabupaten Malang</p>
                    </div>
                    <div class="float-end">
                        Halaman dimuat dalam <strong>{elapsed_time}</strong> detik
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/assets/js/feather-icons/feather.min.js"></script>
    <script src="/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/app.js"></script>

    <script src="/assets/vendors/chartjs/Chart.min.js"></script>
    <script src="/assets/vendors/apexcharts/apexcharts.min.js"></script>


    <script src="/assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <script>
        <?php if (session()->has("success")) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session("success") ?>'
            })
        <?php } ?>
        <?php if (session()->has("error")) { ?>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '<?= session("error") ?>'
            })
        <?php } ?>
        <?php if (session()->has("warning")) { ?>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '<?= session("warning") ?>'
            })
        <?php } ?>
        <?php if (session()->has("info")) { ?>
            Swal.fire({
                icon: 'info',
                title: 'Informasi!',
                text: '<?= session("info") ?>'
            })
        <?php } ?>
    </script>

    <?= $this->renderSection('script') ?>
</body>

</html>