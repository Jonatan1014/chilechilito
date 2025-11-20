<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" class="logo logo-light">
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

    <!-- Brand Logo Dark -->
    <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" class="logo logo-dark">
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

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Mostrar menú completo">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="#">
                <i class="ri-user-line" style="font-size: 42px; color: #727cf5;"></i>
                <span class="leftbar-user-name mt-2"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Menú Principal</li>

            <li class="side-nav-item">
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=dashboard&action=index" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'dashboard') ? 'active' : ''; ?>">
                    <i class="ri-dashboard-3-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Gestión</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProducts" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'product') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarProducts" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'product') ? 'active' : ''; ?>">
                    <i class="ri-box-3-line"></i>
                    <span> Productos </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'product') ? 'show' : ''; ?>" id="sidebarProducts">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=index">Todos los Productos</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=create">Nuevo Producto</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=lowStock">Stock Bajo</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarInsumos" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'insumo') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarInsumos" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'insumo') ? 'active' : ''; ?>">
                    <i class="ri-stack-line"></i>
                    <span> Insumos </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'insumo') ? 'show' : ''; ?>" id="sidebarInsumos">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=index">Todos los Insumos</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=create">Nuevo Insumo</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=stockBajo">Alertas de Stock</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=necesidadesCompra">Necesidades de Compra</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProduction" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'production') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarProduction" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'production') ? 'active' : ''; ?>">
                    <i class="ri-settings-4-line"></i>
                    <span> Producción </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'production') ? 'show' : ''; ?>" id="sidebarProduction">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=production&action=index">Historial de Producción</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=production&action=create">Nueva Producción</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Ventas y Clientes</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSales" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'sale') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarSales" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'sale') ? 'active' : ''; ?>">
                    <i class="ri-shopping-cart-2-line"></i>
                    <span> Ventas </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'sale') ? 'show' : ''; ?>" id="sidebarSales">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=index">Todas las Ventas</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=create">Nueva Venta</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=report">Reportes</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCustomers" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'customer') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarCustomers" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'customer') ? 'active' : ''; ?>">
                    <i class="ri-user-3-line"></i>
                    <span> Clientes </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'customer') ? 'show' : ''; ?>" id="sidebarCustomers">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=index">Todos los Clientes</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=create">Nuevo Cliente</a>
                        </li>
                    </ul>
                </div>
            </li>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="side-nav-title">Administración</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUsers" 
                   aria-expanded="<?php echo (isset($_GET['controller']) && $_GET['controller'] == 'user') ? 'true' : 'false'; ?>" 
                   aria-controls="sidebarUsers" 
                   class="side-nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'user') ? 'active' : ''; ?>">
                    <i class="ri-shield-user-line"></i>
                    <span> Usuarios </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'user') ? 'show' : ''; ?>" id="sidebarUsers">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=user&action=index">Todos los Usuarios</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=user&action=create">Nuevo Usuario</a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
