<?php 
$pageTitle = 'Nueva Producción';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                            href="<?php echo APP_URL; ?>/public/index.php?controller=production">Producción</a></li>
                    <li class="breadcrumb-item active">Nueva Producción</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-add-circle-line text-primary me-1"></i> Nueva Producción
            </h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">
                    <i class="ri-file-list-3-line text-primary me-1"></i>
                    Formulario de Producción
                </h4>
                <p class="text-muted mb-4">
                    Completa los datos para registrar una nueva producción. El sistema verificará automáticamente la
                    disponibilidad de insumos.
                </p>

                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=production&action=store"
                    id="formProduccion">

                    <!-- Sección: Información Básica -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-information-line me-1"></i> Información Básica
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="producto_id" class="form-label">
                                        Producto a Producir <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2" id="producto_id" name="producto_id"
                                        data-toggle="select2" onchange="verificarDisponibilidad()">

                                        <option value="">-- Seleccionar Producto --</option>
                                        <?php foreach ($productos as $producto): ?>
                                        <option value="<?php echo $producto['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                            data-stock="<?php echo $producto['stock_actual']; ?>"
                                            data-categoria="<?php echo htmlspecialchars($producto['categoria']); ?>">
                                            <?php echo htmlspecialchars($producto['nombre']); ?>
                                            - Stock: <?php echo $producto['stock_actual']; ?> unidades
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i>
                                        Selecciona el producto que deseas producir
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad" class="form-label">
                                        Cantidad a Producir <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" id="cantidad" name="cantidad" min="1" step="1" required
                                            class="form-control" placeholder="0" onchange="verificarDisponibilidad()">
                                        <span class="input-group-text">unidades</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="ri-box-3-line"></i>
                                        Cantidad de unidades a producir en este lote
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Info del producto seleccionado -->
                        <div id="productoInfo" style="display: none;">
                            <div class="alert alert-info border-info">
                                <div class="d-flex align-items-center">
                                    <i class="ri-box-3-line fs-3 me-3"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1" id="infoNombre">-</h5>
                                        <p class="mb-0">
                                            <span class="badge bg-primary me-2" id="infoCategoria">-</span>
                                            <span>Stock actual: <strong id="infoStock">-</strong> unidades</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Notas -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-file-text-line me-1"></i> Notas y Observaciones
                        </h5>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas de Producción (opcional)</label>
                            <textarea id="notas" name="notas" rows="3" class="form-control"
                                placeholder="Agrega notas relevantes sobre esta producción: observaciones, responsable, turno, etc."></textarea>
                            <small class="text-muted">
                                <i class="ri-information-line"></i>
                                Información adicional sobre el lote de producción
                            </small>
                        </div>
                    </div>

                    <!-- Panel de verificación de insumos -->
                    <div id="verificacion" style="display: none;">
                        <div class="mb-4">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                                <i class="ri-checkbox-circle-line me-1"></i> Verificación de Insumos
                            </h5>

                            <div id="verificacion-content">
                                <!-- Contenido dinámico -->
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-end">
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=production&action=index"
                            class="btn btn-light me-2">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" id="btnSubmit" class="btn btn-primary" disabled>
                            <i class="ri-play-circle-line"></i> Iniciar Producción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let verificacionTimeout;

// Actualizar información del producto seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const productoSelect = document.getElementById('producto_id');

    productoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const productoInfo = document.getElementById('productoInfo');

        if (this.value) {
            document.getElementById('infoNombre').textContent = selectedOption.dataset.nombre;
            document.getElementById('infoCategoria').textContent = selectedOption.dataset.categoria ||
                'Sin categoría';
            document.getElementById('infoStock').textContent = selectedOption.dataset.stock;
            productoInfo.style.display = 'block';

            // Animación suave
            productoInfo.style.opacity = '0';
            setTimeout(() => {
                productoInfo.style.transition = 'opacity 0.3s';
                productoInfo.style.opacity = '1';
            }, 10);
        } else {
            productoInfo.style.display = 'none';
        }
    });
});

