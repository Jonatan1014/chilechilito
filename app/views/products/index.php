<?php 
$pageTitle = 'Gestión de Productos';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=create"
                    class="btn btn-primary">
                    <i class="ri-add-line"></i> Nuevo Producto
                </a>
            </div>
            <h4 class="page-title">Productos</h4>
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
    <i class="ri-check-line me-1"></i> Producto creado exitosamente
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Listado de Productos</h4>

                <table id="products-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($product['nombre']); ?></strong>
                            </td>
                            <td>
                                <span
                                    class="badge bg-secondary"><?php echo htmlspecialchars($product['categoria']); ?></span>
                            </td>
                            <td>$<?php echo number_format($product['precio'], 0, ',', '.'); ?></td>
                            <td>
                                <?php if ($product['stock_actual'] <= $product['stock_minimo']): ?>
                                <span class="badge bg-danger">
                                    <i class="ri-alert-line"></i> <?php echo $product['stock_actual']; ?>
                                </span>
                                <?php else: ?>
                                <span class="badge bg-success"><?php echo $product['stock_actual']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $product['stock_minimo']; ?></td>
                            <td>
                                <?php if ($product['estado'] == 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=view&id=<?php echo $product['id']; ?>"
                                    class="btn btn-sm btn-info" title="Ver Detalles">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>"
                                    class="btn btn-sm btn-primary" title="Editar">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=delete&id=<?php echo $product['id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Está seguro de eliminar este producto?')"
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
    
    $('#products-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[0, 'desc']],
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
                title: 'Productos - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir columna de acciones
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-sm btn-danger',
                title: 'Productos - ChileChilito',
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
                title: 'Productos - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});
</script>