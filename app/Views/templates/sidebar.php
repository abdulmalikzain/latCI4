<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon ">
            <i class="fas fa-fire"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIRANAH<sup></sup></div>
    </a>


    <hr class="sidebar-divider my-0">


    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user') ?>">
            <i class="fas fa-fw fa-map"></i>
            <span>Map</span></a>
    </li>

    <hr class="sidebar-divider my-0">

    <?php if (in_groups('admin')): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="false" aria-controls="collapsePages">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage User</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">user:</h6>
                    <a class="collapse-item" href="<?= base_url('admin/listuser') ?>">daftar user</a>
                    <a class="collapse-item" href="<?= base_url('admin/tambahuser') ?>">tambah user</a>

                </div>
            </div>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('data/tampilData') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Laporan Kejadian</span></a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('inputData') ?>">
            <i class="fas fa-fw fa-pen"></i>
            <span>Tambah Laporan</span></a>
    </li>



    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>