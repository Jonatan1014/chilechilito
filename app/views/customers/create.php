<?php 
$pageTitle = 'Crear Cliente';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=customer">Clientes</a></li>
                    <li class="breadcrumb-item active">Nuevo Cliente</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-user-add-line text-primary me-1"></i> Crear Nuevo Cliente
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-file-list-3-line text-primary me-1"></i> 
                    Formulario de Cliente
                </h4>
                <p class="text-muted mb-4">
                    Completa los datos del nuevo cliente. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>

                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=create" id="customerForm">
                    
                    <!-- Sección: Información Personal -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-user-line me-1"></i> Información Personal
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-user-line"></i>
                                        </span>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               placeholder="Ej: Juan" required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Nombre del cliente
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">
                                        Apellido <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-user-line"></i>
                                        </span>
                                        <input type="text" class="form-control" id="apellido" name="apellido" 
                                               placeholder="Ej: Pérez" required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Apellido del cliente
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rut" class="form-label">
                                        RUT <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-id-card-line"></i>
                                        </span>
                                        <input type="text" class="form-control" id="rut" name="rut" 
                                               placeholder="12345678-9" required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        RUT sin puntos y con guión
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">
                                        Estado <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-toggle-line"></i>
                                        </span>
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="activo" selected>Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Estado del cliente en el sistema
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Información de Contacto -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-contacts-line me-1"></i> Información de Contacto
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-mail-line"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="correo@ejemplo.com">
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Correo electrónico del cliente
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-phone-line"></i>
                                        </span>
                                        <input type="text" class="form-control" id="telefono" name="telefono" 
                                               placeholder="+56912345678">
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Número de teléfono con código de país
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-map-pin-line"></i>
                                        </span>
                                        <textarea class="form-control" id="direccion" name="direccion" rows="3" 
                                                  placeholder="Calle, número, comuna, ciudad"></textarea>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Dirección completa del cliente
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa del cliente -->
                    <div class="mb-4" id="previewSection" style="display: none;">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-eye-line me-1"></i> Vista Previa
                        </h5>
                        
                        <div class="alert alert-info border-info">
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg bg-info rounded-circle me-3">
                                    <span class="avatar-title fs-2" id="previewInitials">-</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" id="previewNombre">-</h5>
                                    <p class="mb-0">
                                        <small>
                                            <i class="ri-id-card-line"></i> 
                                            <span id="previewRut">-</span>
                                            <span class="mx-2">|</span>
                                            <i class="ri-mail-line"></i> 
                                            <span id="previewEmail">-</span>
                                        </small>
                                    </p>
                                </div>
                                <div>
                                    <span class="badge bg-success fs-5" id="previewEstado">Activo</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-end">
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=customer&action=index" 
                           class="btn btn-light me-2">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel lateral de ayuda -->
    <div class="col-lg-4" style="display: none;">
        <div class="card border-info">
            <div class="card-body">
                <h5 class="header-title mb-3">
                    <i class="ri-question-line text-info me-1"></i> 
                    Ayuda
                </h5>
                
                <div class="alert alert-info mb-2">
                    <small>
                        <i class="ri-checkbox-circle-line me-1"></i>
                        El RUT debe ingresarse sin puntos y con guión
                    </small>
                </div>
                
                <div class="alert alert-success mb-2">
                    <small>
                        <i class="ri-phone-line me-1"></i>
                        El teléfono debe incluir el código de país (+56)
                    </small>
                </div>
                
                <div class="alert alert-warning mb-0">
                    <small>
                        <i class="ri-mail-line me-1"></i>
                        Verifica que el email sea correcto para futuras comunicaciones
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vista previa en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('customerForm');
    const previewSection = document.getElementById('previewSection');
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    const rutInput = document.getElementById('rut');
    const emailInput = document.getElementById('email');
    const estadoSelect = document.getElementById('estado');

    // Actualizar vista previa
    function updatePreview() {
        const nombre = nombreInput.value.trim();
        const apellido = apellidoInput.value.trim();
        const rut = rutInput.value.trim();
        const email = emailInput.value.trim();
        const estado = estadoSelect.value;

        if (nombre && apellido) {
            previewSection.style.display = 'block';
            
            // Iniciales
            const initials = (nombre[0] + apellido[0]).toUpperCase();
            document.getElementById('previewInitials').textContent = initials;
            
            // Nombre completo
            document.getElementById('previewNombre').textContent = `${nombre} ${apellido}`;
            
            // RUT
            document.getElementById('previewRut').textContent = rut || 'Sin RUT';
            
            // Email
            document.getElementById('previewEmail').textContent = email || 'Sin email';
            
            // Estado
            const estadoBadge = document.getElementById('previewEstado');
            estadoBadge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
            estadoBadge.className = estado === 'activo' ? 'badge bg-success fs-5' : 'badge bg-danger fs-5';
            
            // Animación
            previewSection.style.opacity = '0';
            setTimeout(() => {
                previewSection.style.transition = 'opacity 0.3s';
                previewSection.style.opacity = '1';
            }, 10);
        } else {
            previewSection.style.display = 'none';
        }
    }

    // Event listeners
    nombreInput.addEventListener('input', updatePreview);
    apellidoInput.addEventListener('input', updatePreview);
    rutInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    estadoSelect.addEventListener('change', updatePreview);

    // Validación de RUT
    rutInput.addEventListener('blur', function() {
        let rut = this.value.replace(/\./g, '');
        if (rut && !rut.includes('-') && rut.length > 1) {
            rut = rut.slice(0, -1) + '-' + rut.slice(-1);
            this.value = rut;
            updatePreview();
        }
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        const nombre = nombreInput.value.trim();
        const apellido = apellidoInput.value.trim();
        const rut = rutInput.value.trim();

        if (!nombre || !apellido || !rut) {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios');
            return false;
        }

        // Validar formato RUT básico
        if (!rut.includes('-')) {
            e.preventDefault();
            alert('El RUT debe incluir el guión (Ej: 12345678-9)');
            rutInput.focus();
            return false;
        }
    });

    // Auto-capitalizar nombres
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
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
