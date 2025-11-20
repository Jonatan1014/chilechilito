<?php 
$pageTitle = 'Reporte de Ventas';
include __DIR__ . '/../layouts/header.php'; 

$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-d');
$metodo_pago_filtro = $_GET['metodo_pago'] ?? '';
$estado_filtro = $_GET['estado'] ?? '';
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=sale">Ventas</a></li>
                    <li class="breadcrumb-item active">Reportes</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-line-chart-line text-primary me-1"></i> Reporte de Ventas
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Filtros -->
<div class="row">
    <div class="col-12">
        <div class="card bg-primary">
            <div class="card-body">
                <h4 class="header-title text-white mb-3">
                    <i class="ri-filter-3-line me-1"></i> 
                    Filtros de Búsqueda
                </h4>

                <form method="GET" action="<?php echo APP_URL; ?>/public/index.php" id="filterForm">
                    <input type="hidden" name="controller" value="sale">
                    <input type="hidden" name="action" value="report">
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label text-white">Fecha Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?php echo $start_date; ?>" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="end_date" class="form-label text-white">Fecha Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?php echo $end_date; ?>" required>
                        </div>

                        <div class="col-md-2">
                            <label for="metodo_pago" class="form-label text-white">Método de Pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago">
                                <option value="">Todos</option>
                                <option value="efectivo" <?php echo $metodo_pago_filtro == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                                <option value="tarjeta" <?php echo $metodo_pago_filtro == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta</option>
                                <option value="transferencia" <?php echo $metodo_pago_filtro == 'transferencia' ? 'selected' : ''; ?>>Transferencia</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="estado" class="form-label text-white">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="completada" <?php echo $estado_filtro == 'completada' ? 'selected' : ''; ?>>Completada</option>
                                <option value="pendiente" <?php echo $estado_filtro == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="cancelada" <?php echo $estado_filtro == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label text-white">&nbsp;</label>
                            <button type="submit" class="btn btn-light w-100">
                                <i class="ri-search-line"></i> Generar Reporte
                            </button>
                        </div>
                    </div>

                    <!-- Filtros rápidos -->
                    <div class="mt-3">
                        <label class="form-label text-white mb-2">Períodos Rápidos:</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('hoy')">
                                <i class="ri-calendar-line"></i> Hoy
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('ayer')">
                                <i class="ri-calendar-2-line"></i> Ayer
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('semana')">
                                <i class="ri-calendar-check-line"></i> Esta Semana
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('mes')">
                                <i class="ri-calendar-event-line"></i> Este Mes
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('trimestre')">
                                <i class="ri-calendar-todo-line"></i> Trimestre
                            </button>
                            <button type="button" class="btn btn-outline-light btn-sm" onclick="setRangoFechas('anio')">
                                <i class="ri-calendar-2-fill"></i> Este Año
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (count($sales) > 0): 
    $total_ventas = count($sales);
    $monto_total = array_sum(array_column($sales, 'total'));
    $promedio = $monto_total / $total_ventas;
    
    // Calcular estadísticas adicionales
    $ventas_efectivo = array_filter($sales, fn($s) => $s['metodo_pago'] == 'efectivo');
    $ventas_tarjeta = array_filter($sales, fn($s) => $s['metodo_pago'] == 'tarjeta');
    $ventas_transferencia = array_filter($sales, fn($s) => $s['metodo_pago'] == 'transferencia');
    
    $monto_efectivo = array_sum(array_column($ventas_efectivo, 'total'));
    $monto_tarjeta = array_sum(array_column($ventas_tarjeta, 'total'));
    $monto_transferencia = array_sum(array_column($ventas_transferencia, 'total'));
    
    $venta_mayor = max(array_column($sales, 'total'));
    $venta_menor = min(array_column($sales, 'total'));
?>

