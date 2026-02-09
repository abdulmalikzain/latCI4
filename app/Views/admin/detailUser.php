<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">



<div class="row gutters-sm mt-4 ml-1 mr-1">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">

                <!-- Avatar -->
                <div class="position-relative d-inline-block mb-3">

                    <img id="userImage-<?= $user['id']; ?>"
                        src="<?= base_url('uploads/user/' . $user['image_user']); ?>"
                        alt="User Avatar"
                        class="rounded-circle border user-avatar"
                        width="130"
                        height="130"
                        style="object-fit: cover; background-color: #f1f1f1;">

                    <!-- Camera button -->
                    <button type="button"
                        class="btn btn-warning btn-sm rounded-circle position-absolute bottom-0 end-0 editPhotoBtn"
                        data-id="<?= $user['id'] ?>"
                        data-image="<?= $user['image_user'] ?>"
                        style="width:36px; height:36px;">
                        <i class="fa fa-camera"></i>
                    </button>
                </div>

                <!-- Username -->
                <div>
                    <p class="text-muted mb-1 small">Username</p>
                    <h5 class="mb-0 fw-semibold"><?= esc($user['username']); ?></h5>
                </div>

            </div>
        </div>


    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body shadow-sm">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nama Lengkap</h6>
                    </div>
                    <div class="col-sm-9 text-secondary" id="view-fullName">
                        <?= $user['fullName']; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary" id="view-email">
                        <?= $user['email']; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">NIP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary" id="view-nip">
                        <?= $user['nip']; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kabupaten / Kota</h6>
                    </div>
                    <div class="col-sm-9 text-secondary" id="view-wilayah">
                        <?= $user['wilayah']; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="javascript:void(0)"
                            class="btn btn-md btn-primary editBtn"
                            data-id="<?= $user['id']; ?>"
                            data-username="<?= $user['username']; ?>"
                            data-fullname="<?= $user['fullName']; ?>"
                            data-email="<?= $user['email']; ?>"
                            data-nip="<?= $user['nip']; ?>"
                            data-wilayah="<?= $user['wilayah']; ?>">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Photo User -->
