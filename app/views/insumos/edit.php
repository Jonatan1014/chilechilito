<?php 
$pageTitle = 'Editar Insumo';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/chile_chilito/public/index.php?controller=insumo">Insumos</a></li>
                    <li class="breadcrumb-item active">Editar Insumo</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-edit-box-line text-primary me-1"></i> 
                Editar Insumo
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info border-info mb-3">
                    <i class="ri-information-line me-1"></i>
                    Editando: <strong><?php echo htmlspecialchars($insumo['nombre']); ?></strong>
                </div>

                <form method="POST" action="/chile_chilito/public/index.php?controller=insumo&action=update" id="editInsumoForm">
                    <input type="hidden" name="id" value="<?php echo $insumo['id']; ?>">
                    
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
                                <label for="nombre" class="form-label">Nombre del Insumo *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-flask-line"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($insumo['nombre']); ?>" 
                                           placeholder="Ej: Harina de trigo" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Nombre descriptivo del insumo</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-barcode-line"></i></span>
                                    <input type="text" class="form-control" id="sku" name="sku" 
                                           value="<?php echo htmlspecialchars($insumo['sku']); ?>" 
                                           placeholder="Ej: INS-001">
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Código único</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                          placeholder="Descripción detallada del insumo..."><?php echo htmlspecialchars($insumo['descripcion']); ?></textarea>
                            </div>
                            <small class="text-muted"><i class="ri-information-line"></i> Descripción opcional del insumo</small>
                        </div>
                    </div>

                    <!-- Clasificación -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-price-tag-3-line text-info me-1"></i>
                                Clasificación
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-folder-line"></i></span>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Dulces" <?php echo $insumo['categoria'] == 'Dulces' ? 'selected' : ''; ?>>Dulces</option>
                                        <option value="Salsas" <?php echo $insumo['categoria'] == 'Salsas' ? 'selected' : ''; ?>>Salsas</option>
                                        <option value="Especias" <?php echo $insumo['categoria'] == 'Especias' ? 'selected' : ''; ?>>Especias</option>
                                        <option value="Empaques" <?php echo $insumo['categoria'] == 'Empaques' ? 'selected' : ''; ?>>Empaques</option>
                                        <option value="Otros" <?php echo $insumo['categoria'] == 'Otros' ? 'selected' : ''; ?>>Otros</option>
                                    </select>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Tipo de insumo</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="unidad_medida" class="form-label">Unidad de Medida *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-scales-line"></i></span>
                                    <select class="form-select" id="unidad_medida" name="unidad_medida" required>
                                        <option value="unidades" <?php echo $insumo['unidad_medida'] == 'unidades' ? 'selected' : ''; ?>>Unidades</option>
                                        <option value="gramos" <?php echo $insumo['unidad_medida'] == 'gramos' ? 'selected' : ''; ?>>Gramos</option>
                                        <option value="kilogramos" <?php echo $insumo['unidad_medida'] == 'kilogramos' ? 'selected' : ''; ?>>Kilogramos</option>
                                        <option value="litros" <?php echo $insumo['unidad_medida'] == 'litros' ? 'selected' : ''; ?>>Litros</option>
                                        <option value="mililitros" <?php echo $insumo['unidad_medida'] == 'mililitros' ? 'selected' : ''; ?>>Mililitros</option>
                                    </select>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Unidad de medida</small>
                            </div>
                        </div>
                    </div>

                    <!-- Stock y Costos -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-stock-line text-success me-1"></i>
                                Stock y Costos
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="stock_actual" class="form-label">Stock Actual *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-box-3-line"></i></span>
                                    <input type="number" class="form-control" id="stock_actual" name="stock_actual" 
                                           step="0.01" value="<?php echo $insumo['stock_actual']; ?>" 
                                           placeholder="0.00" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Cantidad disponible</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="stock_minimo" class="form-label">Stock Mínimo *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-alert-line"></i></span>
                                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" 
                                           step="0.01" value="<?php echo $insumo['stock_minimo']; ?>" 
                                           placeholder="0.00" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Alerta de reposición</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="stock_maximo" class="form-label">Stock Máximo *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-bar-chart-box-line"></i></span>
                                    <input type="number" class="form-control" id="stock_maximo" name="stock_maximo" 
                                           step="0.01" value="<?php echo $insumo['stock_maximo']; ?>" 
                                           placeholder="0.00" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Capacidad máxima</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="costo_unitario" class="form-label">Costo Unitario *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="costo_unitario" name="costo_unitario" 
                                           step="0.01" value="<?php echo $insumo['costo_unitario']; ?>" 
                                           placeholder="0.00" required>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Costo por unidad</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-truck-line"></i></span>
                                    <input type="text" class="form-control" id="proveedor" name="proveedor" 
                                           value="<?php echo htmlspecialchars($insumo['proveedor']); ?>" 
                                           placeholder="Nombre del proveedor">
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Proveedor habitual</small>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración Adicional -->
                    <div class="mb-3">
                        <div class="bg-light p-2 rounded mb-3">
                            <h5 class="mb-0">
                                <i class="ri-settings-3-line text-warning me-1"></i>
                                Configuración Adicional
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-toggle-line"></i></span>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="activo" <?php echo $insumo['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo $insumo['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                        <option value="descontinuado" <?php echo $insumo['estado'] == 'descontinuado' ? 'selected' : ''; ?>>Descontinuado</option>
                                    </select>
                                </div>
                                <small class="text-muted"><i class="ri-information-line"></i> Estado del insumo</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-sticky-note-line"></i></span>
                                <textarea class="form-control" id="notas" name="notas" rows="3" 
                                          placeholder="Notas adicionales sobre el insumo..."><?php echo htmlspecialchars($insumo['notas']); ?></textarea>
                            </div>
                            <small class="text-muted"><i class="ri-information-line"></i> Notas o comentarios adicionales</small>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-end mt-4">
                        <a href="/chile_chilito/public/index.php?controller=insumo&action=index" class="btn btn-light">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i> Actualizar Insumo
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
                            <?php echo strtoupper(substr($insumo['nombre'], 0, 2)); ?>
                        </span>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Nombre:</span>
                        <strong id="preview-nombre"><?php echo htmlspecialchars($insumo['nombre']); ?></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">SKU:</span>
                        <span class="badge bg-secondary-lighten text-secondary" id="preview-sku">
                            <?php echo htmlspecialchars($insumo['sku']) ?: 'Sin SKU'; ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Categoría:</span>
                        <span class="badge bg-info-lighten text-info" id="preview-categoria">
                            <?php echo htmlspecialchars($insumo['categoria']); ?>
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Stock Actual:</span>
                        <strong id="preview-stock"><?php echo $insumo['stock_actual']; ?> <span id="preview-unidad"><?php echo $insumo['unidad_medida']; ?></span></strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Costo:</span>
                        <h5 class="mb-0 text-success" id="preview-costo">
                            $<?php echo number_format($insumo['costo_unitario'], 0, ',', '.'); ?>
                        </h5>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Estado:</span>
                        <span class="badge" id="preview-estado-badge">
                            <span id="preview-estado"><?php echo ucfirst($insumo['estado']); ?></span>
                        </span>
                    </div>
                </div>

                <!-- Barra de stock -->
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Nivel de Stock</h6>
                        <span class="text-muted" id="preview-porcentaje">
                            <?php 
                            $porcentaje = ($insumo['stock_actual'] / max($insumo['stock_minimo'], 1)) * 100;
                            echo round($porcentaje); 
                            ?>%
                        </span>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" id="preview-progress" 
                             style="width: <?php echo min($porcentaje, 100); ?>%"></div>
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
                    <i class="ri-calculator-line text-success me-1"></i>
                    Valor en Stock
                </h4>
                
                <div class="text-center mb-3">
                    <h2 class="text-success mb-0" id="preview-valor-total">
                        $<?php echo number_format($insumo['stock_actual'] * $insumo['costo_unitario'], 0, ',', '.'); ?>
                    </h2>
                    <p class="text-muted mb-0">Valor total del inventario</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Stock mínimo:</span>
                        <strong id="preview-valor-minimo">
                            $<?php echo number_format($insumo['stock_minimo'] * $insumo['costo_unitario'], 0, ',', '.'); ?>
                        </strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Stock máximo:</span>
                        <strong id="preview-valor-maximo">
                            $<?php echo number_format($insumo['stock_maximo'] * $insumo['costo_unitario'], 0, ',', '.'); ?>
                        </strong>
                    </div>
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
                    <small>Mantén actualizado el stock para evitar faltantes.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Define límites de stock para recibir alertas automáticas.</small>
                </div>
                <div class="d-flex mb-2">
                    <i class="ri-checkbox-circle-line text-success me-2 mt-1"></i>
                    <small>Registra el proveedor para facilitar las compras.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview en tiempo real
    const nombreInput = document.getElementById('nombre');
    const skuInput = document.getElementById('sku');
    const categoriaInput = document.getElementById('categoria');
    const stockActualInput = document.getElementById('stock_actual');
    const stockMinimoInput = document.getElementById('stock_minimo');
    const stockMaximoInput = document.getElementById('stock_maximo');
    const costoInput = document.getElementById('costo_unitario');
    const estadoInput = document.getElementById('estado');
    const unidadInput = document.getElementById('unidad_medida');

    function updatePreview() {
        // Actualizar nombre y avatar
        const nombre = nombreInput.value.trim() || '<?php echo htmlspecialchars($insumo['nombre']); ?>';
        document.getElementById('preview-nombre').textContent = nombre;
        document.getElementById('preview-avatar').textContent = nombre.substring(0, 2).toUpperCase();

        // Actualizar SKU
        const sku = skuInput.value.trim() || 'Sin SKU';
        document.getElementById('preview-sku').textContent = sku;

        // Actualizar categoría
        const categoria = categoriaInput.value || '<?php echo htmlspecialchars($insumo['categoria']); ?>';
        document.getElementById('preview-categoria').textContent = categoria;

        // Actualizar unidad
        const unidad = unidadInput.value || '<?php echo $insumo['unidad_medida']; ?>';
        document.getElementById('preview-unidad').textContent = unidad;

        // Actualizar stock
        const stockActual = parseFloat(stockActualInput.value) || 0;
        const stockMinimo = parseFloat(stockMinimoInput.value) || 1;
        const stockMaximo = parseFloat(stockMaximoInput.value) || 100;
        document.getElementById('preview-stock').innerHTML = stockActual + ' <span id="preview-unidad">' + unidad + '</span>';

        // Actualizar costo
        const costo = parseFloat(costoInput.value) || 0;
        document.getElementById('preview-costo').textContent = '$' + costo.toLocaleString('es-CL');

        // Actualizar estado
        const estado = estadoInput.value;
        const estadoBadge = document.getElementById('preview-estado-badge');
        document.getElementById('preview-estado').textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
        
        if (estado === 'activo') {
            estadoBadge.className = 'badge bg-success-lighten text-success';
        } else if (estado === 'inactivo') {
            estadoBadge.className = 'badge bg-secondary-lighten text-secondary';
        } else {
            estadoBadge.className = 'badge bg-danger-lighten text-danger';
        }

        // Actualizar barra de progreso
        const porcentaje = (stockActual / stockMinimo) * 100;
        document.getElementById('preview-porcentaje').textContent = Math.round(porcentaje) + '%';
        
        const progressBar = document.getElementById('preview-progress');
        progressBar.style.width = Math.min(porcentaje, 100) + '%';
        
        if (porcentaje >= 100) {
            progressBar.className = 'progress-bar bg-success';
        } else if (porcentaje >= 50) {
            progressBar.className = 'progress-bar bg-warning';
        } else {
            progressBar.className = 'progress-bar bg-danger';
        }

        // Actualizar valores calculados
        const valorTotal = stockActual * costo;
        const valorMinimo = stockMinimo * costo;
        const valorMaximo = stockMaximo * costo;

        document.getElementById('preview-valor-total').textContent = '$' + valorTotal.toLocaleString('es-CL');
        document.getElementById('preview-valor-minimo').textContent = '$' + valorMinimo.toLocaleString('es-CL');
        document.getElementById('preview-valor-maximo').textContent = '$' + valorMaximo.toLocaleString('es-CL');
    }

    // Agregar event listeners
    nombreInput.addEventListener('input', updatePreview);
    skuInput.addEventListener('input', updatePreview);
    categoriaInput.addEventListener('change', updatePreview);
    stockActualInput.addEventListener('input', updatePreview);
    stockMinimoInput.addEventListener('input', updatePreview);
    stockMaximoInput.addEventListener('input', updatePreview);
    costoInput.addEventListener('input', updatePreview);
    estadoInput.addEventListener('change', updatePreview);
    unidadInput.addEventListener('change', updatePreview);
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
