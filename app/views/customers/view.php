<?php 
$pageTitle = 'Detalle del Cliente';
include __DIR__ . '/../layouts/header.php'; 

// Calcular estadísticas
$totalCompras = count($purchaseHistory);
$totalGastado = array_sum(array_column($purchaseHistory, 'total'));
$totalProductos = array_sum(array_column($purchaseHistory, 'items_count'));
$promedioCompra = $totalCompras > 0 ? $totalGastado / $totalCompras : 0;
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=customer">Clientes</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-user-3-line text-primary me-1"></i> 
                Detalle del Cliente
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Badge de estado principal -->
<div class="row">
    <div class="col-12">
        <div class="alert <?php echo $customer['estado'] == 'activo' ? 'alert-success' : 'alert-secondary'; ?> border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="<?php echo $customer['estado'] == 'activo' ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'; ?> fs-2 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">
                            Cliente <?php echo ucfirst($customer['estado']); ?>
                        </h5>
                        <p class="mb-0">
                            Registrado el <?php echo date('d/m/Y', strtotime($customer['fecha_registro'])); ?>
                        </p>
                    </div>
                </div>
                <div>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=edit&id=<?php echo $customer['id']; ?>" 
                       class="btn btn-primary me-2">
                        <i class="ri-edit-line"></i> Editar
                    </a>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=index" 
                       class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas rápidas -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-shopping-cart-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Total Compras</h5>
                <h3 class="mt-3 mb-3"><?php echo $totalCompras; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-shopping-bag-line"></i></span>
                    <span class="text-nowrap">Ventas realizadas</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-money-dollar-circle-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Total Gastado</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($totalGastado, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-wallet-3-line"></i></span>
                    <span class="text-nowrap">Monto total</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-box-3-line widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Total Productos</h5>
                <h3 class="mt-3 mb-3"><?php echo $totalProductos; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-stack-line"></i></span>
                    <span class="text-nowrap">Unidades compradas</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-line-chart-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Promedio Compra</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($promedioCompra, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-bar-chart-line"></i></span>
                    <span class="text-nowrap">Por transacción</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Información detallada -->
<div class="row">
    <!-- Información del cliente -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-information-line text-primary me-1"></i> 
                    Información Personal
                </h4>

                <div class="text-center mb-3">
                    <div class="avatar-lg mx-auto mb-2" style="width: 80px; height: 80px;">
                        <span class="avatar-title bg-primary-lighten text-primary rounded-circle fs-1">
                            <?php echo strtoupper(substr($customer['nombre'], 0, 1) . substr($customer['apellido'], 0, 1)); ?>
                        </span>
                    </div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></h5>
                    <span class="badge bg-<?php echo $customer['estado'] == 'activo' ? 'success' : 'secondary'; ?>-lighten text-<?php echo $customer['estado'] == 'activo' ? 'success' : 'secondary'; ?>">
                        <?php echo ucfirst($customer['estado']); ?>
                    </span>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-id-card-line me-1"></i> RUT:
                        </span>
                        <strong><?php echo htmlspecialchars($customer['rut']); ?></strong>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">
                            <i class="ri-mail-line me-1"></i> Email:
                        </div>
                        <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars($customer['email']); ?>
                        </a>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">
                            <i class="ri-phone-line me-1"></i> Teléfono:
                        </div>
                        <a href="tel:<?php echo htmlspecialchars($customer['telefono']); ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars($customer['telefono']); ?>
                        </a>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">
                            <i class="ri-map-pin-line me-1"></i> Dirección:
                        </div>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($customer['direccion'])); ?></p>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-calendar-line me-1"></i> Registro:
                        </span>
                        <strong><?php echo date('d/m/Y', strtotime($customer['fecha_registro'])); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos más comprados -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-shopping-bag-line text-success me-1"></i> 
                    Productos Más Comprados
                </h4>

                <?php if (count($topProducts) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Unidades Compradas</th>
                                <th>Veces Comprado</th>
                                <th>Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $maxVeces = max(array_column($topProducts, 'veces_comprado'));
                            foreach ($topProducts as $product): 
                                $porcentaje = ($product['veces_comprado'] / max($maxVeces, 1)) * 100;
                            ?>
                            <tr>
                                <td>
                                    <i class="ri-box-3-line text-muted me-1"></i>
                                    <strong><?php echo htmlspecialchars($product['nombre']); ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-info-lighten text-info">
                                        <?php echo $product['total_comprado']; ?> unidades
                                    </span>
                                </td>
                                <td><?php echo $product['veces_comprado']; ?> veces</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: <?php echo $porcentaje; ?>%"
                                             role="progressbar">
                                            <?php echo round($porcentaje); ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info border-info mb-0">
                    <i class="ri-information-line me-1"></i>
                    Este cliente aún no ha realizado compras
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Historial de compras -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-history-line text-warning me-1"></i> 
                    Historial de Compras
                </h4>

                <?php if (count($purchaseHistory) > 0): ?>
                <div class="table-responsive">
                    <table id="history-datatable" class="table table-striped table-centered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Método de Pago</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchaseHistory as $sale): ?>
                            <tr>
                                <td><strong>#<?php echo $sale['id']; ?></strong></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($sale['fecha_venta'])); ?></td>
                                <td>
                                    <span class="badge bg-secondary-lighten text-secondary">
                                        <?php echo $sale['items_count']; ?> items
                                    </span>
                                </td>
                                <td><strong>$<?php echo number_format($sale['total'], 0, ',', '.'); ?></strong></td>
                                <td>
                                    <?php 
                                    $metodoBadge = [
                                        'efectivo' => 'success',
                                        'tarjeta' => 'info',
                                        'transferencia' => 'primary'
                                    ];
                                    $color = $metodoBadge[$sale['metodo_pago']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo $color; ?>-lighten text-<?php echo $color; ?>">
                                        <i class="ri-<?php echo $sale['metodo_pago'] == 'efectivo' ? 'money-dollar-circle' : ($sale['metodo_pago'] == 'tarjeta' ? 'bank-card' : 'exchange'); ?>-line me-1"></i>
                                        <?php echo ucfirst($sale['metodo_pago']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $estadoBadge = [
                                        'completada' => 'success',
                                        'pendiente' => 'warning',
                                        'cancelada' => 'danger'
                                    ];
                                    $estadoColor = $estadoBadge[$sale['estado']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo $estadoColor; ?>-lighten text-<?php echo $estadoColor; ?>">
                                        <?php echo ucfirst($sale['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=view&id=<?php echo $sale['id']; ?>" 
                                       class="btn btn-sm btn-info" title="Ver Detalle">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info border-info mb-0">
                    <i class="ri-information-line me-1"></i>
                    Este cliente aún no ha realizado compras
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

<?php if (count($purchaseHistory) > 0): ?>
<!-- Datatables js -->
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/responsive.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.bootstrap5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.html5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.print.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/jszip.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/pdfmake.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/vfs_fonts.js"></script>

<!-- Datatable Init -->
<script>
$(document).ready(function() {
    "use strict";
    
    $('#history-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[0, 'desc']], // Ordenar por ID descendente
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: 'copy',
                text: '<i class="ri-file-copy-line"></i> Copiar',
                className: 'btn btn-sm btn-light'
            },
            {
                extend: 'excel',
                text: '<i class="ri-file-excel-line"></i> Excel',
                className: 'btn btn-sm btn-success',
                title: 'Historial de Compras - <?php echo htmlspecialchars($customer['nombre'] . " " . $customer['apellido']); ?>',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-sm btn-danger',
                title: 'Historial de Compras - <?php echo htmlspecialchars($customer['nombre'] . " " . $customer['apellido']); ?>',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="ri-printer-line"></i> Imprimir',
                className: 'btn btn-sm btn-info',
                title: 'Historial de Compras - <?php echo htmlspecialchars($customer['nombre'] . " " . $customer['apellido']); ?>',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});
</script>
<?php endif; ?>
