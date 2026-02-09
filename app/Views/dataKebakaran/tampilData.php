<html lang="en">
<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


<div class="container-fluid" style="margin-top: 15px;">

    <body>
        <h5>Data Laporan Kebakaran</h5>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <form id="filterForm" method="get" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Kabupaten / Kota</label>
                <select name="kabKota" class="form-select" <?= !$isAdmin ? 'disabled' : '' ?>>
                    <?php if ($isAdmin): ?>
                        <option value="">Semua</option>
                    <?php endif; ?>

                    <?php foreach ($kabkota_list as $item): ?>
                        <option value="<?= esc($item['kabKota']) ?>"
                            <?= ($filter['kabKota'] == $item['kabKota']) ? 'selected' : '' ?>>
                            <?= esc($item['kabKota']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="startDate" class="form-control" value="<?= esc($filter['startDate']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="endDate" class="form-control" value="<?= esc($filter['endDate']) ?>">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-siranah w-100" type="submit">Filter</button>
            </div>
        </form>

        <div id="loading-overlay" style="display:none;">
            <div class="custom-spinner text-primary" role="status"></div>
        </div>
        <!-- Container utama untuk data + pagination -->
        <div id="data-container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal kejadian</th>
                            <th scope="col">Waktu Kejadian</th>
                            <th scope="col">Kota/Kabupaten</th>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Jenis Objek Terbakar</th>
                            <th scope="col">Penyebab Kebakaran</th>
                            <th scope="col">Action</th>

                            <!-- <th scope="col">Jumlah Bangunan Terdampak</th>
                            <th scope="col">Korban Meninggal</th>
                            <th scope="col">Korban Luka</th>
                            <th scope="col">Kerugian</th>
                            <th scope="col">Waktu Respon Damkar</th>
                            <th scope="col">Jumlah Personil Damkar</th>
                            <th scope="col">Jumlah Armada</th>
                            <th scope="col">Sumber Informasi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($datakebakaran)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; ?>
                            <?php foreach ($datakebakaran as $wilayah) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $wilayah['tglKejadian']; ?></td>
                                    <td><?= $wilayah['waktuKejadian']; ?></td>
                                    <td><?= $wilayah['kabKota']; ?></td>
                                    <td><?= $wilayah['kecamatan']; ?></td>
                                    <td><?= $wilayah['jenisObjek']; ?></td>
                                    <td><?= $wilayah['penyebab']; ?></td>

                                    <td><a class="btn btn-info btn-sm" href="<?= $wilayah['id']; ?>"><i class="fa fa-pen"></i></a>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?= $pager ?>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const overlay = document.getElementById('loading-overlay');
                const dataContainer = document.getElementById('data-container');
                const filterForm = document.getElementById('filterForm');

                // Fungsi untuk menampilkan dan menyembunyikan overlay
                function showLoading() {
                    overlay.style.display = 'flex';
                }

                function hideLoading() {
                    overlay.style.display = 'none';
                }

                // Fungsi untuk memuat data (AJAX)
                async function loadData(url) {
                    try {
                        showLoading();
                        const response = await fetch(url);
                        const html = await response.text();

                        // Ambil isi #data-container dari response
                        const temp = document.createElement('div');
                        temp.innerHTML = html;

                        const newContent = temp.querySelector('#data-container');
                        if (newContent) {
                            dataContainer.innerHTML = newContent.innerHTML;
                            attachPaginationEvents(); // re-attach event pagination
                        }
                    } catch (error) {
                        console.error('Error loading data:', error);
                    } finally {
                        hideLoading();
                    }
                }

                // Saat klik tombol Filter
                filterForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const params = new URLSearchParams(new FormData(filterForm)).toString();
                    const url = `?${params}`;
                    loadData(url);
                    window.history.pushState({}, '', url);
                });

                // Event pagination link (AJAX)
                function attachPaginationEvents() {
                    document.querySelectorAll('.pagination a').forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();
                            const url = link.getAttribute('href');
                            loadData(url);
                            window.history.pushState({}, '', url);
                        });
                    });
                }

                // Panggil saat pertama kali
                attachPaginationEvents();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "<?= session()->getFlashdata('pesan'); ?>",
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= base_url('data/tampilData'); ?>";
                    }
                });
            </script>
        <?php endif; ?>
    </body>
</div>

<?= $this->endSection(); ?>

</html>