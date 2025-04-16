<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard.css'); ?>">
</head>

<body>
    <!-- As a link -->
    <?php if ($this->session->userdata('role') == 'user') { ?>
        <nav class="navbar shadow bg-body-tertiary">
            <div class="navbar container">
                <a class="navbar-brand fw-bold text-white" href="#">Halo <?= $this->session->userdata('username'); ?></a>
                <div class="d-flex ms-auto">
                    <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger btn-sm">Logout</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <!-- Ringkasan -->
            <div class="row mb-4 mt-5">
                <div class="col-12 mb-4">
                    <h1 class="text-muted fw-bold">Saldo Total :</h1>
                    <h3 class="text-primary">Rp <?php echo number_format($saldo, 0, ',', '.'); ?></h3>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Total Pemasukan :</h6>
                    <h3 class="text-success">Rp <?php echo number_format($total_pemasukan, 0, ',', '.'); ?></h3>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Total Pengeluaran :</h6>
                    <h3 class="text-danger">Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?></h3>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Tabel Pemasukan -->
                <div class="col-md-6">
                    <div class="card p-3 shadow mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-success">Daftar Pemasukan</h5>
                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTransaksi" data-jenis="Pemasukan">+ Tambah Pemasukan</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $adaPemasukan = false;
                                    foreach ($transaksi as $item):
                                        if ($item->jenis == 'Pemasukan'):
                                            $adaPemasukan = true;
                                    ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= date('d M Y', strtotime($item->tanggal)); ?></td>
                                                <td><?= htmlspecialchars($item->keterangan); ?></td>
                                                <td><?= number_format($item->jumlah, 0, ',', '.'); ?></td>
                                                <td>
                                                    <!-- Di Tabel Pemasukan -->
                                                    <a href="#"
                                                        class="btn btn-warning btn-sm btn-edit-pemasukan"
                                                        data-id="<?= $item->id; ?>"
                                                        data-keterangan="<?= htmlspecialchars($item->keterangan); ?>"
                                                        data-jumlah="<?= $item->jumlah; ?>"
                                                        data-tanggal="<?= $item->tanggal; ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditPemasukan">✏️</a>
                                                    <a href="<?= site_url('keuangan/hapus/' . $item->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">🗑️</a>
                                                </td>
                                            </tr>
                                        <?php
                                        endif;
                                    endforeach;
                                    if (!$adaPemasukan): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada pemasukan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pengeluaran -->
                <div class="col-md-6 justify-content-center">
                    <div class="card p-3 shadow mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-danger">Daftar Pengeluaran</h5>
                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTransaksi" data-jenis="Pengeluaran">+ Tambah Pengeluaran</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-danger">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $adaPengeluaran = false;
                                    foreach ($transaksi as $item):
                                        if ($item->jenis == 'Pengeluaran'):
                                            $adaPengeluaran = true;
                                    ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= date('d M Y', strtotime($item->tanggal)); ?></td>
                                                <td><?= htmlspecialchars($item->keterangan); ?></td>
                                                <td><?= number_format($item->jumlah, 0, ',', '.'); ?></td>
                                                <td>
                                                    <!-- Di Tabel Pengeluaran -->
                                                    <a href="#"
                                                        class="btn btn-warning btn-sm btn-edit-pengeluaran"
                                                        data-id="<?= $item->id; ?>"
                                                        data-keterangan="<?= htmlspecialchars($item->keterangan); ?>"
                                                        data-jumlah="<?= $item->jumlah; ?>"
                                                        data-tanggal="<?= $item->tanggal; ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditPengeluaran">✏️</a>

                                                    <a href="<?= site_url('keuangan/hapus/' . $item->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">🗑️</a>
                                                </td>
                                            </tr>
                                        <?php
                                        endif;
                                    endforeach;
                                    if (!$adaPengeluaran): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada pengeluaran.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Transaksi -->
            <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-labelledby="modalTransaksiLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= site_url('keuangan/simpan_transaksi'); ?>" method="post" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTransaksiLabel">Tambah Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="jenis" id="inputJenis">

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Pemasukan -->
            <div class="modal fade" id="modalEditPemasukan" tabindex="-1" aria-labelledby="modalEditPemasukanLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= site_url('keuangan/update'); ?>" method="post" class="modal-content">
                        <input type="hidden" name="id" id="editIdPemasukan">
                        <input type="hidden" name="jenis" value="Pemasukan">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditPemasukanLabel">Edit Pemasukan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editKeteranganPemasukan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="editKeteranganPemasukan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editJumlahPemasukan" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="editJumlahPemasukan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTanggalPemasukan" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="editTanggalPemasukan" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Pengeluaran -->
            <div class="modal fade" id="modalEditPengeluaran" tabindex="-1" aria-labelledby="modalEditPengeluaranLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= site_url('keuangan/update'); ?>" method="post" class="modal-content">
                        <input type="hidden" name="id" id="editIdPengeluaran">
                        <input type="hidden" name="jenis" value="Pengeluaran">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditPengeluaranLabel">Edit Pengeluaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editKeteranganPengeluaran" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="editKeteranganPengeluaran" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editJumlahPengeluaran" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="editJumlahPengeluaran" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTanggalPengeluaran" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="editTanggalPengeluaran" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php   } ?>
        <!-- Tampilan Admin -->
        <?php if ($this->session->userdata('role') == 'admin') { ?>

            <nav class="navbar shadow bg-body-tertiary">
                <div class="navbar container">
                    <a class="navbar-brand fw-bold text-white" href="#">Halo <?= $this->session->userdata('username'); ?></a>
                    <div class="d-flex ms-auto">
                        <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger btn-sm">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="container">
                <!-- Ringkasan -->
                <div class="row mb-4 mt-5">
                    <div class="col-12 mb-4">
                        <h1 class="text-muted fw-bold">Saldo Total :</h1>
                        <h3 class="text-primary">Rp <?php echo number_format($saldo, 0, ',', '.'); ?></h3>
                    </div>
                </div>

                <div class="col-12 position-relative">
                    <!-- Tombol tambah di pojok kanan atas -->

                    <div class="card p-3 shadow mb-4">
                        <h5 class="fw-bold mb-3">Daftar User</h5>

                        <div class="position-absolute top-0 end-0 mt-2 me-3">
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahuser">+ Tambah User</a>
                        </div>

                        <ul class="list-group list-group-flush">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?= htmlspecialchars($user->username); ?></strong><br>
                                                <small>Role: <?= htmlspecialchars($user->role); ?></small><br>

                                                <?php if ($user->role != 'admin'): ?>
                                                    <small class="text-muted">Saldo: Rp <?= number_format($user->saldo, 0, ',', '.'); ?></small>
                                                <?php endif; ?>

                                            </div>
                                            <div>
                                                <a href="<?= site_url('admin/delete_user/' . $user->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus user ini?')">Hapus</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-center text-muted">Belum ada user terdaftar.</li>
                            <?php endif; ?>
                        </ul>

                    </div>
                </div>

            </div>
        </div>





    <?php   } ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modalTransaksi');
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var jenis = button.getAttribute('data-jenis');
                var inputJenis = modal.querySelector('#inputJenis');
                inputJenis.value = jenis;


                modal.querySelector('#modalTransaksiLabel').textContent = 'Tambah ' + jenis;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Handle modal tambah transaksi (sudah ada)
            var modal = document.getElementById('modalTransaksi');
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var jenis = button.getAttribute('data-jenis');
                var inputJenis = modal.querySelector('#inputJenis');
                inputJenis.value = jenis;
                modal.querySelector('#modalTransaksiLabel').textContent = 'Tambah ' + jenis;
            });

            // Handle edit pemasukan
            document.querySelectorAll('.btn-edit-pemasukan').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editIdPemasukan').value = this.dataset.id;
                    document.getElementById('editKeteranganPemasukan').value = this.dataset.keterangan;
                    document.getElementById('editJumlahPemasukan').value = this.dataset.jumlah;
                    document.getElementById('editTanggalPemasukan').value = this.dataset.tanggal;
                });
            });

            // Handle edit pengeluaran
            document.querySelectorAll('.btn-edit-pengeluaran').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editIdPengeluaran').value = this.dataset.id;
                    document.getElementById('editKeteranganPengeluaran').value = this.dataset.keterangan;
                    document.getElementById('editJumlahPengeluaran').value = this.dataset.jumlah;
                    document.getElementById('editTanggalPengeluaran').value = this.dataset.tanggal;
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>