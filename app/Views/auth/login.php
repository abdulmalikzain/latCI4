<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card1 {
        position: relative;
        width: 100%;
        height: 100%;
        /* border-radius: 15px; */
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s;
        cursor: pointer;
    }

    .card1 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.4s ease;
        display: block;
    }

    .card1-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        opacity: 0;
        z-index: 2;
        transition: opacity 0.4s ease;
    }

    /* Overlay agar teks lebih kontras */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
    }

    .card1:hover {
        transform: scale(1.05);
    }

    .card1:hover .overlay {
        opacity: 1;
    }

    .card1:hover .card1-text {
        opacity: 1;
    }
</style>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg-6">
                            <a href="<?= base_url('data/maphome') ?>" class="card1-link" target="_blank">
                                <div class="card1" href="#">
                                    <img src="img/Asset_map.svg">
                                    <div class="overlay"></div>
                                    <div class="card1-text">Lihat Data Map</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang</h1>
                                </div>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <form action="<?= url_to('login') ?>" method="post" class="user">
                                    <?= csrf_field(); ?>

                                    <?php if ($config->validFields === ['email']): ?>
                                        <div class="form-group">
                                            <input type="email"
                                                class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                                name="login" placeholder="<?= lang('Auth.email') ?>" aria-describedby="emailHelp">
                                            <div class="invalid-feedback">
                                                <?= session('errors.login') ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                                name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.login') ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <?= lang('Auth.loginAction') ?>
                                    </button>

                                </form>
                                <hr>
                                <!-- <div class="text-center">
                                    <a class="small" >Home</a>
                                </div> -->
                                <!-- <div class="text-center">
                                    <a class="small" href="#">Create an Account!</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>