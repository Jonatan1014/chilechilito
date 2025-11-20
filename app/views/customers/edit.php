<?php 
$pageTitle = 'Editar Cliente';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=customer">Clientes</a></li>
                    <li class="breadcrumb-item active">Editar Cliente</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-user-edit-line text-primary me-1"></i> 
                Editar Cliente
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<?php if (isset($error)): ?>
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-1"></i>
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info border-info mb-3">
                    <i class="ri-information-line me-1"></i>
                    Editando: <strong><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></strong>
                </div>

                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=edit&id=<?php echo $customer['id']; ?>" id="editCustomerForm">
                    
                    <!-- Información Personal -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-user-line text-primary me-1"></i>
                                Información Personal
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-user-line"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($customer['nombre']); ?>" 
                                           placeholder="Ej: Juan" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Nombre del cliente</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-user-line"></i></span>
                                    <input type="text" class="form-control" id="apellido" name="apellido" 
                                           value="<?php echo htmlspecialchars($customer['apellido']); ?>" 
                                           placeholder="Ej: Pérez" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Apellido del cliente</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rut" class="form-label">RUT *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-id-card-line"></i></span>
                                    <input type="text" class="form-control" id="rut" name="rut" 
                                           value="<?php echo htmlspecialchars($customer['rut']); ?>" 
                                           placeholder="12345678-9" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> RUT del cliente con guión</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-toggle-line"></i></span>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="activo" <?php echo $customer['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo $customer['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Estado del cliente</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-contacts-line text-success me-1"></i>
                                Información de Contacto
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($customer['email']); ?>" 
                                           placeholder="correo@ejemplo.com">
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Correo electrónico</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                    <input type="text" class="form-control" id="telefono" name="telefono" 
                                           value="<?php echo htmlspecialchars($customer['telefono']); ?>" 
                                           placeholder="+56 9 1234 5678">
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Número de contacto</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                                <textarea class="form-control" id="direccion" name="direccion" rows="2" 
                                          placeholder="Dirección completa del cliente"><?php echo htmlspecialchars($customer['direccion']); ?></textarea>
                            </div>
                            <small class="text-muted"><i class="ri-information-line"></i> Dirección física del cliente</small>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-end mt-4">
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=index" class="btn btn-light">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar con preview -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-eye-line text-info me-1"></i>
                    Vista Previa
                </h4>

                <div class="text-center mb-3">
                    <div class="avatar-lg mx-auto mb-2" style="width: 80px; height: 80px;">
                        <span class="avatar-title bg-primary-lighten text-primary rounded-circle fs-1" id="preview-avatar">
                            <?php echo strtoupper(substr($customer['nombre'], 0, 1) . substr($customer['apellido'], 0, 1)); ?>
                        </span>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Nombre:</span>
                        <strong id="preview-nombre"><?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">RUT:</span>
                        <span class="badge bg-secondary-lighten text-secondary" id="preview-rut">
                            <?php echo htmlspecialchars($customer['rut']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Email:</span>
                        <span id="preview-email"><?php echo htmlspecialchars($customer['email']); ?></span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Teléfono:</span>
                        <span id="preview-telefono"><?php echo htmlspecialchars($customer['telefono']); ?></span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Estado:</span>
                        <span class="badge" id="preview-estado-badge">
                            <span id="preview-estado"><?php echo ucfirst($customer['estado']); ?></span>
                        </span>
                    </div>
                </div>

                <div class="alert alert-info border-info mt-3">
                    <i class="ri-information-line me-1"></i>
                    <small>Los cambios se verán reflejados después de guardar.</small>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-lightbulb-line text-warning me-1"></i>
                    Consejos Rápidos
                </h4>
                
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Verifica que el RUT esté correcto antes de guardar.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Mantén actualizada la información de contacto.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Puedes cambiar el estado del cliente según sea necesario.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview en tiempo real
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    const rutInput = document.getElementById('rut');
    const emailInput = document.getElementById('email');
    const telefonoInput = document.getElementById('telefono');
    const estadoInput = document.getElementById('estado');

    function updatePreview() {
        // Actualizar nombre y avatar
        const nombre = nombreInput.value.trim() || '<?php echo htmlspecialchars($customer['nombre']); ?>';
        const apellido = apellidoInput.value.trim() || '<?php echo htmlspecialchars($customer['apellido']); ?>';
        const nombreCompleto = nombre + ' ' + apellido;
        
        document.getElementById('preview-nombre').textContent = nombreCompleto;
        
        // Actualizar avatar con iniciales
        const iniciales = nombre.charAt(0).toUpperCase() + apellido.charAt(0).toUpperCase();
        document.getElementById('preview-avatar').textContent = iniciales;

        // Actualizar RUT
        const rut = rutInput.value.trim() || '<?php echo htmlspecialchars($customer['rut']); ?>';
        document.getElementById('preview-rut').textContent = rut;

        // Actualizar email
        const email = emailInput.value.trim() || '<?php echo htmlspecialchars($customer['email']); ?>';
        document.getElementById('preview-email').textContent = email;

        // Actualizar teléfono
        const telefono = telefonoInput.value.trim() || '<?php echo htmlspecialchars($customer['telefono']); ?>';
        document.getElementById('preview-telefono').textContent = telefono;

        // Actualizar estado
        const estado = estadoInput.value;
        const estadoBadge = document.getElementById('preview-estado-badge');
        document.getElementById('preview-estado').textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
        
        if (estado === 'activo') {
            estadoBadge.className = 'badge bg-success-lighten text-success';
        } else {
            estadoBadge.className = 'badge bg-secondary-lighten text-secondary';
        }
    }

    // Auto-format RUT
    rutInput.addEventListener('blur', function() {
        let rut = this.value.trim();
        if (rut && !rut.includes('-') && rut.length >= 2) {
            this.value = rut.slice(0, -1) + '-' + rut.slice(-1);
            updatePreview();
        }
    });

    // Auto-capitalize nombres
    nombreInput.addEventListener('blur', function() {
        this.value = this.value.split(' ').map(word => 
            word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        ).join(' ');
        updatePreview();
    });

    apellidoInput.addEventListener('blur', function() {
        this.value = this.value.split(' ').map(word => 
            word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        ).join(' ');
        updatePreview();
    });

    // Agregar event listeners
    nombreInput.addEventListener('input', updatePreview);
    apellidoInput.addEventListener('input', updatePreview);
    rutInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    telefonoInput.addEventListener('input', updatePreview);
    estadoInput.addEventListener('change', updatePreview);
});
</script>
