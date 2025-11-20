<?php 
$pageTitle = 'Productos con Stock Bajo';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=product">Productos</a></li>
                    <li class="breadcrumb-item active">Stock Bajo</li>
                </ol>
            </div>
            <h4 class="page-title"><i class="ri-alarm-warning-line text-danger me-1"></i> Productos con Stock Bajo</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Estadísticas de alerta -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-alert-line widget-icon bg-danger-lighten text-danger"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Productos en Alerta">Productos en Alerta</h5>
                <h3 class="mt-3 mb-3"><?php echo count($products); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-danger me-2"><i class="ri-arrow-down-line"></i></span>
                    <span class="text-nowrap">Requieren atención</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-shopping-cart-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Unidades Faltantes</h5>
                <h3 class="mt-3 mb-3">
                    <?php 
                    $totalFaltante = 0;
                    foreach ($products as $p) {
                        $totalFaltante += ($p['stock_minimo'] - $p['stock_actual']);
                    }
                    echo $totalFaltante;
                    ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-subtract-line"></i></span>
                    <span class="text-nowrap">Total a reponer</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-price-tag-3-line widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Valor Estimado</h5>
                <h3 class="mt-3 mb-3">
                    $<?php 
                    $valorEstimado = 0;
                    foreach ($products as $p) {
                        $faltante = $p['stock_minimo'] - $p['stock_actual'];
                        $valorEstimado += ($faltante * $p['precio']);
                    }
                    echo number_format($valorEstimado, 0, ',', '.');
                    ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-money-dollar-circle-line"></i></span>
                    <span class="text-nowrap">Inversión necesaria</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-time-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Estado</h5>
                <h3 class="mt-3 mb-3">
                    <?php echo count($products) > 0 ? 'Urgente' : 'Normal'; ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="<?php echo count($products) > 0 ? 'text-danger' : 'text-success'; ?> me-2">
                        <i class="<?php echo count($products) > 0 ? 'ri-error-warning-line' : 'ri-checkbox-circle-line'; ?>"></i>
                    </span>
                    <span class="text-nowrap">Nivel de alerta</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de productos con stock bajo -->
<div class="row">
    <div class="col-12">
        <?php if (count($products) > 0): ?>
        <div class="card border-danger">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h4 class="card-title text-white mb-0">
                    <i class="ri-alert-line me-1"></i> Productos que Requieren Reposición Urgente
                </h4>
                <span class="badge bg-white text-danger"><?php echo count($products); ?> productos</span>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-warning mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-information-line font-24 me-2"></i>
                        <div>
                            <strong>¡Atención!</strong> Los siguientes productos tienen stock por debajo del mínimo requerido.
                            Se recomienda realizar pedidos de reposición lo antes posible.
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="low-stock-datatable" class="table table-striped table-hover dt-responsive nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                                <th>Déficit</th>
                                <th>Valor Reponer</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): 
                                $diferencia = $product['stock_minimo'] - $product['stock_actual'];
                                $valorReponer = $diferencia * $product['precio'];
                                $porcentaje = ($product['stock_actual'] / $product['stock_minimo']) * 100;
                            ?>
                            <tr class="table-warning">
                                <td><strong>#<?php echo $product['id']; ?></strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-alert-line text-danger me-2 fs-5"></i>
                                        <strong><?php echo htmlspecialchars($product['nombre']); ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($product['categoria']); ?></span>
                                </td>
                                <td><strong>$<?php echo number_format($product['precio'], 0, ',', '.'); ?></strong></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="badge bg-danger fs-6 mb-1">
                                            <?php echo $product['stock_actual']; ?> unidades
                                        </span>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-danger" role="progressbar" 
                                                 style="width: <?php echo min($porcentaje, 100); ?>%" 
                                                 aria-valuenow="<?php echo $porcentaje; ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $product['stock_minimo']; ?> unidades</td>
                                <td>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="ri-subtract-line"></i> <?php echo $diferencia; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-danger fw-bold">
                                        $<?php echo number_format($valorReponer, 0, ',', '.'); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" 
                                       class="btn btn-sm btn-primary" title="Actualizar Stock">
                                        <i class="ri-pencil-line"></i> Actualizar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card border-success">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="ri-checkbox-circle-line text-success" style="font-size: 72px;"></i>
                </div>
                <h3 class="text-success mb-3">¡Excelente! Stock Óptimo</h3>
                <p class="text-muted fs-5">
                    Todos los productos tienen stock suficiente. No hay alertas en este momento.
                </p>
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product" class="btn btn-success mt-3">
                    <i class="ri-list-check"></i> Ver Todos los Productos
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Recomendaciones -->
<div class="row">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-lightbulb-line text-warning me-1"></i> Recomendaciones y Mejores Prácticas
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-checkbox-circle-line text-success fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Revisión Regular</h5>
                                <p class="text-muted">Revise regularmente esta sección para evitar quedarse sin stock de productos importantes.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-line-chart-line text-primary fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Ajuste de Stock Mínimo</h5>
                                <p class="text-muted">Considere aumentar el stock mínimo de productos de alta rotación o con mayor demanda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-notification-3-line text-info fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Alertas Automáticas</h5>
                                <p class="text-muted">Configure alertas automáticas para recibir notificaciones cuando el stock sea bajo.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-team-line text-success fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Relación con Proveedores</h5>
                                <p class="text-muted">Mantenga buena comunicación con proveedores para garantizar reposición rápida.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables js -->
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/responsive.bootstrap5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.bootstrap5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.html5.min.js"></script>
<script src="<?php echo APP_URL; ?>/public/assets/vendor/datatables/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    <?php if (count($products) > 0): ?>
    $('#low-stock-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[6, 'desc']], // Ordenar por déficit descendente
        pageLength: 25,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            { extend: 'copy', text: '<i class="ri-file-copy-line"></i> Copiar', className: 'btn btn-sm btn-light' },
            { extend: 'excel', text: '<i class="ri-file-excel-line"></i> Excel', className: 'btn btn-sm btn-success', title: 'Productos con Stock Bajo' },
            { extend: 'pdf', text: '<i class="ri-file-pdf-line"></i> PDF', className: 'btn btn-sm btn-danger', title: 'Productos con Stock Bajo' },
            { extend: 'print', text: '<i class="ri-printer-line"></i> Imprimir', className: 'btn btn-sm btn-info' }
        ]
    });
    <?php endif; ?>
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
