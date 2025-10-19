<html lang="en">
<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <body>
        <h5>Data kejadian</h5>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <table class="table-responsive table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal kejadian</th>
                    <th scope="col">Waktu Kejadian</th>
                    <th scope="col">Kota/Kabupaten</th>
                    <th scope="col">Kecamatan</th>
                    <th scope="col">Jenis Objek Terbakar</th>
                    <th scope="col">Penyebab Kebakaran</th>
                    <th scope="col">Jumlah Bangunan Terdampak</th>
                    <th scope="col">Korban Meninggal</th>
                    <th scope="col">Korban Luka</th>
                    <th scope="col">Kerugian</th>
                    <th scope="col">Waktu Respon Damkar</th>
                    <th scope="col">Jumlah Personil Damkar</th>
                    <th scope="col">Jumlah Armada</th>
                    <th scope="col">Sumber Informasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataWilayah as $wilayah) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $wilayah['tglKejadian']; ?></td>
                        <td><?= $wilayah['waktuKejadian']; ?></td>
                        <td><?= $wilayah['kabKota']; ?></td>
                        <td><?= $wilayah['kecamatan']; ?></td>
                        <td><?= $wilayah['jenisObjek']; ?></td>
                        <td><?= $wilayah['penyebab']; ?></td>
                        <td><?= $wilayah['jmlBangunan']; ?></td>
                        <td><?= $wilayah['korbanMeninggal']; ?></td>
                        <td><?= $wilayah['korbanLuka']; ?></td>
                        <td><?= $wilayah['kerugian']; ?></td>
                        <td><?= $wilayah['waktuRespon']; ?></td>
                        <td><?= $wilayah['jmlPersonil']; ?></td>
                        <td><?= $wilayah['jmlArmada']; ?></td>
                        <td><?= $wilayah['sumberInfo']; ?></td>
                        <td><a class="btn btn-info btn-sm" href="<?= $wilayah['id']; ?>">detail</a>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </body>
</div>
<?= $this->endSection(); ?>

</html>