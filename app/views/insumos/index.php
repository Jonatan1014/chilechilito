<?php 
$pageTitle = 'Gestión de Insumos';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <div class="btn-group">
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=stockBajo" class="btn btn-warning">
                        <i class="ri-alarm-warning-line"></i> Stock Bajo
                    </a>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=necesidadesCompra" class="btn btn-info">
                        <i class="ri-shopping-cart-line"></i> Necesidades de Compra
                    </a>
                    <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                    <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=create" class="btn btn-primary">
                        <i class="ri-add-line"></i> Nuevo Insumo
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <h4 class="page-title">Insumos</h4>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Listado de Insumos</h4>
                
                <table id="insumos-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Unidad</th>
                            <th>Costo Unit.</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($insumos as $insumo): 
                            $stockBajo = $insumo['stock_actual'] <= $insumo['stock_minimo'];
                        ?>
                        <tr class="<?php echo $stockBajo ? 'table-warning' : ''; ?>">
                            <td>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($insumo['sku']); ?></span>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($insumo['nombre']); ?></strong>
                                <?php if ($stockBajo): ?>
                                    <i class="ri-alarm-warning-line text-danger ms-1" title="Stock bajo"></i>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($insumo['categoria']); ?></td>
                            <td>
                                <span class="badge <?php echo $stockBajo ? 'bg-danger' : 'bg-success'; ?>">
                                    <?php echo number_format($insumo['stock_actual'], 2); ?>
                                </span>
                            </td>
                            <td><?php echo number_format($insumo['stock_minimo'], 2); ?></td>
                            <td><?php echo htmlspecialchars($insumo['unidad_medida']); ?></td>
                            <td><strong>$<?php echo number_format($insumo['costo_unitario'], 2); ?></strong></td>
                            <td><?php echo htmlspecialchars($insumo['proveedor']); ?></td>
                            <td>
                                <?php if ($insumo['estado'] == 'activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=view&id=<?php echo $insumo['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Ver Detalles">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <?php if ($_SESSION['role'] !== 'vendedor'): ?>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=edit&id=<?php echo $insumo['id']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=delete&id=<?php echo $insumo['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar este insumo?')" 
                                   title="Eliminar">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                                <?php endif; ?>
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
    
    $('#insumos-datatable').DataTable({
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        order: [[0, 'asc']], // Ordenar por SKU
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
                title: 'Insumos - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir columna de acciones
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-sm btn-danger',
                title: 'Insumos - ChileChilito',
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
                title: 'Insumos - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        rowCallback: function(row, data, index) {
            // Mantener el resaltado de stock bajo
            if ($(row).hasClass('table-warning')) {
                $(row).addClass('table-warning');
            }
        }
    });
});
</script>
