<?php 
$pageTitle = 'Gestión de Clientes';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=create" class="btn btn-primary">
                    <i class="ri-add-line"></i> Nuevo Cliente
                </a>
            </div>
            <h4 class="page-title">Clientes</h4>
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
    <i class="ri-check-line me-1"></i> Cliente creado exitosamente
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Listado de Clientes</h4>
                
                <table id="customers-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>RUT</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($customer['rut']); ?></td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>">
                                    <?php echo htmlspecialchars($customer['email']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="tel:<?php echo htmlspecialchars($customer['telefono']); ?>">
                                    <?php echo htmlspecialchars($customer['telefono']); ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($customer['estado'] == 'activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=view&id=<?php echo $customer['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Ver Detalles">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=edit&id=<?php echo $customer['id']; ?>" 
                                   class="btn btn-sm btn-primary" title="Editar">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=delete&id=<?php echo $customer['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Está seguro de eliminar este cliente?')"
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
    
    $('#customers-datatable').DataTable({
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
                title: 'Clientes - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluir columna de acciones
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ri-file-pdf-line"></i> PDF',
                className: 'btn btn-sm btn-danger',
                title: 'Clientes - ChileChilito',
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
                title: 'Clientes - ChileChilito',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});
</script>
