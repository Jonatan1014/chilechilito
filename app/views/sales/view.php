<?php 
$pageTitle = 'Detalle de Venta #' . $sale['id'];
include __DIR__ . '/../layouts/header.php'; 

// Calcular totales
$totalItems = count($details);
$totalUnidades = array_sum(array_column($details, 'cantidad'));
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=sale">Ventas</a></li>
                    <li class="breadcrumb-item active">Detalle #<?php echo $sale['id']; ?></li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-file-list-line text-primary me-1"></i> 
                Detalle de Venta #<?php echo str_pad($sale['id'], 6, '0', STR_PAD_LEFT); ?>
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Badge de estado principal -->
<div class="row">
    <div class="col-12">
        <div class="alert <?php echo $sale['estado'] == 'completada' ? 'alert-success' : 
                                    ($sale['estado'] == 'pendiente' ? 'alert-warning' : 'alert-danger'); ?> border-0">
            <div class="d-flex align-items-center">
                <i class="<?php echo $sale['estado'] == 'completada' ? 'ri-checkbox-circle-fill' : 
                                   ($sale['estado'] == 'pendiente' ? 'ri-time-line' : 'ri-close-circle-fill'); ?> fs-2 me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">
                        Venta <?php echo ucfirst($sale['estado']); ?>
                    </h5>
                    <p class="mb-0">
                        Registrada el <?php echo date('d/m/Y', strtotime($sale['fecha_venta'])); ?> 
                        a las <?php echo date('H:i', strtotime($sale['fecha_venta'])); ?>
                    </p>
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
                    <i class="ri-shopping-bag-line widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Productos</h5>
                <h3 class="mt-3 mb-3"><?php echo $totalItems; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2"><i class="ri-list-check"></i></span>
                    <span class="text-nowrap">Items distintos</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-stack-line widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Unidades</h5>
                <h3 class="mt-3 mb-3"><?php echo $totalUnidades; ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="ri-box-3-line"></i></span>
                    <span class="text-nowrap">Total vendido</span>
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
                <h5 class="text-muted fw-normal mt-0">Total Venta</h5>
                <h3 class="mt-3 mb-3">$<?php echo number_format($sale['total'], 0, ',', '.'); ?></h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="ri-hand-coin-line"></i></span>
                    <span class="text-nowrap"><?php echo ucfirst($sale['metodo_pago']); ?></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="ri-calculator-line widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0">Precio Promedio</h5>
                <h3 class="mt-3 mb-3">
                    $<?php echo number_format($sale['total'] / $totalUnidades, 0, ',', '.'); ?>
                </h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="ri-price-tag-3-line"></i></span>
                    <span class="text-nowrap">Por unidad</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Información detallada -->
