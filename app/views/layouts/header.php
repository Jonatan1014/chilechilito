<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title><?php echo $pageTitle ?? 'Dashboard'; ?> | ChileChilito - Sistema de Gestión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de inventario, ventas y producción" name="description" />
    <meta content="ChileChilito" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo APP_URL; ?>/public/assets/images/favicon.ico">

    <!-- Datatables css (ANTES de vendor.css para evitar conflictos) -->
    <link href="<?php echo APP_URL; ?>/public/assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo APP_URL; ?>/public/assets/vendor/datatables/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo APP_URL; ?>/public/assets/vendor/datatables/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="<?php echo APP_URL; ?>/public/assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="<?php echo APP_URL; ?>/public/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo APP_URL; ?>/public/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo APP_URL; ?>/public/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- ========== Topbar Start ========== -->
        <?php include __DIR__ . '/topbar.php'; ?>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        <!-- ========== Left Sidebar End ========== -->
        <?php endif; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content Here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">