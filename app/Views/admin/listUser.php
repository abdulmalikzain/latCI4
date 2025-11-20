<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="table-responsive" style="margin-top: 10px;">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Kategori User</th>
                <th scope="col">Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php $i = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->name ?></td>
                        <td><a class="btn btn-info btn-sm" href="<?= base_url('admin/' . $user->userid) ?>"><i class="fa fa-pen"></i></a>
                    </tr>
                <?php endforeach ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>