<div class="modal fade" id="editPhotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <form id="formEditPhoto" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="photo-user-id">

                <div class="modal-body text-center">
                    <img id="photoPreview"
                        src=""
                        class="rounded-circle mb-3"
                        width="120"
                        height="120"
                        style="object-fit: cover">

                    <input type="file"
                        name="image_user"
                        id="photoInput"
                        class="form-control"
                        accept="image/*">

                    <div class="invalid-feedback d-block"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSavePhoto">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formEditUser">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="edit-username" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="fullName" id="edit-fullName" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>NIP</label>
                        <input type="text" name="nip" id="edit-nip" class="form-control">
                        <div class="invalid-feedback">NIP</div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="edit-password" class="form-control">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback"></div>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kabupaten / Kota</label>
                        <input type="text" name="wilayah" id="edit-wilayah" class="form-control" disabled>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSave" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // buka modal edit foto
    $('.editPhotoBtn').on('click', function() {
        const id = $(this).data('id');
        const image = $(this).data('image');

        $('#photo-user-id').val(id);
        $('#photoPreview').attr(
            'src',
            '<?= base_url("uploads/user/") ?>' + image
        );

        $('#photoInput').val('');
        $('.invalid-feedback').text('');

        $('#editPhotoModal').modal('show');
    });

    // preview realtime
    $('#photoInput').on('change', function() {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            $('#photoPreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });

    // submit foto
    $('#formEditPhoto').on('submit', function(e) {
        e.preventDefault();

        const btn = $('#btnSavePhoto');
        btn.prop('disabled', true).text('Menyimpan...');

        const formData = new FormData(this);

        $.ajax({
            url: '<?= site_url("admin/updatePhotoAjax") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {

                    // 🔥 UPDATE IMAGE DI TABLE / CARD
                    $('#userImage-' + res.data.id)
                        .attr('src', res.data.image_user + '?t=' + new Date().getTime());

                    // 🔥 UPDATE data-image DI BUTTON EDIT
                    $('.editBtn[data-id="' + res.data.id + '"]')
                        .attr('data-image', res.data.image_name);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Foto berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    console.log(res);

                    $('#editPhotoModal').modal('hide');
                }
            }
        });
    });
</script>

<script>
    let typingTimer;
    const debounceTime = 400;
    let originalData = {};

    /////show hide password/////
    $('#togglePassword').on('click', function() {
        const input = $('#edit-password');
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Reset modal saat dibuka
    $('.editBtn').on('click', function() {
        let id = $(this).data('id');

        // reset dulu biar modal tidak pakai data lama
        $('#formEditUser')[0].reset();
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#btnSave').prop('disabled', true);

        $('#edit-password').attr('type', 'password');
        $('#togglePassword i').removeClass('fa-eye-slash').addClass('fa-eye');

        // ambil data TERBARU dari server
        $.ajax({
            url: "<?= base_url('admin/getUser'); ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {

                // isi form dari DB (PASTI TERUPDATE)
                $('#edit-id').val(res.id);
                $('#edit-username').val(res.username);
                $('#edit-fullName').val(res.fullName);
                $('#edit-email').val(res.email);
                $('#edit-nip').val(res.nip);
                $('#edit-password').val('');
                $('#edit-wilayah').val(res.wilayah);

                // simpan data awal (buat deteksi perubahan)
                originalData = {
                    username: res.username,
                    email: res.email,
                    fullName: res.fullName,
                    nip: res.nip,
                    wilayah: res.wilayah
                };

                $('#editUserModal').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal mengambil data user'
                });
            }
        });
    });


    //fungsi cek apakah ada perubahan
    function isChanged() {
        return (
            $('#edit-username').val() !== originalData.username ||
            $('#edit-fullName').val() !== originalData.fullName ||
            $('#edit-email').val() !== originalData.email ||
            $('#edit-nip').val() !== originalData.nip ||
            $('#edit-password').val() !== '' || // 🔥 password diisi = perubahan
            $('#edit-wilayah').val() !== originalData.wilayah
        );
    }

    // Fungsi cek tombol Simpan
    function checkFormValid() {
        // kalau ada error → disable
        if ($('.form-control.is-invalid').length > 0) {
            $('#btnSave').prop('disabled', true);
            return;
        }

        let valid = true;

        $('#formEditUser .form-control').each(function() {
            const name = $(this).attr('name');
            const value = $(this).val();

            // selain password → wajib
            if (name !== 'password' && value === '') {
                valid = false;
            }

            // password diisi tapi terlalu pendek → invalid
            if (name === 'password' && value !== '' && value.length < 6) {
                valid = false;
            }
        });

        // 🔥 TIDAK ADA PERUBAHAN → disable
        if (!isChanged()) {
            $('#btnSave').prop('disabled', true);
            return;
        }

        $('#btnSave').prop('disabled', !valid);
    }

    // Realtime validation per-field dengan debounce
    $('.form-control').on('keyup change', function() {
        const input = $(this);
        const field = input.attr('name');
        const value = input.val();

        // 🔥 KHUSUS PASSWORD
        if (field === 'password') {
            if (value === '' || value.length >= 6) {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            } else {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').text('Password minimal 6 karakter');
            }

            checkFormValid();
            return; // 🚨 PENTING: stop AJAX
        }

        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            if (field === 'password' && value === '') {
                input.removeClass('is-invalid');
                input.next('.invalid-feedback').text('');
                checkFormValid();
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/validateField'); ?>",
                type: "POST",
                data: {
                    field: field,
                    value: value,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'error') {
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').text(res.message);
                    } else {
                        input.removeClass('is-invalid');
                        input.next('.invalid-feedback').text('');
                    }
                    checkFormValid();

                    // 🔥 tambahan: cek perubahan // kalau tidak ada perubahan → disable
                    if (!isChanged()) {
                        $('#btnSave').prop('disabled', true);
                    }
                }
            });
        }, debounceTime);
    });

    // AJAX submit form
    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnSave');
        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "<?= base_url('admin/updateAjax'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                btn.prop('disabled', false).text('Simpan');

                if (res.status === 'error') {
                    $.each(res.errors, function(key, val) {
                        $('#edit-' + key)
                            .addClass('is-invalid')
                            .next('.invalid-feedback')
                            .text(val);
                    });
                    checkFormValid();
                    return;
                }

                if (res.status === 'success') {
                    $('#view-username').text(res.data.username);
                    $('#view-fullName').text(res.data.fullName);
                    $('#view-email').text(res.data.email);
                    $('#view-nip').text(res.data.nip);
                    // $('#view-wilayah').text(res.data.wilayah);

                    $('#editUserModal').modal('hide');

                    // 🔥 tunggu modal BENAR-BENAR tertutup
                    $('#editUserModal').one('hidden.bs.modal', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diperbarui',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false).text('Simpan');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan server'
                });
            }
        });
    });
</script>

<?= $this->endSection(); ?>