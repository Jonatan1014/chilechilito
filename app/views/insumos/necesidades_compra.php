<?php 
$pageTitle = 'Necesidades de Compra';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo">Insumos</a></li>
                    <li class="breadcrumb-item active">Necesidades de Compra</li>
                </ol>
            </div>
            <h4 class="page-title"><i class="ri-shopping-cart-line text-primary me-1"></i> Necesidades de Compra</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Filtro de proyección -->
<div class="row">
    <div class="col-12">
        <div class="card bg-primary">
            <div class="card-body">
                <form method="GET" action="<?php echo APP_URL; ?>/public/index.php" id="proyeccionForm">
                    <input type="hidden" name="controller" value="insumo">
                    <input type="hidden" name="action" value="necesidadesCompra">
                    
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="text-white mb-0">
                                <i class="ri-calendar-line me-1"></i> Proyección de Necesidades
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-white mb-0">Período de proyección:</label>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="dias" value="7" id="dias7" 
                                           <?php echo ($dias_proyeccion == 7) ? 'checked' : ''; ?>>
                                    <label class="btn btn-outline-light btn-sm" for="dias7">7 días</label>

                                    <input type="radio" class="btn-check" name="dias" value="15" id="dias15"
                                           <?php echo ($dias_proyeccion == 15) ? 'checked' : ''; ?>>
                                    <label class="btn btn-outline-light btn-sm" for="dias15">15 días</label>

                                    <input type="radio" class="btn-check" name="dias" value="30" id="dias30"
                                           <?php echo ($dias_proyeccion == 30) ? 'checked' : ''; ?>>
                                    <label class="btn btn-outline-light btn-sm" for="dias30">30 días</label>

                                    <input type="radio" class="btn-check" name="dias" value="60" id="dias60"
                                           <?php echo ($dias_proyeccion == 60) ? 'checked' : ''; ?>>
                                    <label class="btn btn-outline-light btn-sm" for="dias60">60 días</label>
                                </div>
                                <input type="number" class="form-control form-control-sm" name="dias_custom" 
                                       placeholder="Personalizado" min="1" max="365" style="width: 120px;">
                                <button type="submit" class="btn btn-light btn-sm">
                                    <i class="ri-refresh-line"></i> Calcular
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <span class="badge bg-light text-primary fs-5">
                                <i class="ri-time-line"></i> <?php echo $dias_proyeccion; ?> días
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (empty($necesidades)): ?>
<!-- Estado sin necesidades -->
<div class="row">
    <div class="col-12">
        <div class="card border-success">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="ri-shopping-cart-line text-success" style="font-size: 72px;"></i>
                </div>
                <h3 class="text-success mb-3">¡Stock Suficiente!</h3>
                <p class="text-muted fs-5">
                    No hay necesidades urgentes de compra para los próximos <strong><?php echo $dias_proyeccion; ?> días</strong>.
                    <br>Todos los insumos tienen stock suficiente según el consumo proyectado.
                </p>
                <div class="mt-4">
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo" class="btn btn-success">
                        <i class="ri-list-check"></i> Ver Todos los Insumos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<!-- Estadísticas de necesidades -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-shopping-bag-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Insumos a Comprar</h5>
                <h3 class="mt-3 mb-3"><?php echo count($necesidades); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-shopping-cart-line"></i></span>
                    <span class="text-nowrap">Requieren reposición</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-money-dollar-circle-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Inversión Total</h5>
                <h3 class="mt-3 mb-3">
                    $<?php echo number_format(array_sum(array_column($necesidades, 'costo_estimado')), 0, ',', '.'); ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-funds-line"></i></span>
                    <span class="text-nowrap">Presupuesto requerido</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-alarm-warning-line widget-icon bg-danger-lighten text-danger"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Críticos</h5>
                <h3 class="mt-3 mb-3">
                    <?php 
                    $criticos = array_filter($necesidades, function($n) {
                        return $n['dias_stock_actual'] < 7;
                    });
                    echo count($criticos);
                    ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-danger me-2"><i class="ri-error-warning-line"></i></span>
                    <span class="text-nowrap">Stock < 7 días</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-team-line widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Proveedores</h5>
                <h3 class="mt-3 mb-3">
                    <?php 
                    $proveedores = array_unique(array_column(array_column($necesidades, 'insumo'), 'proveedor'));
                    echo count($proveedores);
                    ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-building-line"></i></span>
                    <span class="text-nowrap">A contactar</span>
                </p>
            </div>
        </div>
    </div>
