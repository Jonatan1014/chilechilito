<?php 
$pageTitle = 'Crear Producto';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=product">Productos</a></li>
                    <li class="breadcrumb-item active">Crear Producto</li>
                </ol>
            </div>
            <h4 class="page-title">Crear Nuevo Producto</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="ri-error-warning-line me-1"></i> <?php echo $error; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Información del Producto</h4>
                <p class="text-muted font-14 mb-4">
                    Complete todos los campos requeridos (*) para crear un nuevo producto en el sistema.
                </p>

                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=product&action=create" id="productForm">
                    
                    <!-- Información Básica -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       placeholder="Ej: Salsa Picante Premium" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="categoria" name="categoria" 
                                       placeholder="Ej: Salsas" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                          placeholder="Descripción detallada del producto..."></textarea>
                                <small class="form-text text-muted">Opcional: Proporcione una descripción detallada del producto.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Precios y Stock -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio de Venta <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="precio" name="precio" 
                                           step="0.01" min="0" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock_actual" name="stock_actual" 
                                       min="0" placeholder="0" required>
                                <small class="form-text text-muted">Cantidad disponible en inventario</small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" 
                                       value="10" min="1" required>
                                <small class="form-text text-muted">Alerta cuando el stock sea menor</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="imagen" class="form-label">URL de Imagen</label>
                                <input type="text" class="form-control" id="imagen" name="imagen" 
                                       placeholder="https://ejemplo.com/imagen.jpg">
                                <small class="form-text text-muted">Opcional: URL de la imagen del producto</small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Receta -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requiere_produccion" 
                                               name="requiere_produccion" value="1">
                                        <label class="form-check-label fw-bold" for="requiere_produccion">
                                            <i class="ri-flask-line text-primary"></i> Este producto requiere producción (tiene receta)
                                        </label>
                                    </div>
                                </div>

                                <div class="card-body" id="receta-section" style="display: none;">
                                    <h5 class="card-title text-primary">
                                        <i class="ri-restaurant-line"></i> Receta del Producto
                                    </h5>
                                    <p class="card-text text-muted mb-3">
                                        Define los insumos necesarios para fabricar una unidad de este producto.
                                    </p>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="40%">Insumo</th>
                                                    <th width="20%">Cantidad</th>
                                                    <th width="20%">Unidad</th>
                                                    <th width="20%" class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ingredientes-container">
                                                <!-- Los ingredientes se agregan aquí dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-success mt-3" id="agregar-ingrediente">
                                        <i class="ri-add-circle-line"></i> Agregar Ingrediente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=index" 
                                   class="btn btn-light">
                                    <i class="ri-arrow-left-line"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line"></i> Guardar Producto
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const requiereProduccion = document.getElementById('requiere_produccion');
    const recetaSection = document.getElementById('receta-section');
    const ingredientesContainer = document.getElementById('ingredientes-container');
    const agregarBtn = document.getElementById('agregar-ingrediente');
    let ingredienteCount = 0;

    const insumos = <?php echo json_encode($insumos ?? []); ?>;

    // Mostrar/ocultar sección de receta
    requiereProduccion.addEventListener('change', function() {
        if (this.checked) {
            recetaSection.style.display = 'block';
            // Animación suave
            setTimeout(() => {
                recetaSection.style.opacity = '1';
                recetaSection.style.transform = 'translateY(0)';
            }, 10);
            
            if (ingredienteCount === 0) {
                agregarIngrediente();
            }
        } else {
            recetaSection.style.opacity = '0';
            recetaSection.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                recetaSection.style.display = 'none';
            }, 300);
        }
    });

    // Estilo inicial para animación
    recetaSection.style.transition = 'all 0.3s ease';
    recetaSection.style.opacity = '0';
    recetaSection.style.transform = 'translateY(-10px)';

    agregarBtn.addEventListener('click', agregarIngrediente);

    function agregarIngrediente() {
        ingredienteCount++;
        const tr = document.createElement('tr');
        tr.id = 'ingrediente-' + ingredienteCount;
        tr.className = 'ingrediente-row';
        
        // Animación de entrada
        tr.style.opacity = '0';
        tr.style.transform = 'translateX(-20px)';

        tr.innerHTML = `
            <td>
                <select class="form-select" name="insumos[]" required>
                    <option value="">Seleccionar insumo...</option>
                    ${insumos.map(i => `
                        <option value="${i.id}" data-stock="${i.stock_actual}" data-unidad="${i.unidad_medida}">
                            ${i.nombre} (Stock: ${i.stock_actual} ${i.unidad_medida})
                        </option>
                    `).join('')}
                </select>
            </td>
            <td>
                <input type="number" class="form-control cantidad-input" step="0.01" min="0.01" 
                       name="cantidades[${ingredienteCount}]" placeholder="0.00" required>
            </td>
            <td>
                <input type="text" class="form-control unidad-input" name="unidades[${ingredienteCount}]" 
                       placeholder="kg, litros..." readonly required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarIngrediente(${ingredienteCount})"
                        title="Eliminar ingrediente">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>
        `;

        ingredientesContainer.appendChild(tr);

        // Animación de entrada
        setTimeout(() => {
            tr.style.transition = 'all 0.3s ease';
            tr.style.opacity = '1';
            tr.style.transform = 'translateX(0)';
        }, 10);

        // Actualizar name de cantidades y autocompletar unidad
        const selectInsumo = tr.querySelector('select[name="insumos[]"]');
        const inputCantidad = tr.querySelector('.cantidad-input');
        const inputUnidad = tr.querySelector('.unidad-input');
        
        selectInsumo.addEventListener('change', function() {
            if (this.value) {
                // Actualizar names para que coincidan con el ID del insumo
                inputCantidad.name = `cantidades[${this.value}]`;
                inputUnidad.name = `unidades[${this.value}]`;
                
                // Autocompletar la unidad desde el data attribute
                const selectedOption = this.options[this.selectedIndex];
                const unidad = selectedOption.getAttribute('data-unidad');
                inputUnidad.value = unidad || '';
                
                // Resaltar la fila brevemente
                tr.style.backgroundColor = '#e7f5ff';
                setTimeout(() => {
                    tr.style.transition = 'background-color 0.5s ease';
                    tr.style.backgroundColor = '';
                }, 300);
            }
        });
    }

    window.eliminarIngrediente = function(id) {
        const elem = document.getElementById('ingrediente-' + id);
        if (elem) {
            // Animación de salida
            elem.style.transition = 'all 0.3s ease';
            elem.style.opacity = '0';
            elem.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                elem.remove();
                
                // Si no quedan ingredientes, agregar uno nuevo automáticamente
                if (ingredientesContainer.children.length === 0 && requiereProduccion.checked) {
                    agregarIngrediente();
                }
            }, 300);
        }
    };

    // Validación del formulario
    const form = document.getElementById('productForm');
    form.addEventListener('submit', function(e) {
        if (requiereProduccion.checked && ingredientesContainer.children.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un ingrediente a la receta.');
            return false;
        }
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
