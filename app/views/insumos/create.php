<?php 
$pageTitle = 'Crear Insumo';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                            href="<?php echo APP_URL; ?>/public/index.php?controller=insumo">Insumos</a></li>
                    <li class="breadcrumb-item active">Crear Insumo</li>
                </ol>
            </div>
            <h4 class="page-title">Crear Nuevo Insumo</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Información del Insumo</h4>
                <p class="text-muted font-14 mb-4">
                    Complete todos los campos requeridos (*) para registrar un nuevo insumo o materia prima en el
                    sistema.
                </p>

                <form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=store"
                    id="insumoForm">

                    <!-- Identificación -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="ri-file-info-line me-1"></i> Identificación
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Insumo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Ej: Azúcar Refinada" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU / Código</label>
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="INS-001"
                                    style="text-transform: uppercase;">
                                <small class="form-text text-muted">Código único de identificación</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Descripción detallada del insumo..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Clasificación -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="ri-price-tag-3-line me-1"></i> Clasificación
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="categoria" name="categoria"
                                    data-toggle="select2">
                                    <option value="">-- Seleccionar Categoría --</option>
                                    <option value="Dulces">🍬 Dulces</option>
                                    <option value="Salsas">🌶️ Salsas</option>
                                    <option value="Especias">🧂 Especias</option>
                                    <option value="Empaques">📦 Empaques</option>
                                    <option value="Conservantes">🧪 Conservantes</option>
                                    <option value="Otros">📋 Otros</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="unidad_medida" class="form-label">Unidad de Medida <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="unidad_medida" name="unidad_medida" required
                                    data-toggle="select2">
                                    <option value="unidades">Unidades (und)</option>
                                    <option value="gramos">Gramos (g)</option>
                                    <option value="kilogramos">Kilogramos (kg)</option>
                                    <option value="litros">Litros (L)</option>
                                    <option value="mililitros">Mililitros (ml)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Control de Stock -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="ri-bar-chart-box-line me-1"></i> Control de Stock
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="stock_actual" class="form-label">Stock Actual <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="stock_actual" name="stock_actual"
                                        step="0.01" value="0" min="0" required>
                                    <span class="input-group-text" id="unidad-actual">und</span>
                                </div>
                                <small class="form-text text-muted">Cantidad disponible actualmente</small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="stock_minimo" class="form-label">Stock Mínimo <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo"
                                        step="0.01" value="10" min="0" required>
                                    <span class="input-group-text" id="unidad-min">und</span>
                                </div>
                                <small class="form-text text-danger">⚠️ Genera alerta automática</small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="stock_maximo" class="form-label">Stock Máximo <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="stock_maximo" name="stock_maximo"
                                        step="0.01" value="100" min="0" required>
                                    <span class="input-group-text" id="unidad-max">und</span>
                                </div>
                                <small class="form-text text-muted">Capacidad máxima de almacenamiento</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información de costos -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="ri-money-dollar-circle-line me-1"></i> Costos y Proveedor
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="costo_unitario" class="form-label">Costo Unitario <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="costo_unitario" name="costo_unitario"
                                        step="0.01" value="0" min="0" required>
                                </div>
                                <small class="form-text text-muted">Precio por unidad de medida</small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <input type="text" class="form-control" id="proveedor" name="proveedor"
                                    placeholder="Nombre del proveedor">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="activo" selected>✅ Activo</option>
                                    <option value="inactivo">⏸️ Inactivo</option>
                                    <option value="descontinuado">❌ Descontinuado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3 text-uppercase bg-light p-2">
                                <i class="ri-sticky-note-line me-1"></i> Información Adicional
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="notas" class="form-label">Notas / Observaciones</label>
                                <textarea class="form-control" id="notas" name="notas" rows="3"
                                    placeholder="Notas adicionales, condiciones de almacenamiento, fechas de vencimiento, etc."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa de valores calculados -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading"><i class="ri-information-line me-1"></i> Información Calculada
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Valor Stock Actual:</strong>
                                        <p class="mb-0" id="valor-stock-actual">$0.00</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Capacidad Disponible:</strong>
                                        <p class="mb-0" id="capacidad-disponible">100 und</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Nivel de Stock:</strong>
                                        <p class="mb-0">
                                            <span class="badge bg-success" id="nivel-stock">Normal</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo APP_URL; ?>/public/index.php?controller=insumo&action=index"
                                    class="btn btn-light">
                                    <i class="ri-arrow-left-line"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line"></i> Guardar Insumo
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
    const unidadMedida = document.getElementById('unidad_medida');
    const stockActual = document.getElementById('stock_actual');
    const stockMinimo = document.getElementById('stock_minimo');
    const stockMaximo = document.getElementById('stock_maximo');
    const costoUnitario = document.getElementById('costo_unitario');
    const skuInput = document.getElementById('sku');

    // Actualizar unidades en los labels
    function actualizarUnidades() {
        const unidad = unidadMedida.options[unidadMedida.selectedIndex].text.match(/\(([^)]+)\)/)[1];
        document.getElementById('unidad-actual').textContent = unidad;
        document.getElementById('unidad-min').textContent = unidad;
        document.getElementById('unidad-max').textContent = unidad;
        calcularValores();
    }

    // Calcular valores en tiempo real
    function calcularValores() {
        const actual = parseFloat(stockActual.value) || 0;
        const minimo = parseFloat(stockMinimo.value) || 0;
        const maximo = parseFloat(stockMaximo.value) || 0;
        const costo = parseFloat(costoUnitario.value) || 0;

        // Valor del stock actual
        const valorTotal = actual * costo;
        document.getElementById('valor-stock-actual').textContent = '$' + valorTotal.toLocaleString('es-CL', {
            minimumFractionDigits: 2
        });

        // Capacidad disponible
        const capacidad = maximo - actual;
        const unidad = unidadMedida.options[unidadMedida.selectedIndex].text.match(/\(([^)]+)\)/)[1];
        document.getElementById('capacidad-disponible').textContent = capacidad.toFixed(2) + ' ' + unidad;

        // Nivel de stock
        const nivelBadge = document.getElementById('nivel-stock');
        if (actual <= minimo) {
            nivelBadge.className = 'badge bg-danger';
            nivelBadge.textContent = '⚠️ Bajo';
        } else if (actual >= maximo) {
            nivelBadge.className = 'badge bg-warning';
            nivelBadge.textContent = '📦 Lleno';
        } else {
            nivelBadge.className = 'badge bg-success';
            nivelBadge.textContent = '✅ Normal';
        }
    }

    // Auto-generar SKU basado en nombre
    const nombreInput = document.getElementById('nombre');
    nombreInput.addEventListener('blur', function() {
        if (!skuInput.value && this.value) {
            const palabras = this.value.split(' ');
            const iniciales = palabras.slice(0, 3).map(p => p.charAt(0).toUpperCase()).join('');
            const numero = Math.floor(Math.random() * 999) + 1;
            skuInput.value = 'INS-' + iniciales + '-' + numero.toString().padStart(3, '0');
        }
    });

    // Convertir SKU a mayúsculas automáticamente
    skuInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Validación de stock máximo > mínimo
    stockMaximo.addEventListener('change', function() {
        const minimo = parseFloat(stockMinimo.value) || 0;
        const maximo = parseFloat(this.value) || 0;

        if (maximo < minimo) {
            alert('El stock máximo debe ser mayor que el stock mínimo');
            this.value = minimo + 10;
        }
        calcularValores();
    });

    // Event listeners
    unidadMedida.addEventListener('change', actualizarUnidades);
    stockActual.addEventListener('input', calcularValores);
    stockMinimo.addEventListener('input', calcularValores);
    stockMaximo.addEventListener('input', calcularValores);
    costoUnitario.addEventListener('input', calcularValores);

    // Inicializar
    actualizarUnidades();
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>