<!-- Resumen Estadístico -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-shopping-bag-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Total Ventas</h5>
                <h3 class="mt-3 mb-3"><?php echo $total_ventas; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-calendar-line"></i></span>
                    <span class="text-nowrap">
                        <?php 
                        $dias = (strtotime($end_date) - strtotime($start_date)) / 86400 + 1;
                        echo round($dias) . ' días';
                        ?>
                    </span>
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
                <h5 class="text-muted fw-normal mt-0">Monto Total</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($monto_total, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i></span>
                    <span class="text-nowrap">Ingresos del período</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-price-tag-3-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Ticket Promedio</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($promedio, 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-calculator-line"></i></span>
                    <span class="text-nowrap">Por venta</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-line-chart-line widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Venta Diaria</h5>
                <h3 class="mt-3 mb-3">
                    $<?php echo number_format($monto_total / max($dias, 1), 0, ',', '.'); ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-calendar-check-line"></i></span>
                    <span class="text-nowrap">Promedio diario</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Análisis por Método de Pago -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-secure-payment-line text-primary me-1"></i> 
                    Distribución por Método de Pago
                </h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-success mb-2">
                            <div class="card-body text-center py-3">
                                <i class="ri-money-dollar-circle-line text-success fs-2"></i>
                                <h6 class="text-muted mt-2 mb-1">Efectivo</h6>
                                <h4 class="text-success mb-0">
                                    $<?php echo number_format($monto_efectivo, 0, ',', '.'); ?>
                                </h4>
                                <small class="text-muted"><?php echo count($ventas_efectivo); ?> ventas</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-primary mb-2">
                            <div class="card-body text-center py-3">
                                <i class="ri-bank-card-line text-primary fs-2"></i>
                                <h6 class="text-muted mt-2 mb-1">Tarjeta</h6>
                                <h4 class="text-primary mb-0">
                                    $<?php echo number_format($monto_tarjeta, 0, ',', '.'); ?>
                                </h4>
                                <small class="text-muted"><?php echo count($ventas_tarjeta); ?> ventas</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-info mb-2">
                            <div class="card-body text-center py-3">
                                <i class="ri-exchange-dollar-line text-info fs-2"></i>
                                <h6 class="text-muted mt-2 mb-1">Transferencia</h6>
                                <h4 class="text-info mb-0">
                                    $<?php echo number_format($monto_transferencia, 0, ',', '.'); ?>
                                </h4>
                                <small class="text-muted"><?php echo count($ventas_transferencia); ?> ventas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-warning">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-bar-chart-box-line text-warning me-1"></i> 
                    Análisis de Ventas
                </h4>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span>
                            <i class="ri-arrow-up-circle-line text-success me-1"></i>
                            Venta más alta:
                        </span>
                        <strong class="text-success">
                            $<?php echo number_format($venta_mayor, 0, ',', '.'); ?>
                        </strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span>
                            <i class="ri-arrow-down-circle-line text-danger me-1"></i>
                            Venta más baja:
                        </span>
                        <strong class="text-danger">
                            $<?php echo number_format($venta_menor, 0, ',', '.'); ?>
                        </strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span>
                            <i class="ri-percent-line text-info me-1"></i>
                            Ventas por día:
                        </span>
                        <strong class="text-info">
                            <?php echo number_format($total_ventas / max($dias, 1), 1); ?> ventas/día
                        </strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span>
                            <i class="ri-calendar-check-line text-primary me-1"></i>
                            Período analizado:
                        </span>
                        <strong class="text-primary">
                            <?php echo round($dias); ?> días
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de ventas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="header-title mb-0">
                            <i class="ri-list-check text-primary me-1"></i> 
                            Detalle de Ventas
                        </h4>
                        <p class="text-muted mb-0">
                            Listado completo de transacciones del período
                        </p>
                    </div>
                    <div>
                        <button onclick="window.print()" class="btn btn-info btn-sm me-1">
                            <i class="ri-printer-line"></i> Imprimir
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="reportTable" class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha & Hora</th>
                                <th>Cliente</th>
                                <th>Método de Pago</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Estado</th>
                                <th width="100" class="no-print">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-dark">
                                        #<?php echo str_pad($sale['id'], 6, '0', STR_PAD_LEFT); ?>
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?php echo date('d/m/Y', strtotime($sale['fecha_venta'])); ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="ri-time-line"></i> 
                                            <?php echo date('H:i', strtotime($sale['fecha_venta'])); ?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="mb-0"><?php echo htmlspecialchars($sale['cliente_nombre']); ?></h5>
                                    <small class="text-muted">
                                        <i class="ri-user-line"></i> 
                                        Cliente
                                    </small>
                                </td>
                                <td>
                                    <span class="badge <?php 
                                        echo $sale['metodo_pago'] == 'efectivo' ? 'bg-success-lighten text-success' :
                                             ($sale['metodo_pago'] == 'tarjeta' ? 'bg-primary-lighten text-primary' : 'bg-info-lighten text-info');
                                    ?>">
                                        <i class="<?php 
                                            echo $sale['metodo_pago'] == 'efectivo' ? 'ri-money-dollar-circle-line' :
                                                 ($sale['metodo_pago'] == 'tarjeta' ? 'ri-bank-card-line' : 'ri-exchange-dollar-line');
                                        ?>"></i>
                                        <?php echo ucfirst($sale['metodo_pago']); ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <h5 class="text-success mb-0">
                                        $<?php echo number_format($sale['total'], 0, ',', '.'); ?>
                                    </h5>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?php 
                                        echo $sale['estado'] == 'completada' ? 'bg-success' :
                                             ($sale['estado'] == 'pendiente' ? 'bg-warning' : 'bg-danger');
                                    ?>">
                                        <i class="<?php 
                                            echo $sale['estado'] == 'completada' ? 'ri-checkbox-circle-line' :
                                                 ($sale['estado'] == 'pendiente' ? 'ri-time-line' : 'ri-close-circle-line');
                                        ?>"></i>
                                        <?php echo ucfirst($sale['estado']); ?>
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=view&id=<?php echo $sale['id']; ?>" 
                                       class="btn btn-info btn-sm"
                                       title="Ver detalle">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">TOTAL PERÍODO:</th>
                                <th class="text-end">
                                    <h4 class="text-success mb-0">
                                        $<?php echo number_format($monto_total, 0, ',', '.'); ?>
                                    </h4>
                                </th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Sin resultados -->
<div class="row">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="ri-file-search-line text-warning" style="font-size: 72px;"></i>
                </div>
                <h3 class="text-warning mb-3">Sin Resultados</h3>
                <p class="text-muted fs-5 mb-4">
                    No se encontraron ventas en el rango de fechas seleccionado
                    <?php if ($metodo_pago_filtro): ?>
                        <br>con método de pago: <strong><?php echo ucfirst($metodo_pago_filtro); ?></strong>
                    <?php endif; ?>
                    <?php if ($estado_filtro): ?>
                        <br>con estado: <strong><?php echo ucfirst($estado_filtro); ?></strong>
                    <?php endif; ?>
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-warning" onclick="limpiarFiltros()">
                        <i class="ri-refresh-line"></i> Limpiar Filtros
                    </button>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=index" 
                       class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Volver a Ventas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- DataTables & Scripts -->
<script>
$(document).ready(function() {
    <?php if (count($sales) > 0): ?>
    $('#reportTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        order: [[0, 'desc']], // Ordenar por ID descendente
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="ri-file-excel-line"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Reporte de Ventas - <?php echo date('d/m/Y'); ?>',
                exportOptions: {
                    columns: ':not(.no-print)'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Reporte de Ventas',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: ':not(.no-print)'
                }
            },
            {
                extend: 'print',
                text: '<i class="ri-printer-line"></i> Imprimir',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: ':not(.no-print)'
                }
            },
            {
                extend: 'copy',
                text: '<i class="ri-file-copy-line"></i> Copiar',
                className: 'btn btn-secondary btn-sm',
                exportOptions: {
                    columns: ':not(.no-print)'
                }
            }
        ],
        responsive: true
    });
    <?php endif; ?>
});

