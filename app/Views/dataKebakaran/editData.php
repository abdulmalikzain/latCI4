<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <form action="<?= base_url('data/updateData'); ?>/<?= $wilayah['id']; ?>" method="post">

        <?= csrf_field(); ?>
        <input type="hidden" name="id" value="<?= $wilayah['id'] ?>">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="tglKejadian">Tanggal Kejadian</label>
                <input type="date" class="form-control <?= ($validation->hasError('tglKejadian')) ? 'is-invalid' : ''; ?>" id="tglKejadian" name="tglKejadian" value="<?= (old('tglKejadian')) ? old('tglKejadian') : $wilayah['tglKejadian']; ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('tglKejadian'); ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="waktuKejadian">Waktu Kejadian</label>
                <input type="time" class="form-control <?= ($validation->hasError('waktuKejadian')) ? 'is-invalid' : ''; ?>" id="waktuKejadian" name="waktuKejadian" value="<?= (old('waktuKejadian')) ? old('waktuKejadian') : $wilayah['waktuKejadian']; ?>" />
            </div>
            <div class="invalid-feedback">
                <?= $validation->getError('waktuKejadian'); ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="kabKota">Kota / Kabupaten</label>
                <input type="text" class="form-control <?= ($validation->hasError('kabKota')) ? 'is-invalid' : ''; ?>" id="kabKota" name="kabKota" value="<?= (old('kabKota')) ? old('kabKota') : $wilayah['kabKota']; ?>" />
            </div>
            <div class="invalid-feedback">
                <?= $validation->getError('kabKota'); ?>
            </div>
            <div class="form-group col-md-4">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" class="form-control <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan" name="kecamatan" value="<?= (old('kecamatan')) ? old('kecamatan') : $wilayah['kecamatan']; ?>" />
            </div>
            <div class="invalid-feedback">
                <?= $validation->getError('kecamatan'); ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="jenisObjek">Jenis Objek Terbakar</label>
                <input type="text" class="form-control" id="jenisObjek" name="jenisObjek" value="<?= $wilayah['jenisObjek']; ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="penyebab">Penyebab Kebakaran</label>
                <input type="text" class="form-control" id="penyebab" name="penyebab" value="<?= $wilayah['penyebab']; ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="jmlBangunan">Jumlah Bangunan Terdampak</label>
                <input type="text" class="form-control" id="jmlBangunan" name="jmlBangunan" value="<?= $wilayah['jmlBangunan']; ?>" />
            </div>
            <div class="form-group col-md-3">
                <label for="korbanMeninggal">Korban Jiwa (meninggal)</label>
                <input type="text" class="form-control" id="korbanMeninggal" name="korbanMeninggal" value="<?= $wilayah['korbanMeninggal']; ?>" />
            </div>
            <div class="form-group col-md-2">
                <label for="korbanLuka">Korban Jiwa (luka)</label>
                <input type="text" class="form-control" id="korbanLuka" name="korbanLuka" value="<?= $wilayah['korbanLuka']; ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="kerugian">Perkiraan Kerugian</label>
                <input type="text" class="form-control" id="kerugian" name="kerugian" value="<?= $wilayah['kerugian']; ?>" />
            </div>
            <div class="form-group col-md-4">
                <label for="waktuRespon">Waktu Respon Damkar</label>
                <input type="time" class="form-control" id="waktuRespon" name="waktuRespon" value="<?= $wilayah['waktuRespon']; ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="jmlArmada">Jumlah Armada / Unit</label>
                <input type="text" class="form-control" id="jmlArmada" name="jmlArmada" value="<?= $wilayah['jmlArmada']; ?>" />
            </div>
            <div class="form-group col-md-4">
                <label for="jmlPersonil">Jumlah Personil Damkar</label>
                <input type="text" class="form-control" id="jmlPersonil" name="jmlPersonil" value="<?= $wilayah['jmlPersonil']; ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="sumberInfo">Sumber Informasi</label>
                <input type="text" class="form-control" id="sumberInfo" name="sumberInfo" value="<?= $wilayah['sumberInfo']; ?>" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
</div>

<?= $this->endSection(); ?>