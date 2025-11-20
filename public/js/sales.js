// Sistema de gestión de ventas
let productosVenta = [];
let totalVenta = 0;

document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('addProductBtn');
    const saleForm = document.getElementById('saleForm');
    
    if (addProductBtn) {
        addProductBtn.addEventListener('click', agregarProducto);
    }
    
    if (saleForm) {
        saleForm.addEventListener('submit', function(e) {
            if (productosVenta.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto a la venta');
                return false;
            }
            
            // Preparar datos para enviar
            document.getElementById('productosData').value = JSON.stringify(productosVenta);
            document.getElementById('totalData').value = totalVenta;
        });
    }
});

function agregarProducto() {
    const productoSelect = document.getElementById('producto_select');
    const cantidadInput = document.getElementById('cantidad_input');
    
    if (!productoSelect.value) {
        alert('Debe seleccionar un producto');
        return;
    }
    
    const cantidad = parseInt(cantidadInput.value);
    if (cantidad <= 0) {
        alert('La cantidad debe ser mayor a 0');
        return;
    }
    
    const option = productoSelect.options[productoSelect.selectedIndex];
    const productoId = option.value;
    const productoNombre = option.dataset.nombre;
    const precio = parseFloat(option.dataset.precio);
    const stockDisponible = parseInt(option.dataset.stock);
    
    // Verificar stock
    if (cantidad > stockDisponible) {
        alert(`Stock insuficiente. Disponible: ${stockDisponible}`);
        return;
    }
    
    // Verificar si el producto ya está agregado
    const productoExistente = productosVenta.find(p => p.producto_id === productoId);
    if (productoExistente) {
        const nuevaCantidad = productoExistente.cantidad + cantidad;
        if (nuevaCantidad > stockDisponible) {
            alert(`Stock insuficiente. Ya tiene ${productoExistente.cantidad} en el carrito. Disponible: ${stockDisponible}`);
            return;
        }
        productoExistente.cantidad = nuevaCantidad;
        productoExistente.subtotal = productoExistente.cantidad * precio;
    } else {
        productosVenta.push({
            producto_id: productoId,
            nombre: productoNombre,
            precio_unitario: precio,
            cantidad: cantidad,
            subtotal: precio * cantidad
        });
    }
    
    actualizarTablaProductos();
    
    // Limpiar campos
    productoSelect.value = '';
    cantidadInput.value = 1;
}

function eliminarProducto(productoId) {
    productosVenta = productosVenta.filter(p => p.producto_id !== productoId);
    actualizarTablaProductos();
}

function actualizarTablaProductos() {
    const tbody = document.getElementById('productosBody');
    const emptyRow = document.getElementById('emptyRow');
    const submitBtn = document.getElementById('submitBtn');
    
    if (productosVenta.length === 0) {
        emptyRow.style.display = '';
        submitBtn.disabled = true;
        totalVenta = 0;
    } else {
        emptyRow.style.display = 'none';
        submitBtn.disabled = false;
        
        // Limpiar tabla
        tbody.querySelectorAll('tr:not(#emptyRow)').forEach(row => row.remove());
        
        // Agregar productos
        totalVenta = 0;
        productosVenta.forEach(producto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${producto.nombre}</td>
                <td>$${formatNumber(producto.precio_unitario)}</td>
                <td>${producto.cantidad}</td>
                <td>$${formatNumber(producto.subtotal)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarProducto('${producto.producto_id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            totalVenta += producto.subtotal;
        });
    }
    
    // Actualizar total
    document.getElementById('totalVenta').textContent = '$' + formatNumber(totalVenta);
}

function formatNumber(num) {
    return new Intl.NumberFormat('es-CL').format(num);
}

// Actualizar cantidad de un producto
function actualizarCantidad(productoId, cantidad) {
    const producto = productosVenta.find(p => p.producto_id === productoId);
    if (producto && cantidad > 0) {
        producto.cantidad = cantidad;
        producto.subtotal = producto.precio_unitario * cantidad;
        actualizarTablaProductos();
    }
}
