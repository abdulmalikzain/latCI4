<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Tambah User Baru</h4>
        </div>

        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <form action="simpanuser" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email"
                        value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username"
                        value="<?= old('username') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password"
                        required>
                </div>

                <div class="mb-3">
                    <label>Wilayah</label>
                    <select class="form-select" name="wilayah" required>
                        <option value="">-- Pilih Wilayah --</option>
                        <option value="Banjarnegara">Banjarnegara</option>
                        <option value="Banyumas">Banyumas</option>
                        <option value="Batang">Batang</option>
                        <option value="Blora">Blora</option>
                        <option value="Boyolali">Boyolali</option>
                        <option value="Brebes">Brebes</option>
                        <option value="Cilacap">Cilacap</option>
                        <option value="Demak">Demak</option>
                        <option value="Grobogan">Grobogan</option>
                        <option value="Jepara">Jepara</option>
                        <option value="Karanganyar">Karanganyar</option>
                        <option value="Kebumen">Kebumen</option>
                        <option value="Kendal">Kendal</option>
                        <option value="Klaten">Klaten</option>
                        <option value="Kudus">Kudus</option>
                        <option value="Magelang">Magelang</option>
                        <option value="Pati">Pati</option>
                        <option value="Pekalongan">Pekalongan</option>
                        <option value="Pemalang">Pemalang</option>
                        <option value="Purbalingga">Purbalingga</option>
                        <option value="Purworejo">Purworejo</option>
                        <option value="Rembang">Rembang</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Sragen">Sragen</option>
                        <option value="Sukoharjo">Sukoharjo</option>
                        <option value="Tegal">Tegal</option>
                        <option value="Temanggung">Temanggung</option>
                        <option value="Wonogiri">Wonogiri</option>
                        <option value="Wonosobo">Wonosobo</option>
                        <option value="KotaMagelang">Kota Magelang</option>
                        <option value="KotaPekalongan">Kota Pekalongan</option>
                        <option value="KotaSalatiga">Kota Salatiga</option>
                        <option value="KotaSemarang">Kota Semarang</option>
                        <option value="KotaSurakarta">Kota Surakarta</option>
                        <option value="KotaTegal">Kota Tegal</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Role User</label>
                    <select class="form-select" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-outline-danger">
                    <i class="fa fa-user-plus"></i> Simpan User
                </button>
                <!-- <a href="" class="btn btn-secondary">
                    Kembali
                </a> -->
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>