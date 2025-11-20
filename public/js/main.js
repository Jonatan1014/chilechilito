// Sistema de ventas - JavaScript Principal
document.addEventListener('DOMContentLoaded', function() {
    // Activar link actual en el menú
    const currentPage = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (currentPage.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });

    // Auto-cerrar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Confirmar antes de eliminar
    const deleteLinks = document.querySelectorAll('a[href*="delete"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('¿Está seguro de que desea eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });

    // Formatear números como moneda
    const currencyElements = document.querySelectorAll('.currency');
    currencyElements.forEach(el => {
        const value = parseFloat(el.textContent);
        if (!isNaN(value)) {
            el.textContent = formatCurrency(value);
        }
    });
});

// Función para formatear moneda
function formatCurrency(amount) {
    return '$' + new Intl.NumberFormat('es-CL').format(amount);
}

// Función para formatear fecha
function formatDate(date) {
    return new Date(date).toLocaleDateString('es-CL', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Validación de RUT chileno
function validateRUT(rut) {
    // Eliminar puntos y guión
    rut = rut.replace(/\./g, '').replace(/-/g, '');
    
    const body = rut.slice(0, -1);
    const dv = rut.slice(-1).toUpperCase();
    
    // Calcular dígito verificador
    let suma = 0;
    let multiplo = 2;
    
    for (let i = body.length - 1; i >= 0; i--) {
        suma += multiplo * parseInt(body.charAt(i));
        multiplo = multiplo < 7 ? multiplo + 1 : 2;
    }
    
    const dvEsperado = 11 - (suma % 11);
    const dvCalculado = dvEsperado === 11 ? '0' : dvEsperado === 10 ? 'K' : dvEsperado.toString();
    
    return dv === dvCalculado;
}

// Formatear RUT mientras se escribe
document.addEventListener('DOMContentLoaded', function() {
    const rutInputs = document.querySelectorAll('input[name="rut"]');
    
    rutInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const rut = this.value.replace(/\./g, '').replace(/-/g, '');
            if (rut.length > 1) {
                const body = rut.slice(0, -1);
                const dv = rut.slice(-1);
                this.value = body + '-' + dv;
                
                if (!validateRUT(this.value)) {
                    this.setCustomValidity('RUT inválido');
                    this.reportValidity();
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    });
});

// Búsqueda en tablas
function filterTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    
    if (input && table) {
        input.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
}
