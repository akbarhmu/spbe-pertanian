<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('page_title') ?>
Komoditas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Komoditas</h3>
                <p class="text-subtitle text-muted">Data Komoditas</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-last text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCommodityModal">
                    <i class="badge-circle font-medium-1 text-white" data-feather="plus"></i>
                    Tambah Komoditas
                </button>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Daftar Komoditas
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Komoditas</th>
                            <th>Tipe Komoditas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        <?php foreach ($commodities as $row) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?php echo $row['name'];  ?></td>
                                <td><?= $row['type'] ?></td>
                                <td>
                                    <?php $i++ ?>
                                    <button type="button" class="btn icon" data-bs-toggle="modal" data-bs-target="#editCommodityModal<?= $row['id'] ?>">
                                        <i class="badge-circle font-medium-1 text-primary" data-feather="edit"></i>
                                    </button>
                                    <form action="<?= route_to('komoditas.destroy', $row['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn icon text-danger">
                                            <i data-feather="trash"></i>
                                        </button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editCommodityModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <form action="<?= route_to('komoditas.update', $row['id']) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Komoditas</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group is-required">
                                                            <label for="name">Nama Komoditas</label>
                                                            <?= form_input_with_validation(type: "text", id: "name", value: $row['name'], required: true, placeholder: "Masukkan nama komoditas") ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Batal</span>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Simpan</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="createCommodityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="<?= route_to('komoditas.store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Komoditas</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group is-required">
                                <label for="image">Foto (.jpg, .jpeg, .png; Max: 1MB)</label>
                                <?= form_input_with_validation(type: "file", id: "image", required: true, placeholder: "Masukkan nama komoditas") ?>
                            </div>
                            <div class="form-group is-required">
                                <label for="name">Nama Komoditas</label>
                                <?= form_input_with_validation(type: "text", id: "name", required: true, placeholder: "Masukkan nama komoditas") ?>
                            </div>
                            <div class="form-group is-required">
                                <label for="typeLahan">Tipe Lahan</label>
                                <select id="typeLahan" name="typeLahan" class="form-select <?= (isset(validation_errors()['typeLahan'])) ? 'is-invalid' : '' ?>" required>
                                    <?php foreach ($typeLahans as $typeLahan) : ?>
                                        <option value=<?= $typeLahan ?> <?= ($typeLahan == old('typeLahan') ? 'selected' : '') ?>><?= $typeLahan ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="/assets/vendors/simple-datatables/style.css">
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<?= $this->endSection() ?>