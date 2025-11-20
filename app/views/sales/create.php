<?php 
$pageTitle = 'Nueva Venta';
include __DIR__ . '/../layouts/header.php'; 
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/public/index.php?controller=sale">Ventas</a></li>
                    <li class="breadcrumb-item active">Nueva Venta</li>
                </ol>
            </div>
            <h4 class="page-title">
                <i class="ri-shopping-cart-line text-primary me-1"></i> Nueva Venta
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

<form method="POST" action="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=create" id="saleForm">
    <div class="row">
        <!-- Formulario de venta -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">
                        <i class="ri-file-list-3-line text-primary me-1"></i> 
                        Información de la Venta
                    </h4>

                    <!-- Sección: Datos del Cliente -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-user-line me-1"></i> Cliente y Pago
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cliente_id" class="form-label">
                                        Cliente <span class="text-danger">*</span>
                                    </label>
                                        <select class="form-control select2" id="cliente_id" name="cliente_id" data-toggle="select2" required >

                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php foreach ($customers as $customer): ?>
                                        <option value="<?php echo $customer['id']; ?>"
                                                data-nombre="<?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?>"
                                                data-email="<?php echo htmlspecialchars($customer['email']); ?>"
                                                data-telefono="<?php echo htmlspecialchars($customer['telefono']); ?>">
                                            <?php echo htmlspecialchars($customer['nombre'] . ' ' . $customer['apellido']); ?> 
                                            - <?php echo htmlspecialchars($customer['rut']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">
                                        <i class="ri-information-line"></i> 
                                        Selecciona el cliente que realizará la compra
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="metodo_pago" class="form-label">
                                        Método de Pago <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                        <option value="efectivo">
                                            <i class="ri-money-dollar-circle-line"></i> Efectivo
                                        </option>
                                        <option value="tarjeta">
                                            <i class="ri-bank-card-line"></i> Tarjeta
                                        </option>
                                        <option value="transferencia">
                                            <i class="ri-exchange-dollar-line"></i> Transferencia
                                        </option>
                                    </select>
                                    <small class="text-muted">
                                        <i class="ri-secure-payment-line"></i> 
                                        Forma de pago utilizada
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Info del cliente seleccionado -->
                        <div id="clienteInfo" style="display: none;">
                            <div class="alert alert-info border-info">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info rounded-circle me-3">
                                        <span class="avatar-title" id="clienteInitials">-</span>
                                    </div>
                                    <div>
                                        <h5 class="mb-1" id="clienteNombre">-</h5>
                                        <p class="mb-0">
                                            <small>
                                                <i class="ri-mail-line"></i> 
                                                <span id="clienteEmail">-</span>
                                                <span class="mx-2">|</span>
                                                <i class="ri-phone-line"></i> 
                                                <span id="clienteTelefono">-</span>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" 
                                      placeholder="Agrega notas sobre esta venta: descuentos, condiciones especiales, etc."></textarea>
                        </div>
                    </div>

                    <!-- Sección: Productos -->
                    <div class="mb-4">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                            <i class="ri-shopping-bag-line me-1"></i> Productos
                        </h5>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-5">
                                <label for="producto_select" class="form-label">Producto</label>
                                <select class="form-select" id="producto_select">
                                    <option value="">-- Seleccionar Producto --</option>
                                    <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" 
                                            data-nombre="<?php echo htmlspecialchars($product['nombre']); ?>"
                                            data-precio="<?php echo $product['precio']; ?>"
                                            data-stock="<?php echo $product['stock_actual']; ?>"
                                            data-categoria="<?php echo htmlspecialchars($product['categoria'] ?? 'General'); ?>">
                                        <?php echo htmlspecialchars($product['nombre']); ?> 
                                        - $<?php echo number_format($product['precio'], 0, ',', '.'); ?> 
                                        (Stock: <?php echo $product['stock_actual']; ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="cantidad_input" class="form-label">Cantidad</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" id="decreaseBtn">
                                        <i class="ri-subtract-line"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" id="cantidad_input" value="1" min="1">
                                    <button type="button" class="btn btn-outline-secondary" id="increaseBtn">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-success w-100" id="addProductBtn">
                                    <i class="ri-add-circle-line"></i> Agregar Producto
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0" id="productosTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th class="text-center">Precio Unit.</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                        <th width="80">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="productosBody">
                                    <tr id="emptyRow">
                                        <td colspan="6" class="text-center py-4">
                                            <i class="ri-shopping-bag-line fs-2 text-muted"></i>
                                            <p class="text-muted mb-0">No hay productos agregados</p>
                                            <small class="text-muted">Selecciona productos arriba para agregarlos a la venta</small>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">TOTAL:</th>
                                        <th class="text-end">
                                            <h4 class="mb-0 text-primary" id="totalVenta">$0</h4>
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name="productos" id="productosData">
                    <input type="hidden" name="total" id="totalData">

                    <!-- Botones de acción -->
                    <div class="text-end">
                        <a href="<?php echo APP_URL; ?>/public/index.php?controller=sale&action=index" 
                           class="btn btn-light me-2">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                            <i class="ri-check-line"></i> Registrar Venta
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel lateral de resumen -->
        <div class="col-lg-4">
            <!-- Resumen de la venta -->
            <div class="card border-primary">
                <div class="card-body">
                    <h4 class="header-title mb-3">
                        <i class="ri-file-chart-line text-primary me-1"></i> 
                        Resumen de Venta
                    </h4>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Productos:</span>
                            <strong id="resumenCantidad">0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Items totales:</span>
                            <strong id="resumenItems">0</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Total a Pagar:</h5>
                            <h4 class="text-primary mb-0" id="resumenTotal">$0</h4>
                        </div>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="ri-information-line me-1"></i>
                        <small>
                            El total se calculará automáticamente al agregar productos
                        </small>
                    </div>
                </div>
            </div>

            <!-- Métodos de pago -->
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="ri-secure-payment-line text-success me-1"></i> 
                        Métodos de Pago
                    </h5>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <i class="ri-money-dollar-circle-line text-success fs-4 me-2"></i>
                            <strong>Efectivo</strong>
                            <p class="mb-0 text-muted">
                                <small>Pago inmediato en efectivo</small>
                            </p>
                        </div>
                        <div class="list-group-item px-0">
                            <i class="ri-bank-card-line text-primary fs-4 me-2"></i>
                            <strong>Tarjeta</strong>
                            <p class="mb-0 text-muted">
                                <small>Débito o crédito</small>
                            </p>
                        </div>
                        <div class="list-group-item px-0">
                            <i class="ri-exchange-dollar-line text-info fs-4 me-2"></i>
                            <strong>Transferencia</strong>
                            <p class="mb-0 text-muted">
                                <small>Transferencia bancaria</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips rápidos -->
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="ri-lightbulb-line text-warning me-1"></i> 
                        Consejos Rápidos
                    </h5>
                    
                    <div class="alert alert-warning mb-2">
                        <small>
                            <i class="ri-check-line me-1"></i>
                            Verifica el stock antes de agregar productos
                        </small>
                    </div>
                    
                    <div class="alert alert-info mb-2">
                        <small>
                            <i class="ri-user-line me-1"></i>
                            Selecciona el cliente antes de finalizar
                        </small>
                    </div>
                    
                    <div class="alert alert-success mb-0">
                        <small>
                            <i class="ri-calculator-line me-1"></i>
                            El sistema actualizará el stock automáticamente
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Variables globales
let productosVenta = [];
let contadorItems = 0;

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners
    document.getElementById('addProductBtn').addEventListener('click', agregarProducto);
    document.getElementById('increaseBtn').addEventListener('click', () => {
        const cantidadInput = document.getElementById('cantidad_input');
        cantidadInput.value = parseInt(cantidadInput.value) + 1;
    });
    document.getElementById('decreaseBtn').addEventListener('click', () => {
        const cantidadInput = document.getElementById('cantidad_input');
        if (parseInt(cantidadInput.value) > 1) {
            cantidadInput.value = parseInt(cantidadInput.value) - 1;
        }
    });

    // Info del cliente
    document.getElementById('cliente_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const clienteInfo = document.getElementById('clienteInfo');
        
        if (this.value) {
            const nombre = selectedOption.dataset.nombre;
            const email = selectedOption.dataset.email || 'No registrado';
            const telefono = selectedOption.dataset.telefono || 'No registrado';
            const initials = nombre.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            
            document.getElementById('clienteNombre').textContent = nombre;
            document.getElementById('clienteEmail').textContent = email;
            document.getElementById('clienteTelefono').textContent = telefono;
            document.getElementById('clienteInitials').textContent = initials;
            
            clienteInfo.style.display = 'block';
            clienteInfo.style.opacity = '0';
            setTimeout(() => {
                clienteInfo.style.transition = 'opacity 0.3s';
                clienteInfo.style.opacity = '1';
            }, 10);
        } else {
            clienteInfo.style.display = 'none';
        }
    });

    // Reset cantidad al seleccionar producto
    document.getElementById('producto_select').addEventListener('change', function() {
        if (this.value) {
            document.getElementById('cantidad_input').value = 1;
        }
    });
});

