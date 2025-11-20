<?php 
$pageTitle = 'Gestión de Ventas';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=create" class="btn btn-primary">
                    <i class="ri-add-line"></i> Nueva Venta
                </a>
            </div>
            <h4 class="page-title">Ventas</h4>
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

<?php
$msg = $_GET['msg'] ?? '';
if ($msg == 'created'): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="ri-check-line me-1"></i> Venta registrada exitosamente
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Listado de Ventas</h4>
                
                <table id="sales-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Método de Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><strong>#<?php echo $sale['id']; ?></strong></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($sale['fecha_venta'])); ?></td>
                            <td><?php echo htmlspecialchars($sale['cliente_nombre']); ?></td>
                            <td><strong>$<?php echo number_format($sale['total'], 0, ',', '.'); ?></strong></td>
                            <td>
                                <span class="badge bg-info"><?php echo ucfirst($sale['metodo_pago']); ?></span>
                            </td>
                            <td>
                                <?php if ($sale['estado'] == 'completada'): ?>
                                    <span class="badge bg-success">Completada</span>
                                <?php elseif ($sale['estado'] == 'pendiente'): ?>
                                    <span class="badge bg-warning">Pendiente</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Cancelada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=view&id=<?php echo $sale['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Ver Detalles">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=delete&id=<?php echo $sale['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Está seguro de eliminar esta venta?')"
                                   title="Eliminar">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> <!-- end row-->

<?php include __DIR__ . '/../layouts/footer.php'; ?>

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
    
    $('#sales-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[0, 'desc']], // Ordenar por ID descendente
        pageLength: 25,
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
                title: 'Ventas - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir columna de acciones
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-sm btn-danger',
                title: 'Ventas - ChileChilito',
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
                title: 'Ventas - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});
</script>