</div>
            
<!-- Tabla de necesidades -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="header-title">
                            <i class="ri-file-list-3-line text-primary me-1"></i> 
                            Lista de Insumos a Comprar
                        </h4>
                        <p class="text-muted mb-0">
                            Proyección basada en consumo histórico y stock disponible
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="ri-printer-line"></i> Imprimir
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="necesidadesTable" class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Insumo</th>
                                <th>Stock Actual</th>
                                <th>Consumo Diario</th>
                                <th>Días Disponibles</th>
                                <th>Nivel Urgencia</th>
                                <th>Cantidad a Comprar</th>
                                <th>Costo Unitario</th>
                                <th>Inversión</th>
                                <th>Proveedor</th>
                                <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                                <th width="120">Acción</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Ordenar por urgencia (días de stock disponibles)
                            usort($necesidades, function($a, $b) {
                                return $a['dias_stock_actual'] <=> $b['dias_stock_actual'];
                            });
                            
                            foreach ($necesidades as $index => $necesidad): 
                                $urgencia = '';
                                $badgeUrgencia = '';
                                $iconoUrgencia = '';
                                
                                if ($necesidad['dias_stock_actual'] <= 3) {
                                    $urgencia = 'CRÍTICO';
                                    $badgeUrgencia = 'bg-danger';
                                    $iconoUrgencia = 'ri-alarm-warning-fill';
                                } elseif ($necesidad['dias_stock_actual'] <= 7) {
                                    $urgencia = 'URGENTE';
                                    $badgeUrgencia = 'bg-warning';
                                    $iconoUrgencia = 'ri-error-warning-line';
                                } else {
                                    $urgencia = 'NORMAL';
                                    $badgeUrgencia = 'bg-info';
                                    $iconoUrgencia = 'ri-information-line';
                                }
                                
                                $porcentajeStock = ($necesidad['insumo']['stock_actual'] / $necesidad['insumo']['stock_minimo']) * 100;
                            ?>
                            <tr>
                                <td>
                                    <h5 class="mb-1">
                                        <span class="badge bg-secondary">#<?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                        <?php echo htmlspecialchars($necesidad['insumo']['nombre']); ?>
                                    </h5>
                                    <small class="text-muted">
                                        <i class="ri-barcode-line"></i> SKU: 
                                        <?php echo htmlspecialchars($necesidad['insumo']['sku'] ?? 'N/A'); ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-2">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar <?php echo $porcentajeStock < 30 ? 'bg-danger' : ($porcentajeStock < 60 ? 'bg-warning' : 'bg-info'); ?>" 
                                                     style="width: <?php echo min($porcentajeStock, 100); ?>%">
                                                </div>
                                            </div>
                                        </div>
                                        <strong>
                                            <?php echo number_format($necesidad['insumo']['stock_actual'], 2); ?>
                                        </strong>
                                    </div>
                                    <small class="text-muted"><?php echo htmlspecialchars($necesidad['insumo']['unidad_medida']); ?></small>
                                </td>
                                <td>
                                    <span class="text-danger fw-bold">
                                        <i class="ri-arrow-down-line"></i>
                                        <?php echo number_format($necesidad['consumo_diario'], 2); ?>
                                    </span>
                                    <br>
                                    <small class="text-muted"><?php echo htmlspecialchars($necesidad['insumo']['unidad_medida']); ?>/día</small>
                                </td>
                                <td>
                                    <span class="badge <?php echo $necesidad['dias_stock_actual'] < 7 ? 'bg-danger' : 'bg-warning'; ?> fs-6">
                                        <i class="ri-time-line"></i> <?php echo $necesidad['dias_stock_actual']; ?> días
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $badgeUrgencia; ?>">
                                        <i class="<?php echo $iconoUrgencia; ?>"></i>
                                        <?php echo $urgencia; ?>
                                    </span>
                                </td>
                                <td>
                                    <h5 class="text-primary mb-0">
                                        <?php echo number_format($necesidad['cantidad_comprar'], 2); ?>
                                    </h5>
                                    <small class="text-muted"><?php echo htmlspecialchars($necesidad['insumo']['unidad_medida']); ?></small>
                                </td>
                                <td>
                                    $<?php echo number_format($necesidad['insumo']['costo_unitario'], 2); ?>
                                </td>
                                <td>
                                    <strong class="text-success fs-5">
                                        $<?php echo number_format($necesidad['costo_estimado'], 0, ',', '.'); ?>
                                    </strong>
                                </td>
                                <td>
                                    <i class="ri-building-line text-muted"></i>
                                    <?php echo htmlspecialchars($necesidad['insumo']['proveedor']); ?>
                                </td>
                                <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                                <td>
                                    <button class="btn btn-success btn-sm w-100" 
                                            onclick="registrarCompra(<?php echo $necesidad['insumo']['id']; ?>, 
                                                                    '<?php echo htmlspecialchars($necesidad['insumo']['nombre'], ENT_QUOTES); ?>', 
                                                                    <?php echo $necesidad['cantidad_comprar']; ?>, 
                                                                    '<?php echo htmlspecialchars($necesidad['insumo']['unidad_medida'], ENT_QUOTES); ?>',
                                                                    <?php echo $necesidad['insumo']['costo_unitario']; ?>)">
                                        <i class="ri-shopping-cart-line"></i> Comprar
                                    </button>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="7" class="text-end">TOTAL INVERSIÓN REQUERIDA:</th>
                                <th colspan="3">
                                    <h4 class="text-success mb-0">
                                        <i class="ri-money-dollar-circle-line"></i>
                                        $<?php echo number_format(array_sum(array_column($necesidades, 'costo_estimado')), 0, ',', '.'); ?>
                                    </h4>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Análisis por proveedor -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-building-line text-primary me-1"></i> 
                    Análisis por Proveedor
                </h4>
                
                <?php
                $proveedoresData = [];
                foreach ($necesidades as $necesidad) {
                    $proveedor = $necesidad['insumo']['proveedor'];
                    if (!isset($proveedoresData[$proveedor])) {
                        $proveedoresData[$proveedor] = [
                            'cantidad' => 0,
                            'inversion' => 0
                        ];
                    }
                    $proveedoresData[$proveedor]['cantidad']++;
                    $proveedoresData[$proveedor]['inversion'] += $necesidad['costo_estimado'];
                }
                
                // Ordenar por inversión descendente
                uasort($proveedoresData, function($a, $b) {
                    return $b['inversion'] <=> $a['inversion'];
                });
                ?>
                
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Proveedor</th>
                                <th class="text-center">Insumos</th>
                                <th class="text-end">Inversión</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proveedoresData as $proveedor => $data): ?>
                            <tr>
                                <td>
                                    <i class="ri-building-2-line text-muted"></i>
                                    <?php echo htmlspecialchars($proveedor); ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?php echo $data['cantidad']; ?></span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">
                                        $<?php echo number_format($data['inversion'], 0, ',', '.'); ?>
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
        <div class="card border-primary">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-lightbulb-line text-primary me-1"></i> 
                    Recomendaciones Inteligentes
                </h4>
                
                <div class="alert alert-primary mb-2">
                    <i class="ri-information-line me-1"></i>
                    <strong>Optimización de Compras:</strong> Agrupa pedidos por proveedor para reducir costos de envío.
                </div>
                
                <div class="alert alert-warning mb-2">
                    <i class="ri-alarm-warning-line me-1"></i>
                    <strong>Atención Prioritaria:</strong> <?php echo count($criticos); ?> insumos críticos requieren compra inmediata (stock < 7 días).
                </div>
                
                <div class="alert alert-success mb-2">
                    <i class="ri-calendar-check-line me-1"></i>
                    <strong>Planificación:</strong> Considera pedidos anticipados para evitar quiebres de stock.
                </div>
                
                <div class="alert alert-info mb-0">
                    <i class="ri-line-chart-line me-1"></i>
                    <strong>Proyección:</strong> El consumo se calcula basándose en las últimas producciones registradas.
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<!-- DataTables initialization -->
<script>
$(document).ready(function() {
    $('#necesidadesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        order: [[3, 'asc']], // Ordenar por días disponibles (más urgente primero)
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="ri-file-excel-line"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Necesidades de Compra - <?php echo date('d/m/Y'); ?>'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Necesidades de Compra',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            {
                extend: 'print',
                text: '<i class="ri-printer-line"></i> Imprimir',
                className: 'btn btn-info btn-sm'
            }
        ],
        responsive: true
    });
});
</script>

