<?php 
$pageTitle = 'Detalle del Producto';
include __DIR__ . '/../layouts/header.php'; 

// Calcular porcentaje de stock
$porcentaje_stock = ($product['stock_actual'] / max($product['stock_minimo'], 1)) * 100;
$valor_stock = $product['precio'] * $product['stock_actual'];
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=product">Productos</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['nombre']); ?></li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-box-3-line text-primary me-1"></i> 
                Detalle del Producto
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Badge de estado principal -->
<div class="row">
    <div class="col-12">
        <div class="alert <?php echo $product['estado'] == 'activo' ? 'alert-success' : 'alert-secondary'; ?> border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="<?php echo $product['estado'] == 'activo' ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'; ?> fs-2 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">
                            Producto <?php echo ucfirst($product['estado']); ?>
                        </h5>
                        <p class="mb-0">
                            Creado el <?php echo date('d/m/Y', strtotime($product['fecha_creacion'])); ?>
                            • Última actualización: <?php echo date('d/m/Y H:i', strtotime($product['fecha_actualizacion'])); ?>
                        </p>
                    </div>
                </div>
                <div>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" 
                       class="btn btn-primary me-2">
                        <i class="ri-edit-line"></i> Editar
                    </a>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=index" 
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
                    <i class="ri-money-dollar-circle-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Precio de Venta</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($product['precio'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-price-tag-3-line"></i></span>
                    <span class="text-nowrap">Por unidad</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-stack-line widget-icon bg-<?php echo $product['stock_actual'] <= $product['stock_minimo'] ? 'danger' : 'info'; ?>-lighten text-<?php echo $product['stock_actual'] <= $product['stock_minimo'] ? 'danger' : 'info'; ?>"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Stock Actual</h5>
                <h3 class="mt-3 mb-3"><?php echo $product['stock_actual']; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-<?php echo $product['stock_actual'] <= $product['stock_minimo'] ? 'danger' : 'info'; ?> me-2">
                        <i class="ri-box-3-line"></i>
                    </span>
                    <span class="text-nowrap">Unidades disponibles</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-funds-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Valor en Stock</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($valor_stock, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-calculator-line"></i></span>
                    <span class="text-nowrap">Valor total inventario</span>
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
                    <span class="text-nowrap">Del stock mínimo</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Información detallada -->
<div class="row">
    <!-- Datos del producto -->
    <div class="col-lg-<?php echo !empty($receta) ? '6' : '8'; ?>">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-information-line text-primary me-1"></i> 
                    Información del Producto
                </h4>

                <?php if (!empty($product['imagen'])): ?>
                <div class="text-center mb-4">
                    <img src="<?php echo htmlspecialchars($product['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($product['nombre']); ?>"
                         class="img-fluid rounded"
                         style="max-width: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                </div>
                <?php endif; ?>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-shopping-bag-line me-1"></i> Nombre:
                        </span>
                        <strong><?php echo htmlspecialchars($product['nombre']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-price-tag-3-line me-1"></i> Categoría:
                        </span>
                        <span class="badge bg-primary-lighten text-primary">
                            <?php echo htmlspecialchars($product['categoria']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-2">
                            <i class="ri-file-text-line me-1"></i> Descripción:
                        </div>
                        <p class="mb-0">
                            <?php echo nl2br(htmlspecialchars($product['descripcion'])); ?>
                        </p>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-money-dollar-circle-line me-1"></i> Precio:
                        </span>
                        <h4 class="text-success mb-0">
                            $<?php echo number_format($product['precio'], 0, ',', '.'); ?>
                        </h4>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-stock-line me-1"></i> Stock Mínimo:
                        </span>
                        <strong><?php echo $product['stock_minimo']; ?> unidades</strong>
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
                            <?php echo $product['stock_actual']; ?> / <?php echo $product['stock_minimo']; ?>
                        </div>
                    </div>
                </div>

                <!-- Alerta de stock -->
                <?php if ($product['stock_actual'] <= $product['stock_minimo']): ?>
                <div class="alert alert-danger border-danger mt-3 mb-0">
                    <i class="ri-alarm-warning-line me-1"></i>
                    <strong>¡Atención!</strong><br>
                    Este producto necesita reposición urgente.
                    Faltan <strong><?php echo ($product['stock_minimo'] - $product['stock_actual']); ?> unidades</strong> 
                    para alcanzar el stock mínimo.
                </div>
                <?php else: ?>
                <div class="alert alert-success border-success mt-3 mb-0">
                    <i class="ri-checkbox-circle-line me-1"></i>
                    <strong>Stock Óptimo</strong><br>
                    Este producto tiene stock suficiente para la operación normal.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Análisis financiero -->
    <div class="col-lg-<?php echo !empty($receta) ? '6' : '4'; ?>">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-line-chart-line text-success me-1"></i> 
                    Análisis Financiero
                </h4>

                <?php if (!empty($receta) && isset($costo_produccion)): ?>
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <div class="card border-0 bg-success-lighten">
                            <div class="card-body p-2 text-center">
                                <i class="ri-money-dollar-circle-line text-success fs-2"></i>
                                <h6 class="text-muted fw-normal mt-2 mb-1" style="font-size: 0.75rem;">Precio Venta</h6>
                                <h5 class="mb-0 text-success">$<?php echo number_format($product['precio'], 0, ',', '.'); ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-warning-lighten">
                            <div class="card-body p-2 text-center">
                                <i class="ri-calculator-line text-warning fs-2"></i>
                                <h6 class="text-muted fw-normal mt-2 mb-1" style="font-size: 0.75rem;">Costo Prod.</h6>
                                <h5 class="mb-0 text-warning">$<?php echo number_format($costo_produccion, 0, ',', '.'); ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-primary-lighten">
                            <div class="card-body p-2 text-center">
                                <i class="ri-funds-line text-primary fs-2"></i>
                                <h6 class="text-muted fw-normal mt-2 mb-1" style="font-size: 0.75rem;">Ganancia</h6>
                                <h5 class="mb-0 text-primary">$<?php echo number_format($product['precio'] - $costo_produccion, 0, ',', '.'); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-<?php echo $margen_utilidad > 0 ? 'success' : 'danger'; ?> border-<?php echo $margen_utilidad > 0 ? 'success' : 'danger'; ?> mb-3">
                    <div class="d-flex align-items-center">
                        <i class="ri-percent-line fs-2 me-2"></i>
                        <div>
                            <h6 class="mb-0">Margen de Utilidad</h6>
                            <h4 class="mb-0 mt-1"><?php echo number_format($margen_utilidad, 2); ?>%</h4>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                <div class="alert alert-info border-info">
                    <i class="ri-information-line me-1"></i>
                    <strong>Sin receta configurada</strong><br>
                    Configure una receta para ver el análisis de costos y rentabilidad.
                </div>
                <?php endif; ?>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-wallet-3-line me-1"></i> Valor inventario:
                        </span>
                        <strong class="text-primary">$<?php echo number_format($valor_stock, 0, ',', '.'); ?></strong>
                    </div>
                    <?php if (!empty($receta) && isset($costo_produccion)): ?>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-shopping-cart-line me-1"></i> Unidades a producir:
                        </span>
                        <strong><?php echo floor($valor_stock / max($costo_produccion, 1)); ?> unidades</strong>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receta e insumos -->
<?php if (!empty($receta)): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title mb-0">
                        <i class="ri-flask-line text-info me-1"></i> 
                        Receta del Producto
                    </h4>
                    <span class="badge bg-info-lighten text-info fs-6">
                        <?php echo count($receta); ?> insumos
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0" id="recetaTable">
                        <thead class="table-light">
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad Necesaria</th>
                                <th>Stock Disponible</th>
                                <th>Estado</th>
                                <th class="text-end">Costo Unitario</th>
                                <th class="text-end">Costo Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($receta as $ingrediente): 
                                $suficiente = $ingrediente['stock_actual'] >= $ingrediente['cantidad_necesaria'];
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=view&id=<?php echo $ingrediente['insumo_id']; ?>" 
                                       class="text-dark">
                                        <i class="ri-flask-2-line text-muted me-1"></i>
                                        <?php echo htmlspecialchars($ingrediente['insumo_nombre']); ?>
                                    </a>
                                </td>
                                <td>
                                    <strong><?php echo $ingrediente['cantidad_necesaria']; ?></strong> 
                                    <?php echo $ingrediente['unidad_medida']; ?>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?php echo $ingrediente['stock_actual']; ?> 
                                        <?php echo $ingrediente['insumo_unidad']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $suficiente ? 'success' : 'danger'; ?>-lighten text-<?php echo $suficiente ? 'success' : 'danger'; ?>">
                                        <i class="ri-<?php echo $suficiente ? 'checkbox-circle' : 'close-circle'; ?>-line"></i>
                                        <?php echo $suficiente ? 'Suficiente' : 'Insuficiente'; ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    $<?php echo number_format($ingrediente['costo_unitario'], 0, ',', '.'); ?>
                                </td>
                                <td class="text-end">
                                    <strong>$<?php echo number_format($ingrediente['costo_linea'], 0, ',', '.'); ?></strong>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Costo Total de Producción:</th>
                                <th class="text-end">
                                    <h5 class="mb-0 text-success">
                                        $<?php echo number_format($costo_produccion, 0, ',', '.'); ?>
                                    </h5>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
