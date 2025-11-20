<?php 
$pageTitle = 'Gestión de Producción';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Producción</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-factory-line text-primary me-1"></i> Gestión de Producción
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Estadísticas -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-file-list-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Producciones</h5>
                <h3 class="mt-3 mb-3"><?php echo $estadisticas['total_producciones'] ?? 0; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-calendar-line"></i></span>
                    <span class="text-nowrap">Últimos 30 días</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-stack-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Unidades Producidas</h5>
                <h3 class="mt-3 mb-3"><?php echo number_format($estadisticas['total_unidades'] ?? 0, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-box-3-line"></i></span>
                    <span class="text-nowrap">Total unidades</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-money-dollar-circle-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Costo Total</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($estadisticas['costo_total'] ?? 0, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-funds-line"></i></span>
                    <span class="text-nowrap">Inversión total</span>
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
                <h5 class="text-muted fw-normal mt-0">Costo Promedio</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($estadisticas['costo_promedio_unitario'] ?? 0, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-calculator-line"></i></span>
                    <span class="text-nowrap">Por unidad</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Historial de Producciones -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="header-title">
                            <i class="ri-history-line text-primary me-1"></i> 
                            Historial de Producciones
                        </h4>
                        <p class="text-muted mb-0">
                            Registro completo de todas las producciones realizadas
                        </p>
                    </div>
                    <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                    <div>
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=production&action=create" 
                           class="btn btn-primary">
                            <i class="ri-add-circle-line"></i> Nueva Producción
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="table-responsive">
                    <table id="produccionTable" class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha & Hora</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Costo Total</th>
                                <th>Costo Unitario</th>
                                <th>Eficiencia</th>
                                <th width="100">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $costoPromedioGlobal = $estadisticas['costo_promedio_unitario'] ?? 0;
                            foreach ($producciones as $produccion): 
                                $costoUnitario = $produccion['costo_produccion'] / $produccion['cantidad_producida'];
                                
                                // Calcular eficiencia comparada con el promedio
                                $eficiencia = 'normal';
                                $badgeEficiencia = 'bg-info';
                                $iconoEficiencia = 'ri-medal-line';
                                
                                if ($costoPromedioGlobal > 0) {
                                    $diferencia = (($costoUnitario - $costoPromedioGlobal) / $costoPromedioGlobal) * 100;
                                    if ($diferencia < -10) {
                                        $eficiencia = 'excelente';
                                        $badgeEficiencia = 'bg-success';
                                        $iconoEficiencia = 'ri-trophy-line';
                                    } elseif ($diferencia > 10) {
                                        $eficiencia = 'mejorable';
                                        $badgeEficiencia = 'bg-warning';
                                        $iconoEficiencia = 'ri-error-warning-line';
                                    }
                                }
                            ?>
                            <tr>
                                <td>
                                    <span class="badge bg-dark fs-6">#<?php echo str_pad($produccion['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?php echo date('d/m/Y', strtotime($produccion['fecha_produccion'])); ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="ri-time-line"></i> 
                                            <?php echo date('H:i', strtotime($produccion['fecha_produccion'])); ?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="mb-1"><?php echo htmlspecialchars($produccion['producto_nombre']); ?></h5>
                                    <small class="text-muted">
                                        <i class="ri-box-3-line"></i> 
                                        Lote #<?php echo $produccion['id']; ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-lighten text-primary">
                                        <?php echo htmlspecialchars($produccion['categoria']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-stack-line text-success me-2 fs-4"></i>
                                        <div>
                                            <strong class="fs-5"><?php echo number_format($produccion['cantidad_producida'], 0, ',', '.'); ?></strong>
                                            <br>
                                            <small class="text-muted">unidades</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-danger">
                                        $<?php echo number_format($produccion['costo_produccion'], 0, ',', '.'); ?>
                                    </strong>
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-primary">
                                            $<?php echo number_format($costoUnitario, 2, ',', '.'); ?>
                                        </strong>
                                        <br>
                                        <small class="text-muted">por unidad</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $badgeEficiencia; ?>">
                                        <i class="<?php echo $iconoEficiencia; ?>"></i>
                                        <?php echo ucfirst($eficiencia); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=production&action=view&id=<?php echo $produccion['id']; ?>" 
                                       class="btn btn-info btn-sm w-100" 
                                       title="Ver detalle completo">
                                        <i class="ri-eye-line"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resumen de Producción -->
<div class="row">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-pie-chart-line text-primary me-1"></i> 
                    Productos Más Producidos
                </h4>
                
                <?php
                // Agrupar por producto
                $productosAgrupados = [];
                foreach ($producciones as $prod) {
                    $nombre = $prod['producto_nombre'];
                    if (!isset($productosAgrupados[$nombre])) {
                        $productosAgrupados[$nombre] = [
                            'cantidad' => 0,
                            'veces' => 0,
                            'costo' => 0,
                            'categoria' => $prod['categoria']
                        ];
                    }
                    $productosAgrupados[$nombre]['cantidad'] += $prod['cantidad_producida'];
                    $productosAgrupados[$nombre]['veces']++;
                    $productosAgrupados[$nombre]['costo'] += $prod['costo_produccion'];
                }
                
                // Ordenar por cantidad
                uasort($productosAgrupados, function($a, $b) {
                    return $b['cantidad'] <=> $a['cantidad'];
                });
                
                $topProductos = array_slice($productosAgrupados, 0, 5, true);
                ?>
                
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Lotes</th>
                                <th class="text-center">Unidades</th>
                                <th class="text-end">Inversión</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topProductos as $nombre => $data): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($nombre); ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="ri-tag-line"></i> 
                                        <?php echo htmlspecialchars($data['categoria']); ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?php echo $data['veces']; ?></span>
                                </td>
                                <td class="text-center">
                                    <strong class="text-success"><?php echo number_format($data['cantidad'], 0, ',', '.'); ?></strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-danger">
                                        $<?php echo number_format($data['costo'], 0, ',', '.'); ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-lightbulb-line text-success me-1"></i> 
                    Insights de Producción
                </h4>
                
                <?php
                // Calcular insights
                $totalProducciones = count($producciones);
                $produccionMasGrande = 0;
                $produccionMasEficiente = null;
                $mejorCostoUnitario = PHP_FLOAT_MAX;
                
                foreach ($producciones as $prod) {
                    if ($prod['cantidad_producida'] > $produccionMasGrande) {
                        $produccionMasGrande = $prod['cantidad_producida'];
                    }
                    $costoUnit = $prod['costo_produccion'] / $prod['cantidad_producida'];
                    if ($costoUnit < $mejorCostoUnitario) {
                        $mejorCostoUnitario = $costoUnit;
                        $produccionMasEficiente = $prod;
                    }
                }
                
                $promedioUnidadesPorLote = $totalProducciones > 0 
                    ? ($estadisticas['total_unidades'] ?? 0) / $totalProducciones 
                    : 0;
                ?>
                
                <div class="alert alert-success mb-2">
                    <i class="ri-trophy-line me-1"></i>
                    <strong>Producción más grande:</strong> 
                    <?php echo number_format($produccionMasGrande, 0, ',', '.'); ?> unidades en un solo lote
                </div>
                
                <div class="alert alert-info mb-2">
                    <i class="ri-bar-chart-line me-1"></i>
                    <strong>Promedio por lote:</strong> 
                    <?php echo number_format($promedioUnidadesPorLote, 1, ',', '.'); ?> unidades producidas
                </div>
                
                <?php if ($produccionMasEficiente): ?>
                <div class="alert alert-primary mb-2">
                    <i class="ri-medal-line me-1"></i>
                    <strong>Producción más eficiente:</strong> 
                    <?php echo htmlspecialchars($produccionMasEficiente['producto_nombre']); ?>
                    <br>
                    <small>Costo unitario: $<?php echo number_format($mejorCostoUnitario, 2, ',', '.'); ?></small>
                </div>
                <?php endif; ?>
                
                <div class="alert alert-warning mb-0">
                    <i class="ri-calendar-check-line me-1"></i>
                    <strong>Total producciones:</strong> 
                    <?php echo $totalProducciones; ?> lotes completados en 30 días
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables initialization -->
<script>
$(document).ready(function() {
    $('#produccionTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        order: [[0, 'desc']], // Ordenar por ID descendente (más reciente primero)
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="ri-file-excel-line"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Historial de Producción - <?php echo date('d/m/Y'); ?>'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Historial de Producción',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            {
                extend: 'print',
                text: '<i class="ri-printer-line"></i> Imprimir',
                className: 'btn btn-info btn-sm'
            },
            {
                extend: 'copy',
                text: '<i class="ri-file-copy-line"></i> Copiar',
                className: 'btn btn-secondary btn-sm'
            }
        ],
        responsive: true
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