<!-- Modal para registrar compra -->
<div class="modal fade" id="compraModal" tabindex="-1" aria-labelledby="compraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="compraModalLabel">
                    <i class="ri-shopping-cart-line me-1"></i> Registrar Compra de Insumo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=registrarCompra" id="formCompra">
                <div class="modal-body">
                    <input type="hidden" id="insumo_id" name="insumo_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Insumo:</label>
                        <input type="text" id="insumo_nombre" readonly class="form-control-plaintext fs-5 text-primary">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad comprada: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="cantidad" name="cantidad" step="0.01" min="0.01" required 
                                           class="form-control" placeholder="0.00">
                                    <span class="input-group-text" id="unidad_medida">-</span>
                                </div>
                                <small class="text-muted">Cantidad sugerida para cubrir <?php echo $dias_proyeccion; ?> días</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="costo_total" class="form-label">Costo Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="costo_total" step="0.01" min="0" 
                                           class="form-control" placeholder="0.00" readonly>
                                </div>
                                <small class="text-muted" id="costo_info">-</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notas" class="form-label">Notas de la compra:</label>
                        <textarea id="notas" name="notas" rows="3" class="form-control" 
                                  placeholder="Número de orden, detalles del proveedor, condiciones de pago..."></textarea>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="ri-information-line me-1"></i>
                        <strong>Nota:</strong> Esta compra actualizará automáticamente el stock del insumo y registrará el movimiento en el historial.
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-check-line"></i> Registrar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let costoUnitarioActual = 0;

