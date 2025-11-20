<?php 
$pageTitle = 'Insumos con Stock Bajo';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo">Insumos</a></li>
                    <li class="breadcrumb-item active">Stock Bajo</li>
                </ol>
            </div>
            <h4 class="page-title"><i class="ri-alarm-warning-line text-danger me-1"></i> Insumos con Stock Bajo</h4>
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
                <h5 class="text-muted fw-normal mt-0" title="Insumos en Alerta">Insumos en Alerta</h5>
                <h3 class="mt-3 mb-3"><?php echo count($insumos); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-danger me-2"><i class="ri-arrow-down-line"></i></span>
                    <span class="text-nowrap">Requieren reposición</span>
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
                    foreach ($insumos as $i) {
                        $totalFaltante += $i['faltante'];
                    }
                    echo number_format($totalFaltante, 2);
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
                    foreach ($insumos as $i) {
                        $valorEstimado += ($i['faltante'] * $i['costo_unitario']);
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
                    <i class="ri-team-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Proveedores Afectados</h5>
                <h3 class="mt-3 mb-3">
                    <?php 
                    $proveedores = array_unique(array_column($insumos, 'proveedor'));
                    echo count($proveedores);
                    ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-building-line"></i></span>
                    <span class="text-nowrap">A contactar</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de insumos con stock bajo -->
<div class="row">
    <div class="col-12">
        <?php if (empty($insumos)): ?>
        <div class="card border-success">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="ri-checkbox-circle-line text-success" style="font-size: 72px;"></i>
                </div>
                <h3 class="text-success mb-3">¡Excelente! Stock Óptimo</h3>
                <p class="text-muted fs-5">
                    Todos los insumos tienen stock suficiente. No hay alertas en este momento.
                </p>
                <div class="mt-4">
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo" class="btn btn-success me-2">
                        <i class="ri-list-check"></i> Ver Todos los Insumos
                    </a>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=necesidadesCompra" class="btn btn-info">
                        <i class="ri-shopping-cart-line"></i> Necesidades de Compra
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card border-danger">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h4 class="card-title text-white mb-0">
                    <i class="ri-alert-line me-1"></i> Insumos que Requieren Reposición Urgente
                </h4>
                <div>
                    <span class="badge bg-white text-danger me-2"><?php echo count($insumos); ?> insumos</span>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=necesidadesCompra" 
                       class="btn btn-sm btn-light">
                        <i class="ri-shopping-cart-line"></i> Necesidades de Compra
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-warning mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-information-line font-24 me-2"></i>
                        <div>
                            <strong>¡Atención!</strong> Se encontraron <strong><?php echo count($insumos); ?></strong> 
                            insumos con stock por debajo del mínimo requerido. Se recomienda realizar pedidos de reposición lo antes posible.
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="insumos-stock-bajo-datatable" class="table table-striped table-hover dt-responsive nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th>SKU</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                                <th>Faltante</th>
                                <th>Costo Unit.</th>
                                <th>Valor Reponer</th>
                                <th>Proveedor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($insumos as $insumo): 
                                $valorReponer = $insumo['faltante'] * $insumo['costo_unitario'];
                                $porcentaje = ($insumo['stock_actual'] / $insumo['stock_minimo']) * 100;
                                $urgencia = $porcentaje < 50 ? 'danger' : 'warning';
                            ?>
                            <tr class="table-<?php echo $urgencia; ?>">
                                <td>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($insumo['sku']); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-alert-line text-<?php echo $urgencia; ?> me-2 fs-5"></i>
                                        <strong><?php echo htmlspecialchars($insumo['nombre']); ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo htmlspecialchars($insumo['categoria']); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="badge bg-<?php echo $urgencia; ?> fs-6 mb-1">
                                            <?php echo number_format($insumo['stock_actual'], 2); ?> <?php echo $insumo['unidad_medida']; ?>
                                        </span>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-<?php echo $urgencia; ?>" role="progressbar" 
                                                 style="width: <?php echo min($porcentaje, 100); ?>%" 
                                                 aria-valuenow="<?php echo $porcentaje; ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo number_format($insumo['stock_minimo'], 2); ?> 
                                    <small class="text-muted"><?php echo $insumo['unidad_medida']; ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="ri-subtract-line"></i> <?php echo number_format($insumo['faltante'], 2); ?>
                                    </span>
                                </td>
                                <td>
                                    <small>$<?php echo number_format($insumo['costo_unitario'], 2); ?></small>
                                </td>
                                <td>
                                    <span class="text-danger fw-bold">
                                        $<?php echo number_format($valorReponer, 0, ',', '.'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($insumo['proveedor'])): ?>
                                        <span class="badge bg-secondary">
                                            <i class="ri-building-line"></i> <?php echo htmlspecialchars($insumo['proveedor']); ?>
                                        </span>
                                    <?php else: ?>
                                        <small class="text-muted">Sin proveedor</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=view&id=<?php echo $insumo['id']; ?>" 
                                       class="btn btn-sm btn-info" title="Ver Detalles">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=edit&id=<?php echo $insumo['id']; ?>" 
                                       class="btn btn-sm btn-primary" title="Editar">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">TOTALES:</th>
                                <th>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <?php echo number_format($totalFaltante, 2); ?>
                                    </span>
                                </th>
                                <th></th>
                                <th>
                                    <span class="text-danger fw-bold fs-5">
                                        $<?php echo number_format($valorEstimado, 0, ',', '.'); ?>
                                    </span>
                                </th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Lista de proveedores a contactar -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">
                            <i class="ri-team-line text-primary me-1"></i> Proveedores a Contactar
                        </h4>
                        <?php 
                        $proveedoresAgrupados = [];
                        foreach ($insumos as $i) {
                            $prov = !empty($i['proveedor']) ? $i['proveedor'] : 'Sin Proveedor';
                            if (!isset($proveedoresAgrupados[$prov])) {
                                $proveedoresAgrupados[$prov] = ['count' => 0, 'valor' => 0];
                            }
                            $proveedoresAgrupados[$prov]['count']++;
                            $proveedoresAgrupados[$prov]['valor'] += ($i['faltante'] * $i['costo_unitario']);
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Proveedor</th>
                                        <th class="text-center">Insumos</th>
                                        <th class="text-end">Valor Estimado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proveedoresAgrupados as $proveedor => $data): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($proveedor); ?></strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?php echo $data['count']; ?></span>
                                        </td>
                                        <td class="text-end">
                                            <strong>$<?php echo number_format($data['valor'], 0, ',', '.'); ?></strong>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="header-title mb-3">
                            <i class="ri-lightbulb-line text-warning me-1"></i> Recomendaciones
                        </h4>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-checkbox-circle-line text-success fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Contactar Proveedores</h5>
                                <p class="text-muted mb-0">Coordine con los proveedores para realizar pedidos de reposición urgente.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-calendar-check-line text-primary fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Planificación</h5>
                                <p class="text-muted mb-0">Revise las necesidades de compra para optimizar los pedidos.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="ri-money-dollar-circle-line text-info fs-4 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mt-0">Presupuesto</h5>
                                <p class="text-muted mb-0">Inversión estimada: <strong class="text-danger">${{number_format($valorEstimado, 0, ',', '.')}}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
    <?php if (!empty($insumos)): ?>
    $('#insumos-stock-bajo-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[5, 'desc']], // Ordenar por faltante descendente
        pageLength: 25,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            { extend: 'copy', text: '<i class="ri-file-copy-line"></i> Copiar', className: 'btn btn-sm btn-light' },
            { extend: 'excel', text: '<i class="ri-file-excel-line"></i> Excel', className: 'btn btn-sm btn-success', title: 'Insumos con Stock Bajo' },
            { extend: 'pdf', text: '<i class="ri-file-pdf-line"></i> PDF', className: 'btn btn-sm btn-danger', title: 'Insumos con Stock Bajo' },
            { extend: 'print', text: '<i class="ri-printer-line"></i> Imprimir', className: 'btn btn-sm btn-info' }
        ]
    });
    <?php endif; ?>
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
