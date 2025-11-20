<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Form Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="bg-light">

        <div class="container mt-5">
            <div class="card shadow-sm p-4">
                <h3 class="mb-3">Register User Baru</h3>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/simpanuser') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" value="<?= old('username') ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Pilih Grup</label>
                        <select name="group" class="form-select" required>
                            <option value="">-- Pilih Grup --</option>
                            <option value="admin" <?= old('group') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= old('group') == 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Daftar</button>
                </form>
            </div>
        </div>

    </body>

    </html>

</div>

<?= $this->endSection(); ?>