function registrarCompra(insumoId, nombre, cantidadSugerida, unidad, costoUnitario) {
    // Llenar datos del modal
    document.getElementById('insumo_id').value = insumoId;
    document.getElementById('insumo_nombre').value = nombre;
    document.getElementById('cantidad').value = cantidadSugerida.toFixed(2);
    document.getElementById('unidad_medida').textContent = unidad;
    
    // Guardar costo unitario para cálculos
    costoUnitarioActual = costoUnitario;
    
    // Calcular costo total inicial
    calcularCostoTotal();
    
    // Mostrar modal usando Bootstrap 5
    const modal = new bootstrap.Modal(document.getElementById('compraModal'));
    modal.show();
}

function calcularCostoTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
    const costoTotal = cantidad * costoUnitarioActual;
    
    document.getElementById('costo_total').value = costoTotal.toFixed(2);
    document.getElementById('costo_info').textContent = 
        `${cantidad.toFixed(2)} × $${costoUnitarioActual.toFixed(2)} = $${costoTotal.toFixed(2)}`;
}

// Escuchar cambios en cantidad para actualizar costo
document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('cantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', calcularCostoTotal);
    }
    
    // Validación del formulario
    const formCompra = document.getElementById('formCompra');
    if (formCompra) {
        formCompra.addEventListener('submit', function(e) {
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            if (!cantidad || cantidad <= 0) {
                e.preventDefault();
                alert('Por favor ingrese una cantidad válida mayor a 0');
                return false;
            }
        });
    }
    
    // Auto-submit para días personalizados
    const diasCustom = document.querySelector('input[name="dias_custom"]');
    if (diasCustom) {
        diasCustom.addEventListener('change', function() {
            if (this.value) {
                // Limpiar selección de radio buttons
                document.querySelectorAll('input[name="dias"]').forEach(radio => {
                    radio.checked = false;
                });
                document.getElementById('proyeccionForm').submit();
            }
        });
    }
    
    // Auto-submit para radio buttons de días
    document.querySelectorAll('input[name="dias"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Limpiar campo personalizado
            const customInput = document.querySelector('input[name="dias_custom"]');
            if (customInput) customInput.value = '';
            document.getElementById('proyeccionForm').submit();
        });
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
