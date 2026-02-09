<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <form action="<?= base_url('data/updateData'); ?>/<?= $wilayah['id']; ?>" method="post" id="editForm" class="mt-4 mb-3">

        <?= csrf_field(); ?>
        <input type="hidden" name="id" value="<?= $wilayah['id'] ?>">
        <div class="form-row">
            <!-- Tanggal Kejadian -->
            <div class="form-group col-md-4">
                <label for="tglKejadian">Tanggal Kejadian </label>
                <input type="date"
                    class="form-control required-field <?= ($validation->hasError('tglKejadian')) ? 'is-invalid' : ''; ?>"
                    id="tglKejadian"
                    name="tglKejadian"
                    value="<?= old('tglKejadian') ?: $wilayah['tglKejadian']; ?>"
                    disabled>

            </div>

            <!-- Waktu Kejadian -->
            <div class="form-group col-md-4">
                <label for="waktuKejadian">Waktu Kejadian </label>
                <input type="time"
                    class="form-control required-field <?= ($validation->hasError('waktuKejadian')) ? 'is-invalid' : ''; ?>"
                    id="waktuKejadian"
                    name="waktuKejadian"
                    value="<?= old('waktuKejadian') ?: $wilayah['waktuKejadian']; ?>"
                    disabled>

            </div>
        </div>

        <div class="form-row">
            <!-- Kab / Kota -->
            <div class="form-group col-md-4">
                <label for="kabKota">Kota / Kabupaten </label>
                <input type="text"
                    class="form-control required-field <?= ($validation->hasError('kabKota')) ? 'is-invalid' : ''; ?> "
                    id="kabKota"
                    name="kabKota"
                    value="<?= old('kabKota') ?: $wilayah['kabKota']; ?>" disabled>

            </div>

            <!-- Kecamatan -->
            <div class="form-group col-md-4">
                <label for="kecamatan">Kecamatan </label>
                <input type="text"
                    class="form-control required-field <?= ($validation->hasError('kecamatan')) ? 'is-invalid' : ''; ?>"
                    id="kecamatan"
                    name="kecamatan"
                    value="<?= old('kecamatan') ?: $wilayah['kecamatan']; ?>" disabled>

            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="jenisObjek">Jenis Objek Terbakar</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('jenisObjek')) ? 'is-invalid' : ''; ?>"
                    id="jenisObjek"
                    name="jenisObjek"
                    value="<?= old('jenisObjek', $wilayah['jenisObjek']); ?>" />

                <div class="invalid-feedback">
                    <?= $validation->getError('jenisObjek') ?: 'Jenis objek wajib diisi'; ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="penyebab">Penyebab Kebakaran</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('penyebab')) ? 'is-invalid' : ''; ?>"
                    id="penyebab" name="penyebab" value="<?= old('penyebab', $wilayah['penyebab']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('penyebab') ?: 'Penyebab kebakaran wajib diisi'; ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="jmlBangunan">Jumlah Bangunan Terdampak</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('jmlBangunan')) ? 'is-invalid' : ''; ?>"
                    id="jmlBangunan" name="jmlBangunan" value="<?= old('jmlBangunan', $wilayah['jmlBangunan']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('jmlBangunan') ?: 'Jumlah bangunan wajib diisi'; ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="korbanMeninggal">Korban Jiwa (meninggal)</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('korbanMeninggal')) ? 'is-invalid' : ''; ?>" id="korbanMeninggal" name="korbanMeninggal" value="<?= old('korbanMeninggal', $wilayah['korbanMeninggal']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('korbanMeninggal') ?: 'Korban meninggal wajib diisi'; ?>
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="korbanLuka">Korban Jiwa (luka)</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('korbanLuka')) ? 'is-invalid' : ''; ?>" id="korbanLuka" name="korbanLuka" value="<?= old('korbanLuka', $wilayah['korbanLuka']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('korbanLuka') ?: 'Korban luka wajib diisi'; ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="kerugian">Perkiraan Kerugian</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('kerugian')) ? 'is-invalid' : ''; ?>" id="kerugian" name="kerugian" value="<?= old('kerugian', $wilayah['kerugian']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('kerugian') ?: 'Kerugian wajib diisi'; ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="waktuRespon">Waktu Respon Damkar</label>
                <input type="time" class="form-control required-field <?= ($validation->hasError('waktuRespon')) ? 'is-invalid' : ''; ?>"
                    id="waktuRespon" name="waktuRespon" value="<?= old('waktuRespon', $wilayah['waktuRespon']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('waktuRespon') ?: 'Waktu respon wajib diisi'; ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="jmlArmada">Jumlah Armada / Unit</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('jmlArmada')) ? 'is-invalid' : ''; ?>" id="jmlArmada" name="jmlArmada" value="<?= old('jmlArmada', $wilayah['jmlArmada']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('jmlArmada') ?: 'Jumlah armada wajib diisi'; ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="jmlPersonil">Jumlah Personil Damkar</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('jmlPersonil')) ? 'is-invalid' : ''; ?>" id="jmlPersonil" name="jmlPersonil" value="<?= old('jmlPersonil', $wilayah['jmlPersonil']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('jmlPersonil') ?: 'Jumlah personil wajib diisi'; ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="sumberInfo">Sumber Informasi</label>
                <input type="text" class="form-control required-field <?= ($validation->hasError('sumberInfo')) ? 'is-invalid' : ''; ?>" id="sumberInfo" name="sumberInfo" value="<?= old('sumberInfo', $wilayah['sumberInfo']); ?>" />
                <div class="invalid-feedback">
                    <?= $validation->getError('sumberInfo') ?: 'Sumber informasi wajib diisi'; ?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('editForm');
        const requiredFields = document.querySelectorAll('.required-field');

        function markInvalid(field) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
        }

        function markValid(field) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }

        function checkField(field) {
            if (!field.value || field.value.trim() === '') {
                markInvalid(field);
                return false;
            } else {
                markValid(field);
                return true;
            }
        }

        // realtime
        requiredFields.forEach(field => {
            field.addEventListener('input', () => checkField(field));
            field.addEventListener('change', () => checkField(field));
        });

        // 🔥 KLIK SIMPAN
        form.addEventListener('submit', function(e) {
            let valid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                if (!checkField(field)) {
                    valid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            });

            if (!valid) {
                e.preventDefault();

                // scroll ke error pertama
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'top'
                });

                // 🔥 SWEET ALERT
                Swal.fire({
                    icon: 'warning',
                    title: 'Data belum lengkap',
                    text: 'Mohon lengkapi semua kolom yang wajib diisi.',
                    confirmButtonText: 'Oke, siap 👍'
                });
            }
        });


    });

    ///cek kerugian format rupiah
    document.addEventListener('DOMContentLoaded', function() {
        const kerugianInput = document.getElementById('kerugian');

        kerugianInput.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) {
                this.value = 'Rp. ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            } else {
                this.value = '';
            }
        });
    });
</script>

<?= $this->endSection(); ?>