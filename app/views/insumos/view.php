<?php 
$pageTitle = 'Detalle del Insumo';
include __DIR__ . '/../layouts/header.php'; 

// Calcular estadísticas
$porcentaje_stock = ($insumo['stock_actual'] / max($insumo['stock_minimo'], 1)) * 100;
$valor_stock = $insumo['stock_actual'] * $insumo['costo_unitario'];
$stockBajo = $insumo['stock_actual'] <= $insumo['stock_minimo'];
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/chilechilito/public/index.php?controller=insumo">Insumos</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($insumo['nombre']); ?></li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-flask-line text-primary me-1"></i> 
                Detalle del Insumo
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Badge de estado principal -->
<div class="row">
    <div class="col-12">
        <div class="alert <?php echo $stockBajo ? 'alert-danger' : 'alert-success'; ?> border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="<?php echo $stockBajo ? 'ri-alarm-warning-line' : 'ri-checkbox-circle-fill'; ?> fs-2 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">
                            <?php echo $stockBajo ? '¡Stock Bajo!' : 'Stock Suficiente'; ?>
                        </h5>
                        <p class="mb-0">
                            <?php if ($stockBajo): ?>
                                Este insumo necesita reposición urgente. Stock actual: <?php echo number_format($insumo['stock_actual'], 2); ?> <?php echo $insumo['unidad_medida']; ?>
                            <?php else: ?>
                                El stock actual está dentro de los niveles óptimos.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div>
                    <a href="/chilechilito/public/index.php?controller=insumo&action=index" 
                       class="btn btn-light me-2">
                        <i class="ri-arrow-left-line"></i> Volver
                    </a>
                    <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                    <a href="/chilechilito/public/index.php?controller=insumo&action=edit&id=<?php echo $insumo['id']; ?>" 
                       class="btn btn-warning">
                        <i class="ri-edit-line"></i> Editar
                    </a>
                    <?php endif; ?>
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
                    <i class="ri-box-3-line widget-icon bg-<?php echo $stockBajo ? 'danger' : 'success'; ?>-lighten text-<?php echo $stockBajo ? 'danger' : 'success'; ?>"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Stock Actual</h5>
                <h3 class="mt-3 mb-3"><?php echo number_format($insumo['stock_actual'], 2); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-<?php echo $stockBajo ? 'danger' : 'success'; ?> me-2">
                        <i class="ri-scales-line"></i>
                    </span>
                    <span class="text-nowrap"><?php echo $insumo['unidad_medida']; ?></span>
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
                <h5 class="text-muted fw-normal mt-0">Valor en Stock</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($valor_stock, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-calculator-line"></i></span>
                    <span class="text-nowrap">Valor total</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-price-tag-3-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Costo Unitario</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($insumo['costo_unitario'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-wallet-3-line"></i></span>
                    <span class="text-nowrap">Por <?php echo $insumo['unidad_medida']; ?></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-percent-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Nivel de Stock</h5>
                <h3 class="mt-3 mb-3"><?php echo round($porcentaje_stock); ?>%</h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-bar-chart-line"></i></span>
                    <span class="text-nowrap">Del mínimo</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Información detallada -->
<div class="row">
    <!-- Información del insumo -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-information-line text-primary me-1"></i> 
                    Información del Insumo
                </h4>

                <div class="text-center mb-3">
                    <div class="avatar-lg mx-auto mb-2" style="width: 80px; height: 80px;">
                        <span class="avatar-title bg-primary-lighten text-primary rounded-circle fs-1">
                            <?php echo strtoupper(substr($insumo['nombre'], 0, 2)); ?>
                        </span>
                    </div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($insumo['nombre']); ?></h5>
                    <span class="badge bg-<?php echo $insumo['estado'] == 'activo' ? 'success' : 'secondary'; ?>-lighten text-<?php echo $insumo['estado'] == 'activo' ? 'success' : 'secondary'; ?>">
                        <?php echo ucfirst($insumo['estado']); ?>
                    </span>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-barcode-line me-1"></i> SKU:
                        </span>
                        <span class="badge bg-secondary-lighten text-secondary">
                            <?php echo htmlspecialchars($insumo['sku']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-folder-line me-1"></i> Categoría:
                        </span>
                        <span class="badge bg-info-lighten text-info">
                            <?php echo htmlspecialchars($insumo['categoria']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">
                            <i class="ri-file-text-line me-1"></i> Descripción:
                        </div>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($insumo['descripcion'])); ?></p>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-scales-line me-1"></i> Unidad:
                        </span>
                        <strong><?php echo htmlspecialchars($insumo['unidad_medida']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-alert-line me-1"></i> Stock Mínimo:
                        </span>
                        <strong><?php echo number_format($insumo['stock_minimo'], 2); ?> <?php echo $insumo['unidad_medida']; ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-bar-chart-box-line me-1"></i> Stock Máximo:
                        </span>
                        <strong><?php echo number_format($insumo['stock_maximo'], 2); ?> <?php echo $insumo['unidad_medida']; ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-truck-line me-1"></i> Proveedor:
                        </span>
                        <strong><?php echo htmlspecialchars($insumo['proveedor']); ?></strong>
                    </div>
                </div>

                <!-- Barra de progreso de stock -->
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Estado del Stock</h6>
                        <span class="text-muted"><?php echo round($porcentaje_stock); ?>%</span>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar <?php 
                            echo $porcentaje_stock >= 100 ? 'bg-success' : 
                                 ($porcentaje_stock >= 50 ? 'bg-warning' : 'bg-danger');
                        ?>" 
                             style="width: <?php echo min($porcentaje_stock, 100); ?>%">
                            <?php echo number_format($insumo['stock_actual'], 2); ?> / <?php echo number_format($insumo['stock_minimo'], 2); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos y Movimientos -->
    <div class="col-lg-6">
        <?php if (!empty($productos)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-shopping-bag-line text-success me-1"></i> 
                    Productos que Usan este Insumo
                </h4>

                <div class="list-group list-group-flush">
                    <?php foreach ($productos as $prod): ?>
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="ri-box-3-line text-muted me-1"></i>
                                <strong><?php echo htmlspecialchars($prod['producto_nombre']); ?></strong>
                            </div>
                            <span class="badge bg-info-lighten text-info">
                                <?php echo number_format($prod['cantidad_necesaria'], 2); ?> <?php echo $prod['unidad_medida']; ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-history-line text-warning me-1"></i> 
                    Últimos Movimientos
                </h4>

                <?php if (!empty($movimientos)): ?>
                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movimientos as $mov): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($mov['fecha_movimiento'])); ?></td>
                                <td>
                                    <?php 
                                    $tipoBadge = [
                                        'compra' => 'success',
                                        'uso' => 'warning',
                                        'ajuste' => 'info'
                                    ];
                                    $tipoIcon = [
                                        'compra' => 'ri-add-circle-line',
                                        'uso' => 'ri-subtract-line',
                                        'ajuste' => 'ri-refresh-line'
                                    ];
                                    $color = $tipoBadge[$mov['tipo_movimiento']] ?? 'secondary';
                                    $icon = $tipoIcon[$mov['tipo_movimiento']] ?? 'ri-arrow-right-line';
                                    ?>
                                    <span class="badge bg-<?php echo $color; ?>-lighten text-<?php echo $color; ?>">
                                        <i class="<?php echo $icon; ?> me-1"></i>
                                        <?php echo ucfirst($mov['tipo_movimiento']); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo number_format($mov['cantidad'], 2); ?></strong> 
                                    <?php echo $mov['unidad_medida']; ?>
                                </td>
                                <td><small class="text-muted"><?php echo htmlspecialchars($mov['notas']); ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info border-info mb-0">
                    <i class="ri-information-line me-1"></i>
                    No hay movimientos registrados
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
