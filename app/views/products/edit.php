<?php 
$pageTitle = 'Editar Producto';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=product">Productos</a></li>
                    <li class="breadcrumb-item active">Editar Producto</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-edit-box-line text-primary me-1"></i> 
                Editar Producto
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
                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" id="editProductForm">
                    
                    <!-- Información Básica -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-information-line text-primary me-1"></i>
                                Información Básica
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-shopping-bag-line"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($product['nombre']); ?>" 
                                           placeholder="Ej: Empanada de Pino" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Nombre del producto para mostrar a clientes</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-price-tag-3-line"></i></span>
                                    <input type="text" class="form-control" id="categoria" name="categoria" 
                                           value="<?php echo htmlspecialchars($product['categoria']); ?>" 
                                           placeholder="Ej: Empanadas" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Categoría del producto</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                          placeholder="Descripción detallada del producto..."><?php echo htmlspecialchars($product['descripcion'] ?? ''); ?></textarea>
                            </div>
                            <small class="text-muted"><i class="ri-information-line"></i> Descripción opcional del producto</small>
                        </div>
                    </div>

                    <!-- Precios y Stock -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-money-dollar-circle-line text-success me-1"></i>
                                Precios y Stock
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="precio" name="precio" step="1" 
                                           value="<?php echo $product['precio']; ?>" 
                                           placeholder="0" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Precio de venta unitario</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="stock_actual" class="form-label">Stock Actual *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-box-3-line"></i></span>
                                    <input type="number" class="form-control" id="stock_actual" name="stock_actual" 
                                           value="<?php echo $product['stock_actual']; ?>" 
                                           placeholder="0" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Unidades en inventario</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="stock_minimo" class="form-label">Stock Mínimo *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-alert-line"></i></span>
                                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" 
                                           value="<?php echo $product['stock_minimo']; ?>" 
                                           placeholder="0" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Alerta de reposición</small>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración Adicional -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-settings-3-line text-info me-1"></i>
                                Configuración Adicional
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="imagen" class="form-label">URL de Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-image-line"></i></span>
                                    <input type="text" class="form-control" id="imagen" name="imagen" 
                                           value="<?php echo htmlspecialchars($product['imagen'] ?? ''); ?>" 
                                           placeholder="https://...">
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> URL de la imagen del producto</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-toggle-line"></i></span>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="activo" <?php echo $product['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo $product['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Estado del producto</small>
                            </div>
                        </div>
                    </div>

            <!-- Receta del Producto -->
            <div class="mb-3">
                <div class="bg-light p-2 rounded mb-3">
                    <h5 class="mb-0">
                        <i class="ri-flask-line text-warning me-1"></i>
                        Receta del Producto
                    </h5>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="requiere_produccion" name="requiere_produccion" value="1"
                           <?php echo (isset($product['requiere_produccion']) && $product['requiere_produccion']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="requiere_produccion">
                        <i class="ri-flask-2-line me-1"></i>
                        Este producto requiere producción (tiene receta)
                    </label>
                </div>

                <div id="receta-section" class="card border-warning" style="<?php echo (isset($product['requiere_produccion']) && $product['requiere_produccion']) ? '' : 'display: none;'; ?>">
                    <div class="card-body">
                        <div class="alert alert-warning border-warning mb-3">
                            <i class="ri-information-line me-1"></i>
                            <strong>Receta del Producto:</strong> Define los insumos necesarios para fabricar una unidad de este producto.
                        </div>
                        
                        <div id="ingredientes-container">
                            <?php if (!empty($receta_actual)): ?>
                                <?php foreach ($receta_actual as $index => $ingrediente): ?>
                                <div class="ingrediente-row mb-3" id="ingrediente-<?php echo $index; ?>">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label class="form-label">Insumo</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-flask-2-line"></i></span>
                                                <select class="form-select insumo-select" name="insumos[]" required>
                                                    <option value="">Seleccionar insumo...</option>
                                                    <?php foreach ($insumos as $i): ?>
                                                    <option value="<?php echo $i['id']; ?>" <?php echo $i['id'] == $ingrediente['insumo_id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($i['nombre']); ?> (<?php echo $i['stock_actual']; ?> <?php echo $i['unidad_medida']; ?>)
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Cantidad</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-number-1"></i></span>
                                                <input type="number" class="form-control" step="0.01" min="0.01" 
                                                       name="cantidades[<?php echo $ingrediente['insumo_id']; ?>]" 
                                                       value="<?php echo $ingrediente['cantidad_necesaria']; ?>" 
                                                       placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Unidad</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-scales-line"></i></span>
                                                <input type="text" class="form-control" 
                                                       name="unidades[<?php echo $ingrediente['insumo_id']; ?>]" 
                                                       value="<?php echo htmlspecialchars($ingrediente['unidad_medida']); ?>" 
                                                       placeholder="kg, litros..." required>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger w-100" onclick="eliminarIngrediente(<?php echo $index; ?>)">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button type="button" class="btn btn-warning" id="agregar-ingrediente">
                            <i class="ri-add-line"></i> Agregar Ingrediente
                        </button>
                    </div>
                </div>
            </div>

                    <!-- Botones de acción -->
                    <div class="text-end mt-4">
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=product&action=index" class="btn btn-light">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Actualizar Producto
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

                <div class="text-center mb-3" id="preview-imagen">
                    <?php if (!empty($product['imagen'])): ?>
                    <img src="<?php echo htmlspecialchars($product['imagen']); ?>" 
                         alt="Producto" 
                         class="img-fluid rounded" 
                         style="max-height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="ri-image-line" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Nombre:</span>
                        <strong id="preview-nombre"><?php echo htmlspecialchars($product['nombre']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Categoría:</span>
                        <span class="badge bg-primary-lighten text-primary" id="preview-categoria">
                            <?php echo htmlspecialchars($product['categoria']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Precio:</span>
                        <h5 class="mb-0 text-success" id="preview-precio">
                            $<?php echo number_format($product['precio'], 0, ',', '.'); ?>
                        </h5>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Stock:</span>
                        <strong id="preview-stock"><?php echo $product['stock_actual']; ?> unidades</strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Estado:</span>
                        <span class="badge" id="preview-estado-badge">
                            <span id="preview-estado"><?php echo ucfirst($product['estado']); ?></span>
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
                    <small>Actualiza el stock después de cada producción o venta.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Define un stock mínimo para recibir alertas de reposición.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Configura una receta para calcular costos de producción.</small>
                </div>
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
    let ingredienteCount = <?php echo !empty($receta_actual) ? count($receta_actual) : 0; ?>;

    const insumos = <?php echo json_encode($insumos ?? []); ?>;

    requiereProduccion.addEventListener('change', function() {
        recetaSection.style.display = this.checked ? 'block' : 'none';
    });

    agregarBtn.addEventListener('click', agregarIngrediente);

    function agregarIngrediente() {
        ingredienteCount++;
        const div = document.createElement('div');
        div.className = 'ingrediente-row mb-3';
        div.id = 'ingrediente-' + ingredienteCount;

        div.innerHTML = `
            <div class="row g-2">
                <div class="col-md-5">
                    <label class="form-label">Insumo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-flask-2-line"></i></span>
                        <select class="form-select insumo-select" name="insumos[]" required>
                            <option value="">Seleccionar insumo...</option>
                            ${insumos.map(i => `<option value="${i.id}">${i.nombre} (${i.stock_actual} ${i.unidad_medida})</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-number-1"></i></span>
                        <input type="number" class="form-control cantidad-input" step="0.01" min="0.01" name="cantidades[]" placeholder="0.00" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-scales-line"></i></span>
                        <input type="text" class="form-control unidad-input" placeholder="kg, litros..." required>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100" onclick="eliminarIngrediente(${ingredienteCount})">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
        `;

        ingredientesContainer.appendChild(div);

        // Actualizar name de cantidades para que coincida con el ID del insumo
        const selectInsumo = div.querySelector('.insumo-select');
        const inputCantidad = div.querySelector('.cantidad-input');
        const inputUnidad = div.querySelector('.unidad-input');
        
        selectInsumo.addEventListener('change', function() {
            if (this.value) {
                inputCantidad.name = `cantidades[${this.value}]`;
                inputUnidad.name = `unidades[${this.value}]`;
            }
        });
    }

    // Agregar event listeners a los selects existentes
    document.querySelectorAll('.insumo-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('.ingrediente-row');
            const cantidadInput = row.querySelector('input[name^="cantidades"]');
            const unidadInput = row.querySelector('input[name^="unidades"]');
            
            if (this.value) {
                const oldValue = cantidadInput.value;
                const oldUnidad = unidadInput.value;
                cantidadInput.name = `cantidades[${this.value}]`;
                unidadInput.name = `unidades[${this.value}]`;
                cantidadInput.value = oldValue;
                unidadInput.value = oldUnidad;
            }
        });
    });

    window.eliminarIngrediente = function(id) {
        const elem = document.getElementById('ingrediente-' + id);
        if (elem) {
            elem.remove();
        }
    };

    // Preview en tiempo real
    const nombreInput = document.getElementById('nombre');
    const categoriaInput = document.getElementById('categoria');
    const precioInput = document.getElementById('precio');
    const stockInput = document.getElementById('stock_actual');
    const estadoInput = document.getElementById('estado');
    const imagenInput = document.getElementById('imagen');

    function updatePreview() {
        // Actualizar nombre
        const nombre = nombreInput.value.trim() || '<?php echo htmlspecialchars($product['nombre']); ?>';
        document.getElementById('preview-nombre').textContent = nombre;

        // Actualizar categoría
        const categoria = categoriaInput.value.trim() || '<?php echo htmlspecialchars($product['categoria']); ?>';
        document.getElementById('preview-categoria').textContent = categoria;

        // Actualizar precio
        const precio = parseFloat(precioInput.value) || 0;
        document.getElementById('preview-precio').textContent = '$' + precio.toLocaleString('es-CL');

        // Actualizar stock
        const stock = parseInt(stockInput.value) || 0;
        document.getElementById('preview-stock').textContent = stock + ' unidades';

        // Actualizar estado
        const estado = estadoInput.value;
        const estadoBadge = document.getElementById('preview-estado-badge');
        document.getElementById('preview-estado').textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
        
        if (estado === 'activo') {
            estadoBadge.className = 'badge bg-success-lighten text-success';
        } else {
            estadoBadge.className = 'badge bg-secondary-lighten text-secondary';
        }

        // Actualizar imagen
        const imagenUrl = imagenInput.value.trim();
        const previewImagen = document.getElementById('preview-imagen');
        if (imagenUrl) {
            previewImagen.innerHTML = `<img src="${imagenUrl}" alt="Producto" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;" onerror="this.parentElement.innerHTML='<div class=\'bg-light rounded d-flex align-items-center justify-content-center\' style=\'height: 200px;\'><i class=\'ri-image-line\' style=\'font-size: 4rem; opacity: 0.3;\'></i></div>';">`;
        } else {
            previewImagen.innerHTML = '<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;"><i class="ri-image-line" style="font-size: 4rem; opacity: 0.3;"></i></div>';
        }
    }

    // Agregar event listeners
    nombreInput.addEventListener('input', updatePreview);
    categoriaInput.addEventListener('input', updatePreview);
    precioInput.addEventListener('input', updatePreview);
    stockInput.addEventListener('input', updatePreview);
    estadoInput.addEventListener('change', updatePreview);
    imagenInput.addEventListener('input', updatePreview);
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