function agregarProducto() {
    const productoSelect = document.getElementById('producto_select');
    const cantidadInput = document.getElementById('cantidad_input');
    
    const productoId = productoSelect.value;
    const cantidad = parseInt(cantidadInput.value);
    
    if (!productoId) {
        alert('Por favor selecciona un producto');
        return;
    }
    
    if (cantidad <= 0) {
        alert('La cantidad debe ser mayor a 0');
        return;
    }
    
    const selectedOption = productoSelect.options[productoSelect.selectedIndex];
    const nombre = selectedOption.dataset.nombre;
    const precio = parseFloat(selectedOption.dataset.precio);
    const stock = parseInt(selectedOption.dataset.stock);
    const categoria = selectedOption.dataset.categoria;
    
    // Verificar stock
    const cantidadExistente = productosVenta.find(p => p.id == productoId);
    const totalCantidad = cantidadExistente ? cantidadExistente.cantidad + cantidad : cantidad;
    
    if (totalCantidad > stock) {
        alert(`Stock insuficiente. Disponible: ${stock} unidades`);
        return;
    }
    
    // Verificar si ya existe el producto
    const productoExistente = productosVenta.find(p => p.id == productoId);
    
    if (productoExistente) {
        productoExistente.cantidad += cantidad;
        productoExistente.subtotal = productoExistente.cantidad * productoExistente.precio;
    } else {
        contadorItems++;
        productosVenta.push({
            id: productoId,
            nombre: nombre,
            precio: precio,
            cantidad: cantidad,
            subtotal: precio * cantidad,
            categoria: categoria,
            index: contadorItems
        });
    }
    
    // Limpiar selección
    productoSelect.value = '';
    cantidadInput.value = 1;
    
    // Actualizar tabla
    actualizarTabla();
}

