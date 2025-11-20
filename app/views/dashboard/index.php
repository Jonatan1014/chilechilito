<?php 
$pageTitle = 'Dashboard - Métricas';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">ChileChilito</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h4 class="page-title">Dashboard de Ventas</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="ri-check-line me-1"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Métricas principales -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-calendar-line widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Ventas de Hoy">Ventas Hoy</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($todaySales['monto_total'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-shopping-cart-line"></i> <?php echo $todaySales['total_ventas']; ?></span>
                    <span class="text-nowrap">transacciones</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-calendar-check-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Ventas del Mes">Ventas del Mes</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($monthSales['monto_total'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-shopping-bag-line"></i> <?php echo $monthSales['total_ventas']; ?></span>
                    <span class="text-nowrap">transacciones</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-calendar-2-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Ventas del Año">Ventas del Año</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($yearSales['monto_total'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-line-chart-line"></i> <?php echo $yearSales['total_ventas']; ?></span>
                    <span class="text-nowrap">transacciones</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-alarm-warning-line widget-icon bg-danger-lighten text-danger"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Stock Bajo">Stock Bajo</h5>
                <h3 class="mt-3 mb-3"><?php echo count($lowStockProducts); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-danger me-2"><i class="ri-error-warning-line"></i></span>
                    <span class="text-nowrap">Requieren reposición</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y tablas -->
<div class="row">
    <!-- Ventas por día de la semana -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title">Ventas por Día de la Semana</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">Ver Reporte</a>
                            <a href="javascript:void(0);" class="dropdown-item">Exportar</a>
                        </div>
                    </div>
                </div>

                <div class="chart-content-bg">
                    <div class="row text-center">
                        <?php 
                        $totalSemana = array_sum(array_column($salesByDay, 'monto_total'));
                        $promedioDia = $totalSemana / count($salesByDay);
                        ?>
                        <div class="col-md-6">
                            <p class="text-muted mb-0 mt-3">Total Semana</p>
                            <h2 class="fw-normal mb-3">
                                <small class="mdi mdi-currency-usd text-muted" style="font-size: 18px;"></small>
                                <span><?php echo number_format($totalSemana, 0, ',', '.'); ?></span>
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0 mt-3">Promedio Diario</p>
                            <h2 class="fw-normal mb-3">
                                <small class="mdi mdi-currency-usd text-muted" style="font-size: 18px;"></small>
                                <span><?php echo number_format($promedioDia, 0, ',', '.'); ?></span>
                            </h2>
                        </div>
                    </div>
                </div>

                <div dir="ltr">
                    <div id="sales-by-day-chart" class="apex-charts" data-colors="#0acf97"></div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-sm table-centered mb-0 font-14">
                        <thead class="table-light">
                            <tr>
                                <th>Día</th>
                                <th>Transacciones</th>
                                <th>Monto Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($salesByDay as $day): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($day['nombre_dia']); ?></td>
                                <td><span class="badge bg-primary"><?php echo $day['total_ventas']; ?></span></td>
                                <td><strong>$<?php echo number_format($day['monto_total'], 0, ',', '.'); ?></strong></td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?php echo ($day['monto_total'] / $totalSemana * 100); ?>%" 
                                             aria-valuenow="<?php echo $day['monto_total']; ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="<?php echo $totalSemana; ?>">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Mejores clientes -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title">Top Clientes</h4>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer" class="btn btn-sm btn-link">Ver Todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                            <?php foreach ($topBuyers as $index => $customer): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-soft-primary">
                                                <span class="avatar-title text-primary font-20 fw-bold">
                                                    <?php echo strtoupper(substr($customer['nombre'], 0, 1)); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="my-0"><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></h5>
                                            <p class="text-muted mb-0 font-13"><?php echo $customer['total_compras']; ?> compras</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <h5 class="my-0">$<?php echo number_format($customer['monto_total'], 0, ',', '.'); ?></h5>
                                    <p class="text-muted mb-0 font-13">Total gastado</p>
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

<div class="row">
    <!-- Productos más vendidos -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title"><i class="ri-fire-line text-danger me-1"></i> Productos Más Vendidos</h4>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product" class="btn btn-sm btn-link">Ver Todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Unidades</th>
                                <th>Ventas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topSellingProducts as $index => $product): ?>
                            <tr>
                                <td><?php echo ($index + 1); ?></td>
                                <td><strong><?php echo htmlspecialchars($product['nombre']); ?></strong></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($product['categoria']); ?></span></td>
                                <td><span class="badge bg-success"><?php echo $product['total_vendido']; ?></span></td>
                                <td><?php echo $product['veces_vendido']; ?> veces</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos menos vendidos -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title"><i class="ri-arrow-down-line text-warning me-1"></i> Productos Menos Vendidos</h4>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product" class="btn btn-sm btn-link">Ver Todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Stock</th>
                                <th>Vendidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leastSellingProducts as $index => $product): ?>
                            <tr>
                                <td><?php echo ($index + 1); ?></td>
                                <td><strong><?php echo htmlspecialchars($product['nombre']); ?></strong></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($product['categoria']); ?></span></td>
                                <td><span class="badge bg-info"><?php echo $product['stock_actual']; ?></span></td>
                                <td><?php echo $product['total_vendido']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alertas de Stock Bajo -->
