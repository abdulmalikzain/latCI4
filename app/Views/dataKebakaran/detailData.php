<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h4>Informasi Laporan Kebakaran</h4>
    <div class="card border-dark mb-3">
        <div class="card-header" style="color: black;">Informasi Wilayah Terkena Kebakaran</div>

        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tanggal Kejadian</li>
                        <li class="list-group-item">Waktu Kejadian</li>
                        <li class="list-group-item">Kota / Kabupaten</li>
                        <li class="list-group-item">kecamatan</li>
                        <li class="list-group-item">Jenis Objek Terbakar</li>
                        <li class="list-group-item">Jumlah Bangunan Terdampak</li>
                        <li class="list-group-item">Korban Meninggal</li>
                        <li class="list-group-item">Korban Luka</li>
                        <li class="list-group-item">Kerugian</li>
                        <li class="list-group-item">Waktu Respon Damkar</li>
                        <li class="list-group-item">Jumlah Personil Damkar</li>
                        <li class="list-group-item">Jumlah Armada</li>
                        <li class="list-group-item">Sumber Informasi</li>
                    </ul>
                </div>
                <div class="col-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= $wilayah['tglKejadian'] ?></li>
                        <li class="list-group-item"><?= $wilayah['waktuKejadian'] ?></li>
                        <li class="list-group-item"><?= $wilayah['kabKota'] ?></li>
                        <li class="list-group-item"><?= $wilayah['kecamatan'] ?></li>
                        <li class="list-group-item"><?= $wilayah['jenisObjek'] ?></li>
                        <li class="list-group-item"><?= $wilayah['jmlBangunan'] ?></li>
                        <li class="list-group-item"><?= $wilayah['korbanMeninggal'] ?></li>
                        <li class="list-group-item"><?= $wilayah['korbanMeninggal'] ?></li>
                        <li class="list-group-item"><?= $wilayah['waktuRespon'] ?></li>
                        <li class="list-group-item"><?= $wilayah['korbanLuka'] ?></li>
                        <li class="list-group-item"><?= $wilayah['jmlPersonil'] ?></li>
                        <li class="list-group-item"><?= $wilayah['jmlArmada'] ?></li>
                        <li class="list-group-item"><?= $wilayah['sumberInfo'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <a href="editData/<?= $wilayah['id'] ?>" class="btn btn-primary">Edit Data</a>
    <form action="<?= $wilayah['id'] ?>" method="post" class="d-inline">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin');">Hapus</button>
    </form>

</div>

<?= $this->endSection(); ?>