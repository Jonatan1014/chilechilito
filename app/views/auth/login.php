<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Iniciar Sesión - ChileChilito</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de Gestión de Inventario ChileChilito" name="description" />
    <meta content="ChileChilito" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo APP_URL; ?>/public/assets/favicon.png">

    <!-- Theme Config Js -->
    <script src="<?php echo APP_URL; ?>/public/assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
            <g fill-opacity='0.22'>
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100' />
            </g>
        </svg>
    </div>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="<?php echo APP_URL; ?>/public/index.php">
                                <span class="text-white fs-3 fw-bold">
                                    <i class="ri-fire-line"></i> ChileChilito
                                </span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Iniciar Sesión</h4>
                                <p class="text-muted mb-4">Ingresa tu usuario y contraseña para acceder al sistema.</p>
                            </div>

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="ri-error-warning-line me-1"></i>
                                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="ri-checkbox-circle-line me-1"></i>
                                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=auth&action=login">

                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuario o Email</label>
                                    <input class="form-control" type="text" id="username" name="username" required autofocus placeholder="Ingresa tu usuario o email">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                        <label class="form-check-label" for="checkbox-signin">Recordarme</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ri-login-box-line me-1"></i> Iniciar Sesión
                                    </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body py-3">
                                    <div class="text-center">
                                        <p class="text-muted mb-2"><small><i class="ri-information-line"></i> Usuarios de prueba:</small></p>
                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                            <span class="badge bg-primary-lighten text-primary px-3 py-2">
                                                <i class="ri-shield-user-line"></i> admin@chilechilito.cl / 123
                                            </span>
                                            <span class="badge bg-success-lighten text-success px-3 py-2">
                                                <i class="ri-user-line"></i> vendedor@chilechilito.cl / 123
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2024 -
        <script>document.write(new Date().getFullYear())</script> © ChileChilito - Sistema de Gestión de Inventario
    </footer>

    <!-- Vendor js -->
    <script src="<?php echo APP_URL; ?>/public/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo APP_URL; ?>/public/assets/js/app.js"></script>

</body>
</html>