<?php if (count($lowStockProducts) > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="card-title text-white mb-0">
                    <i class="ri-alarm-warning-line me-1"></i> 
                    Productos con Stock Bajo (<?php echo count($lowStockProducts); ?>)
                </h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <i class="ri-error-warning-line me-2"></i>
                    <strong>¡Atención!</strong> Los siguientes productos requieren reposición urgente.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                                <th>Déficit</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lowStockProducts as $product): 
                                $deficit = $product['stock_minimo'] - $product['stock_actual'];
                            ?>
                            <tr class="table-warning">
                                <td>
                                    <strong><?php echo htmlspecialchars($product['nombre']); ?></strong>
                                    <i class="ri-alert-line text-danger ms-1"></i>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($product['categoria']); ?></span></td>
                                <td>
                                    <span class="badge bg-danger fs-6">
                                        <?php echo $product['stock_actual']; ?>
                                    </span>
                                </td>
                                <td><?php echo $product['stock_minimo']; ?></td>
                                <td><span class="text-danger fw-bold">-<?php echo $deficit; ?></span></td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="ri-pencil-line"></i> Actualizar Stock
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
<?php endif; ?>

<!-- ApexCharts -->
<script src="<?php echo APP_URL; ?>/public/assets/vendor/apexcharts/apexcharts.min.js"></script>

<script>
// Datos de ventas por día
var salesByDayData = <?php echo json_encode($salesByDay); ?>;

// Gráfico de ventas por día (ApexCharts)
var options = {
    series: [{
        name: 'Ventas',
        data: salesByDayData.map(d => d.total_ventas)
    }, {
        name: 'Monto ($)',
        data: salesByDayData.map(d => Math.round(d.monto_total / 1000)) // Dividido por 1000 para mejor visualización
    }],
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: true,
            tools: {
                download: true,
                selection: false,
                zoom: false,
                zoomin: false,
                zoomout: false,
                pan: false,
                reset: false
            }
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            dataLabels: {
                position: 'top'
            }
        },
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val;
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: salesByDayData.map(d => d.nombre_dia),
        labels: {
            style: {
                fontSize: '12px'
            }
        }
    },
    yaxis: [{
        title: {
            text: 'Cantidad de Ventas'
        }
    }, {
        opposite: true,
        title: {
            text: 'Monto (Miles de $)'
        }
    }],
    fill: {
        opacity: 1,
        colors: ['#0acf97', '#fa5c7c']
    },
    tooltip: {
        y: {
            formatter: function (val, opts) {
                if (opts.seriesIndex === 1) {
                    return '$' + (val * 1000).toLocaleString('es-CL');
                }
                return val + " ventas";
            }
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5
    },
    colors: ['#0acf97', '#fa5c7c']
};

var chart = new ApexCharts(document.querySelector("#sales-by-day-chart"), options);
chart.render();

// Animación para los widgets
document.addEventListener('DOMContentLoaded', function() {
    const widgets = document.querySelectorAll('.widget-flat');
    widgets.forEach((widget, index) => {
        setTimeout(() => {
            widget.style.opacity = '0';
            widget.style.transform = 'translateY(20px)';
            widget.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                widget.style.opacity = '1';
                widget.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
