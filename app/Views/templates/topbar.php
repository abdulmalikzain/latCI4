<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow-sm">

    <!-- Topbar Search -->
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 ">
        <h5>Sistem Informasi Kebakaran</h5>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item mr-3">
            <a href="<?= base_url('admin/' . user()->id) ?>" class="btn btn-outline-danger">
                <i class="fa fa-user"></i> <?= user()->username ?>
            </a>
        </li>

    </ul>

</nav>