// Funciones de filtros rápidos
function setRangoFechas(periodo) {
    const hoy = new Date();
    let inicio, fin;
    
    switch(periodo) {
        case 'hoy':
            inicio = fin = hoy;
            break;
        case 'ayer':
            inicio = fin = new Date(hoy.setDate(hoy.getDate() - 1));
            break;
        case 'semana':
            inicio = new Date(hoy.setDate(hoy.getDate() - hoy.getDay()));
            fin = new Date();
            break;
        case 'mes':
            inicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            fin = new Date();
            break;
        case 'trimestre':
            const mesActual = hoy.getMonth();
            const inicioTrimestre = Math.floor(mesActual / 3) * 3;
            inicio = new Date(hoy.getFullYear(), inicioTrimestre, 1);
            fin = new Date();
            break;
        case 'anio':
            inicio = new Date(hoy.getFullYear(), 0, 1);
            fin = new Date();
            break;
    }
    
    document.getElementById('start_date').value = formatDate(inicio);
    document.getElementById('end_date').value = formatDate(fin);
    document.getElementById('filterForm').submit();
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function limpiarFiltros() {
    document.getElementById('metodo_pago').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('filterForm').submit();
}
</script>

<style>
@media print {
    .no-print, .btn, .page-title-box, .breadcrumb, .card:has(.bg-primary) {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        page-break-inside: avoid;
    }
    
    body {
        background: white !important;
    }
    
    .table {
        font-size: 11px;
    }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