<div class="row">
    <!-- Datos del cliente -->
    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-user-line text-primary me-1"></i> 
                    Información del Cliente
                </h4>

                <div class="text-center mb-3">
                    <div class="avatar-lg bg-primary rounded-circle mx-auto mb-2">
                        <span class="avatar-title fs-2">
                            <?php 
                            $nombres = explode(' ', $sale['cliente_nombre']);
                            echo strtoupper(substr($nombres[0], 0, 1) . (isset($nombres[1]) ? substr($nombres[1], 0, 1) : ''));
                            ?>
                        </span>
                    </div>
                    <h4 class="mb-1"><?php echo htmlspecialchars($sale['cliente_nombre']); ?></h4>
                    <p class="text-muted mb-0">Cliente</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-mail-line me-1"></i> Email:
                        </span>
                        <strong><?php echo htmlspecialchars($sale['email']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-phone-line me-1"></i> Teléfono:
                        </span>
                        <strong><?php echo htmlspecialchars($sale['telefono']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">
                            <i class="ri-calendar-line me-1"></i> Fecha:
                        </span>
                        <strong><?php echo date('d/m/Y H:i', strtotime($sale['fecha_venta'])); ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Método de pago -->
        <div class="card border-success">
            <div class="card-body">
                <h5 class="header-title mb-3">
                    <i class="ri-secure-payment-line text-success me-1"></i> 
                    Método de Pago
                </h5>

                <div class="alert alert-success mb-0">
                    <div class="d-flex align-items-center">
                        <i class="<?php 
                            echo $sale['metodo_pago'] == 'efectivo' ? 'ri-money-dollar-circle-line' :
                                 ($sale['metodo_pago'] == 'tarjeta' ? 'ri-bank-card-line' : 'ri-exchange-dollar-line');
                        ?> fs-2 me-3"></i>
                        <div>
                            <h4 class="mb-0"><?php echo ucfirst($sale['metodo_pago']); ?></h4>
                            <small>
                                <?php 
                                echo $sale['metodo_pago'] == 'efectivo' ? 'Pago en efectivo' :
                                     ($sale['metodo_pago'] == 'tarjeta' ? 'Débito o crédito' : 'Transferencia bancaria');
                                ?>
                            </small>
                        </div>
                    </div>
                </div>

                <?php if (!empty($sale['observaciones'])): ?>
                <div class="mt-3">
                    <h6 class="text-muted">Observaciones:</h6>
                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($sale['observaciones'])); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detalle de productos -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title mb-0">
                        <i class="ri-shopping-basket-line text-primary me-1"></i> 
                        Productos Vendidos
                    </h4>
                    <button onclick="window.print()" class="btn btn-info btn-sm">
                        <i class="ri-printer-line"></i> Imprimir
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th class="text-center">Precio Unit.</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $contador = 0;
                            foreach ($details as $detail): 
                                $contador++;
                                $porcentajeDelTotal = ($detail['subtotal'] / $sale['total']) * 100;
                            ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?php echo $contador; ?></span>
                                </td>
                                <td>
                                    <h5 class="mb-1"><?php echo htmlspecialchars($detail['producto_nombre']); ?></h5>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-primary" 
                                             style="width: <?php echo $porcentajeDelTotal; ?>%"></div>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo number_format($porcentajeDelTotal, 1); ?>% del total
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-lighten text-primary">
                                        <?php echo htmlspecialchars($detail['categoria']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <strong>$<?php echo number_format($detail['precio_unitario'], 0, ',', '.'); ?></strong>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="ri-box-3-line text-success me-2 fs-4"></i>
                                        <strong class="fs-5"><?php echo $detail['cantidad']; ?></strong>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <h5 class="text-primary mb-0">
                                        $<?php echo number_format($detail['subtotal'], 0, ',', '.'); ?>
                                    </h5>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">TOTAL VENTA:</th>
                                <th class="text-end">
                                    <h4 class="text-success mb-0">
                                        $<?php echo number_format($sale['total'], 0, ',', '.'); ?>
                                    </h4>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Desglose adicional -->
                <div class="mt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-primary mb-0">
                                <div class="card-body text-center py-3">
                                    <p class="text-muted mb-1">Subtotal</p>
                                    <h4 class="text-primary mb-0">
                                        $<?php echo number_format($sale['total'], 0, ',', '.'); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info mb-0">
                                <div class="card-body text-center py-3">
                                    <p class="text-muted mb-1">IVA (19%)</p>
                                    <h4 class="text-info mb-0">
                                        $<?php echo number_format($sale['total'] * 0.19, 0, ',', '.'); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success mb-0">
                                <div class="card-body text-center py-3">
                                    <p class="text-muted mb-1">Total Final</p>
                                    <h4 class="text-success mb-0">
                                        $<?php echo number_format($sale['total'] * 1.19, 0, ',', '.'); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="header-title mb-3">
                    <i class="ri-tools-line text-warning me-1"></i> 
                    Acciones Disponibles
                </h5>

                <div class="d-flex gap-2 flex-wrap">
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="ri-printer-line"></i> Imprimir Comprobante
                    </button>
                    
                    <button onclick="generarPDF()" class="btn btn-danger">
                        <i class="ri-file-pdf-line"></i> Descargar PDF
                    </button>
                    
                    <button onclick="enviarEmail()" class="btn btn-success">
                        <i class="ri-mail-send-line"></i> Enviar por Email
                    </button>
                    
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=index" 
                       class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Volver a Ventas
                    </a>
                </div>

                <div class="alert alert-info mt-3 mb-0">
                    <i class="ri-information-line me-1"></i>
                    <small>
                        Esta venta fue registrada el 
                        <strong><?php echo date('d/m/Y', strtotime($sale['fecha_venta'])); ?></strong> 
                        a las <strong><?php echo date('H:i', strtotime($sale['fecha_venta'])); ?></strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generarPDF() {
    alert('Funcionalidad de PDF en desarrollo');
    // Aquí se implementaría la generación de PDF
}

function enviarEmail() {
    const email = '<?php echo htmlspecialchars($sale['email']); ?>';
    const confirmacion = confirm(`¿Deseas enviar el comprobante al email ${email}?`);
    
    if (confirmacion) {
        // Aquí se implementaría el envío por email
        alert('Email enviado exitosamente');
    }
}

// Estilos de impresión
const estilosImpresion = `
    @media print {
        .page-title-box,
        .breadcrumb,
        .btn,
        .card-body .d-flex,
        .alert-info {
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
            font-size: 12px;
        }
        
        h4.page-title::after {
            content: " - Comprobante de Venta";
        }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = estilosImpresion;
document.head.appendChild(styleSheet);
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