function eliminarProducto(productoId) {
    productosVenta = productosVenta.filter(p => p.id != productoId);
    actualizarTabla();
}

function actualizarCantidad(productoId, nuevaCantidad) {
    const producto = productosVenta.find(p => p.id == productoId);
    if (producto) {
        // Verificar stock
        const productoSelect = document.getElementById('producto_select');
        const option = Array.from(productoSelect.options).find(opt => opt.value == productoId);
        const stockDisponible = parseInt(option.dataset.stock);
        
        if (nuevaCantidad > stockDisponible) {
            alert(`Stock insuficiente. Disponible: ${stockDisponible} unidades`);
            return;
        }
        
        if (nuevaCantidad <= 0) {
            eliminarProducto(productoId);
        } else {
            producto.cantidad = nuevaCantidad;
            producto.subtotal = producto.precio * nuevaCantidad;
            actualizarTabla();
        }
    }
}

function actualizarTabla() {
    const tbody = document.getElementById('productosBody');
    const emptyRow = document.getElementById('emptyRow');
    
    if (productosVenta.length === 0) {
        emptyRow.style.display = '';
        document.getElementById('submitBtn').disabled = true;
    } else {
        emptyRow.style.display = 'none';
        
        // Limpiar tbody excepto emptyRow
        while (tbody.children.length > 1) {
            tbody.removeChild(tbody.lastChild);
        }
        
        // Agregar productos
        productosVenta.forEach((producto, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <span class="badge bg-secondary">${index + 1}</span>
                </td>
                <td>
                    <h5 class="mb-1">${producto.nombre}</h5>
                    <small class="text-muted">
                        <i class="ri-tag-line"></i> ${producto.categoria}
                    </small>
                </td>
                <td class="text-center">
                    <strong>$${producto.precio.toLocaleString('es-CL')}</strong>
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" 
                                onclick="actualizarCantidad(${producto.id}, ${producto.cantidad - 1})">
                            <i class="ri-subtract-line"></i>
                        </button>
                        <input type="number" class="form-control form-control-sm text-center" 
                               style="width: 60px;" value="${producto.cantidad}" min="1"
                               onchange="actualizarCantidad(${producto.id}, parseInt(this.value))">
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-1"
                                onclick="actualizarCantidad(${producto.id}, ${producto.cantidad + 1})">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </td>
                <td class="text-end">
                    <h5 class="text-primary mb-0">$${producto.subtotal.toLocaleString('es-CL')}</h5>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" 
                            onclick="eliminarProducto(${producto.id})"
                            title="Eliminar producto">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.getElementById('submitBtn').disabled = false;
    }
    
    // Actualizar totales
    actualizarTotales();
}

function actualizarTotales() {
    const total = productosVenta.reduce((sum, p) => sum + p.subtotal, 0);
    const cantidadProductos = productosVenta.length;
    const cantidadItems = productosVenta.reduce((sum, p) => sum + p.cantidad, 0);
    
    // Actualizar en la tabla
    document.getElementById('totalVenta').innerHTML = `<h4 class="mb-0 text-primary">$${total.toLocaleString('es-CL')}</h4>`;
    
    // Actualizar en el resumen
    document.getElementById('resumenCantidad').textContent = cantidadProductos;
    document.getElementById('resumenItems').textContent = cantidadItems;
    document.getElementById('resumenTotal').textContent = `$${total.toLocaleString('es-CL')}`;
    
    // Actualizar campos ocultos
    document.getElementById('productosData').value = JSON.stringify(productosVenta.map(p => ({
        producto_id: p.id,
        cantidad: p.cantidad,
        precio_unitario: p.precio
    })));
    document.getElementById('totalData').value = total;
}

// Validación del formulario
document.getElementById('saleForm').addEventListener('submit', function(e) {
    if (productosVenta.length === 0) {
        e.preventDefault();
        alert('Debes agregar al menos un producto a la venta');
        return false;
    }
    
    if (!document.getElementById('cliente_id').value) {
        e.preventDefault();
        alert('Debes seleccionar un cliente');
        return false;
    }
    
    // Confirmar venta
    const total = productosVenta.reduce((sum, p) => sum + p.subtotal, 0);
    const confirm = window.confirm(
        `¿Confirmar venta por $${total.toLocaleString('es-CL')}?\n\n` +
        `Productos: ${productosVenta.length}\n` +
        `Items totales: ${productosVenta.reduce((sum, p) => sum + p.cantidad, 0)}`
    );
    
    if (!confirm) {
        e.preventDefault();
        return false;
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
