# Chile Chilito - Sistema de Gestión de Inventario y Ventas

Sistema web completo para la gestión de inventario, ventas y clientes con dashboard de métricas en tiempo real.

## 🌶️ Características

- **Gestión de Productos**: CRUD completo de productos con control de stock
- **Gestión de Clientes**: Administración de clientes con historial de compras
- **Gestión de Ventas**: Registro de ventas con múltiples productos y métodos de pago
- **Dashboard con Métricas**:
  - Ventas del día, mes y año
  - Productos más y menos vendidos
  - Mejores clientes y clientes con menos compras
  - Análisis de ventas por día de la semana
  - Alertas de stock bajo
  - Productos preferidos por cliente
  
## 🏗️ Arquitectura

El sistema está construido bajo el patrón **MVC (Modelo-Vista-Controlador)**:

```
chile_chilito/
├── app/
│   ├── config/          # Configuración y conexión a BD
│   ├── controllers/     # Controladores (lógica de negocio)
│   ├── models/          # Modelos (interacción con BD)
│   └── views/           # Vistas (interfaz de usuario)
│       ├── layouts/
│       ├── dashboard/
│       ├── products/
│       ├── customers/
│       └── sales/
├── public/              # Archivos públicos
│   ├── css/
│   ├── js/
│   ├── assets/
│   └── index.php        # Punto de entrada
└── database.sql         # Script de base de datos
```

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ con PDO
- **Base de Datos**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Gráficos**: Chart.js
- **Iconos**: Font Awesome 6

## 📦 Instalación

### 1. Requisitos previos
- XAMPP (o cualquier servidor con PHP y MySQL)
- PHP 7.4 o superior
- MySQL 5.7 o superior

### 2. Configurar la base de datos

1. Abrir phpMyAdmin (http://localhost/phpmyadmin)
2. Crear una nueva base de datos o ejecutar el script:
```bash
mysql -u root -p < database.sql
```

### 3. Configurar la aplicación

Editar `app/config/config.php` si es necesario:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'chile_chilito');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Acceder al sistema

Abrir en el navegador:
```
http://localhost/chile_chilito/public/
```

## 📊 Funcionalidades del Dashboard

### Métricas Principales
- **Ventas Hoy**: Total de ventas y transacciones del día actual
- **Ventas del Mes**: Acumulado mensual con número de transacciones
- **Ventas del Año**: Total anual y cantidad de ventas
- **Stock Bajo**: Productos que necesitan reposición

### Análisis de Productos
- **Más Vendidos**: Top 5 productos por unidades vendidas
- **Menos Vendidos**: Productos con menor rotación
- **Stock Bajo**: Alertas cuando stock actual ≤ stock mínimo

### Análisis de Clientes
- **Mejores Clientes**: Ranking por monto total gastado
- **Clientes Inactivos**: Clientes con pocas o ninguna compra
- **Productos Preferidos**: Qué compra más cada cliente

### Análisis Temporal
- **Ventas por Día de Semana**: Identifica días con más ventas
- **Ventas por Mes**: Tendencias mensuales
- **Historial Completo**: Registro detallado de todas las ventas

## 🎯 Uso del Sistema

### Gestión de Productos
1. Ir a "Productos" en el menú lateral
2. Clic en "Nuevo Producto"
3. Llenar formulario con datos del producto
4. El sistema alertará cuando el stock esté bajo

### Registrar una Venta
1. Ir a "Ventas" → "Nueva Venta"
2. Seleccionar cliente
3. Agregar productos uno por uno
4. El sistema:
   - Valida stock disponible
   - Calcula automáticamente subtotales y total
   - Actualiza el inventario
5. Confirmar venta

### Ver Métricas
- Dashboard muestra automáticamente todas las métricas
- Gráficos interactivos con Chart.js
- Datos en tiempo real desde la base de datos

## 🔐 Seguridad

- Validación de datos con PDO Prepared Statements
- Sanitización de entradas con `htmlspecialchars()`
- Prevención de SQL Injection
- Validación de RUT chileno en JavaScript

## 📱 Responsive

El sistema es responsive y se adapta a:
- Desktop (> 1200px)
- Tablet (768px - 1200px)
- Mobile (< 768px)

## 🎨 Personalización

### Colores
Editar variables CSS en `public/css/style.css`:
```css
:root {
    --primary-color: #d32f2f;
    --secondary-color: #f57c00;
    --success-color: #388e3c;
    /* ... */
}
```

### Logo
Reemplazar el texto en `app/views/layouts/header.php`

## 📈 Métricas Disponibles

1. **Productos a reponer**: Stock actual ≤ Stock mínimo
2. **Productos más consumidos**: Mayor cantidad vendida
3. **Productos menos consumidos**: Menor rotación
4. **Mejores clientes**: Mayor monto de compras
5. **Clientes inactivos**: Sin compras o monto bajo
6. **Preferencias por cliente**: Productos más comprados por cada cliente
7. **Días con más ventas**: Análisis por día de la semana
8. **Días con menos ventas**: Identificar días flojos

## 🐛 Solución de Problemas

### Error de conexión a la base de datos
- Verificar credenciales en `app/config/config.php`
- Asegurar que MySQL esté corriendo
- Verificar que la base de datos exista

### Página en blanco
- Activar errores en `config.php`: `ini_set('display_errors', 1);`
- Revisar logs de Apache/PHP

### Gráficos no se muestran
- Verificar conexión a internet (Chart.js se carga desde CDN)
- Revisar consola del navegador (F12)

## 📝 Licencia

Este proyecto fue creado para fines educativos y de demostración.

## 👨‍💻 Autor

Sistema desarrollado para Chile Chilito - Gestión de productos chilenos.

---

**Versión**: 1.0.0  
**Fecha**: Noviembre 2025
