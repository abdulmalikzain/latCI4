<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="text-gray-800">Isi Data Kebakaran</h5>
    <form action="<?= base_url('insertData'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="tglKejadian">Tanggal Kejadian <sup>*tidak boleh kosong</sup></label>
                <input type="date" class="form-control <?= ($validation->hasError('tglKejadian')) ? 'is-invalid' : ''; ?>" id="tglKejadian" name="tglKejadian" autofocus value="<?= old('tglKejadian'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('tglKejadian'); ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="waktuKejadian">Waktu Kejadian <sup>*tidak boleh kosong</sup></label>
                <input type="time" class="form-control <?= ($validation->hasError('waktuKejadian')) ? 'is-invalid' : ''; ?>" id="waktuKejadian" name="waktuKejadian" value="<?= old('waktuKejadian'); ?>" />
            </div>
            <div class="invalid-feedback">
                <?= $validation->getError('waktuKejadian'); ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="kabKota">Kota / Kabupaten <sup>*tidak boleh kosong</sup></label>

                <select class="form-control <?= ($validation->hasError('kabKota')) ? 'is-invalid' : ''; ?>"
                    id="kabKota"
                    name="kabKota">

                    <option value="">-- Pilih Kota / Kabupaten --</option>

                    <?php foreach ($wilayahList as $w): ?>
                        <option value="<?= $w ?>" <?= old('kabKota') == $w ? 'selected' : '' ?>>
                            <?= $w ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <?php if ($validation->hasError('kabKota')) : ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('kabKota'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="invalid-feedback">
                <?= $validation->getError('kabKota'); ?>
            </div>
            <div class="form-group col-md-4">
                <label for="kecamatan">Kecamatan <sup>*tidak boleh kosong</sup></label>
                <input type="text" class="form-control <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>" id="kecamatan" name="kecamatan" value="<?= old('kecamatan'); ?>" />
            </div>
            <div class="invalid-feedback">
                <?= $validation->getError('kecamatan'); ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="jenisObjek">Jenis Objek Terbakar</label>
                <input type="text" class="form-control" id="jenisObjek" name="jenisObjek" value="<?= old('jenisObjek'); ?>" placeholder="Rumah, mobil, dll." />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="penyebab">Penyebab Kebakaran</label>
                <input type="text" class="form-control" id="penyebab" name="penyebab" value="<?= old('penyebab'); ?>" placeholder="Konsleting Listrik" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="jmlBangunan">Jumlah Bangunan Terdampak</label>
                <input type="text" class="form-control" id="jmlBangunan" name="jmlBangunan" value="<?= old('jmlBangunan'); ?>" />
            </div>
            <div class="form-group col-md-3">
                <label for="korbanMeninggal">Korban Jiwa (meninggal)</label>
                <input type="text" class="form-control" id="korbanMeninggal" name="korbanMeninggal" value="<?= old('korbanMeninggal'); ?>" />
            </div>
            <div class="form-group col-md-2">
                <label for="korbanLuka">Korban Jiwa (luka)</label>
                <input type="text" class="form-control" id="korbanLuka" name="korbanLuka" value="<?= old('korbanLuka'); ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="kerugian">Perkiraan Kerugian</label>
                <input type="text" class="form-control" id="kerugian" name="kerugian" value="<?= old('kerugian'); ?>" placeholder="Rp. 000.000" />
            </div>
            <div class="form-group col-md-4">
                <label for="waktuRespon">Waktu Respon Damkar</label>
                <input type="time" class="form-control" id="waktuRespon" name="waktuRespon" value="<?= old('waktuRespon'); ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="jmlArmada">Jumlah Armada / Unit</label>
                <input type="text" class="form-control" id="jmlArmada" name="jmlArmada" value="<?= old('jmlArmada'); ?>" />
            </div>
            <div class="form-group col-md-4">
                <label for="jmlPersonil">Jumlah Personil Damkar</label>
                <input type="text" class="form-control" id="jmlPersonil" name="jmlPersonil" value="<?= old('jmlPersonil'); ?>" />
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="sumberInfo">Sumber Informasi</label>
                <input type="text" class="form-control" id="sumberInfo" name="sumberInfo" value="<?= old('sumberInfo'); ?>" />
            </div>
        </div>



        <button type="submit" class="btn btn-primary">Input Data</button>
    </form>

</div>

<?= $this->endSection(); ?>