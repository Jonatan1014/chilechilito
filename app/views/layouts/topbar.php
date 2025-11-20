<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" class="logo-light">
                    <span class="logo-lg">
                        <span class="text-white fs-4 fw-bold">
                            <i class="ri-fire-line"></i> ChileChilito
                        </span>
                    </span>
                    <span class="logo-sm">
                        <span class="text-white fs-5 fw-bold">
                            <i class="ri-fire-line"></i> CC
                        </span>
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" class="logo-dark">
                    <span class="logo-lg">
                        <span class="text-dark fs-4 fw-bold">
                            <i class="ri-fire-line"></i> ChileChilito
                        </span>
                    </span>
                    <span class="logo-sm">
                        <span class="text-dark fs-5 fw-bold">
                            <i class="ri-fire-line"></i> CC
                        </span>
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="ri-menu-5-line"></i>
            </button>

            <!-- Back Button -->
            <button class="btn btn-sm btn-light rounded-circle" onclick="window.history.back();" title="Volver atrás">
                <i class="ri-arrow-left-line"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Topbar Search Form -->
            <div class="app-search dropdown d-none d-lg-block">
                <form action="<?php echo APP_URL; ?>/public/index.php" method="GET">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    <div class="input-group">
                        <input type="search" class="form-control dropdown-toggle" name="search" placeholder="Buscar productos..." id="top-search">
                        <span class="ri-search-line search-icon"></span>
                        <button class="input-group-text btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line font-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3" action="<?php echo APP_URL; ?>/public/index.php" method="GET">
                        <input type="hidden" name="controller" value="product">
                        <input type="hidden" name="action" value="index">
                        <input type="search" name="search" class="form-control" placeholder="Buscar..." aria-label="Search">
                    </form>
                </div>
            </li>

            <li class="d-none d-sm-inline-block">
                <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                    <i class="ri-settings-3-line font-22"></i>
                </a>
            </li>

            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>

            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="#" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line font-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <i class="ri-user-line" style="font-size: 32px;"></i>
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0"><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                        <h6 class="my-0 fw-normal"><?php echo ucfirst($_SESSION['role']); ?></h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">¡Bienvenido!</h6>
                    </div>

                    <!-- item-->
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=user&action=profile" class="dropdown-item">
                        <i class="ri-user-smile-line font-16 me-1"></i>
                        <span>Mi Cuenta</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" class="dropdown-item">
                        <i class="ri-dashboard-line font-16 me-1"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- item-->
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=auth&action=logout" class="dropdown-item">
                        <i class="ri-login-circle-line font-16 me-1"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