function verificarDisponibilidad() {
    clearTimeout(verificacionTimeout);

    const productoId = document.getElementById('producto_id').value;
    const cantidad = document.getElementById('cantidad').value;
    const verificacionDiv = document.getElementById('verificacion');
    const verificacionContent = document.getElementById('verificacion-content');
    const btnSubmit = document.getElementById('btnSubmit');

    if (!productoId || !cantidad || cantidad <= 0) {
        verificacionDiv.style.display = 'none';
        btnSubmit.disabled = true;
        return;
    }

    // Mostrar loading
    verificacionDiv.style.display = 'block';
    verificacionContent.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Verificando...</span>
            </div>
            <p class="mt-2 text-muted">Verificando disponibilidad de insumos...</p>
        </div>
    `;

    verificacionTimeout = setTimeout(() => {
        fetch(
                `<?php echo APP_URL; ?>/public/index.php?controller=production&action=verificarDisponibilidad&producto_id=${productoId}&cantidad=${cantidad}`)
            .then(response => response.json())
            .then(data => {
                if (data.disponible) {
                    // Calcular totales
                    const costoTotal = data.receta.reduce((sum, ing) => sum + (ing.costo_linea * cantidad),
                        0);
                    const costoUnitario = costoTotal / cantidad;
                    const stockRestante = data.receta.map(ing => ({
                        nombre: ing.insumo_nombre,
                        restante: ing.stock_actual - (ing.cantidad_necesaria * cantidad),
                        unidad: ing.unidad_medida
                    }));

                    verificacionContent.innerHTML = `
                        <!-- Alerta de éxito -->
                        <div class="alert alert-success border-success mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ri-checkbox-circle-fill fs-3 me-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">¡Insumos Disponibles!</h5>
                                    <p class="mb-0">Todos los insumos necesarios están disponibles. Puedes proceder con la producción.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de costos -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Costo Total</h6>
                                        <h3 class="text-primary mb-0">$${costoTotal.toLocaleString('es-CL', {minimumFractionDigits: 2})}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Costo Unitario</h6>
                                        <h3 class="text-success mb-0">$${costoUnitario.toLocaleString('es-CL', {minimumFractionDigits: 2})}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Unidades</h6>
                                        <h3 class="text-info mb-0">${cantidad}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de insumos -->
                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Insumo</th>
                                        <th>Necesario</th>
                                        <th>Disponible</th>
                                        <th>Después de Producción</th>
                                        <th>Costo</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.receta.map((ing, index) => {
                                        const necesario = ing.cantidad_necesaria * cantidad;
                                        const restante = ing.stock_actual - necesario;
                                        const porcentajeRestante = (restante / ing.stock_actual) * 100;
                                        const costoLinea = ing.costo_linea * cantidad;
                                        
                                        return `
                                        <tr>
                                            <td>
                                                <strong>${ing.insumo_nombre}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="ri-barcode-line"></i> ${ing.sku || 'N/A'}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-lighten text-warning fs-6">
                                                    ${necesario.toFixed(2)} ${ing.unidad_medida}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                    <strong>${ing.stock_actual.toFixed(2)}</strong>
                                                </div>
                                                <small class="text-muted">${ing.unidad_medida}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar ${porcentajeRestante < 30 ? 'bg-danger' : porcentajeRestante < 60 ? 'bg-warning' : 'bg-info'}" 
                                                                 style="width: ${Math.max(porcentajeRestante, 5)}%"></div>
                                                        </div>
                                                    </div>
                                                    <strong class="${restante < ing.stock_minimo ? 'text-danger' : 'text-info'}">
                                                        ${restante.toFixed(2)}
                                                    </strong>
                                                </div>
                                                <small class="text-muted">${ing.unidad_medida}</small>
                                            </td>
                                            <td>
                                                <strong class="text-primary">$${costoLinea.toLocaleString('es-CL', {minimumFractionDigits: 2})}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    <i class="ri-check-line"></i> OK
                                                </span>
                                            </td>
                                        </tr>
                                    `;
                                    }).join('')}
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">TOTAL:</th>
                                        <th><h5 class="text-primary mb-0">$${costoTotal.toLocaleString('es-CL', {minimumFractionDigits: 2})}</h5></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Advertencias de stock bajo -->
                        ${stockRestante.some(s => s.restante < 10) ? `
                            <div class="alert alert-warning border-warning mt-3">
                                <i class="ri-error-warning-line me-1"></i>
                                <strong>Advertencia:</strong> Algunos insumos quedarán con stock bajo después de esta producción:
                                <ul class="mb-0 mt-2">
                                    ${stockRestante.filter(s => s.restante < 10).map(s => `
                                        <li><strong>${s.nombre}:</strong> ${s.restante.toFixed(2)} ${s.unidad}</li>
                                    `).join('')}
                                </ul>
                            </div>
                        ` : ''}
                    `;
                    btnSubmit.disabled = false;
                } else {
                    verificacionContent.innerHTML = `
                        <!-- Alerta de error -->
                        <div class="alert alert-danger border-danger mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ri-error-warning-fill fs-3 me-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">¡Insumos Insuficientes!</h5>
                                    <p class="mb-0">No hay suficientes insumos para esta producción. Revisa los faltantes y considera hacer una compra.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabla de faltantes -->
                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Insumo</th>
                                        <th>Necesario</th>
                                        <th>Disponible</th>
                                        <th>Faltante</th>
                                        <th>Costo Faltante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.faltantes.map(falt => `
                                        <tr class="table-danger">
                                            <td>
                                                <strong>${falt.insumo_nombre}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="ri-building-line"></i> ${falt.proveedor || 'Sin proveedor'}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning fs-6">
                                                    ${falt.necesario.toFixed(2)} ${falt.unidad_medida}
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-danger">${falt.disponible.toFixed(2)}</strong>
                                                <small class="text-muted"> ${falt.unidad_medida}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger fs-6">
                                                    <i class="ri-alert-line"></i> 
                                                    ${falt.faltante.toFixed(2)} ${falt.unidad_medida}
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-danger">
                                                    $${(falt.faltante * (falt.costo_unitario || 0)).toLocaleString('es-CL', {minimumFractionDigits: 2})}
                                                </strong>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Acciones recomendadas -->
                        <div class="mt-3">
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=necesidadesCompra" 
                               class="btn btn-warning me-2">
                                <i class="ri-shopping-cart-line"></i> Ver Necesidades de Compra
                            </a>
                            <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=index" 
                               class="btn btn-info">
                                <i class="ri-list-check"></i> Ver Inventario de Insumos
                            </a>
                        </div>
                    `;
                    btnSubmit.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                verificacionContent.innerHTML = `
                    <div class="alert alert-danger border-danger">
                        <i class="ri-error-warning-line me-1"></i> 
                        <strong>Error:</strong> No se pudo verificar la disponibilidad de insumos. Por favor, intenta nuevamente.
                    </div>
                `;
                btnSubmit.disabled = true;
            });
    }, 500);
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>