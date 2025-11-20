# Chile Chilito - Sistema de Gestión de Inventario y Producción

Sistema web completo para la gestión de inventario, producción, ventas, insumos y clientes con dashboard de métricas en tiempo real. Diseñado específicamente para empresas de producción de alimentos que requieren control de recetas, costos e insumos.

## 🌶️ Características Principales

### 📦 Gestión de Productos
- CRUD completo con control de stock
- Sistema de recetas con insumos necesarios
- Cálculo automático de costos de producción
- Control de productos que requieren producción
- Alertas de stock bajo y reposición
- Validación de disponibilidad de insumos

### 🧪 Gestión de Insumos
- Control completo de materia prima
- Stock mínimo y máximo por insumo
- Historial de movimientos (compras, usos, ajustes)
- Alertas de stock bajo
- Cálculo de necesidades de compra según producción
- Vinculación con productos (qué productos usan cada insumo)

### 🏭 Sistema de Producción
- Registro de lotes de producción
- Validación automática de disponibilidad de insumos
- Descuento automático de insumos según receta
- Incremento automático de stock de productos
- Historial completo de producciones
- Cálculo de costos por lote

### 👥 Gestión de Clientes
- CRUD completo con validación de RUT chileno
- Historial completo de compras por cliente
- Estadísticas: total gastado, productos favoritos
- Análisis de frecuencia de compra
- Vista detallada con métricas individuales
- Top productos más comprados por cliente

### 💰 Gestión de Ventas
- Registro de ventas con múltiples productos
- Múltiples métodos de pago (efectivo, tarjeta, transferencia)
- Validación de stock antes de vender
- Descuento automático de inventario
- Reportes de ventas por período
- Análisis de rentabilidad

### 📊 Dashboard Analítico
- Ventas del día, mes y año en tiempo real
- Productos más y menos vendidos
- Mejores clientes y análisis de comportamiento
- Ventas por día de la semana
- Alertas de stock bajo (productos e insumos)
- Gráficos interactivos con Chart.js

### 👤 Gestión de Usuarios
- Sistema de roles (Admin y Vendedor)
- Control de acceso por funcionalidades
- Usuarios de administración y operativos
  
## 🏗️ Arquitectura

El sistema está construido bajo el patrón **MVC (Modelo-Vista-Controlador)**:

```
chile_chilito/
├── app/
│   ├── config/              # Configuración y conexión a BD
│   │   ├── config.php       # Constantes y configuración
│   │   └── database.php     # Conexión PDO a MySQL
│   ├── controllers/         # Controladores (lógica de negocio)
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   ├── InsumoController.php
│   │   ├── ProductionController.php
│   │   ├── SaleController.php
│   │   ├── CustomerController.php
│   │   └── UserController.php
│   ├── models/              # Modelos (interacción con BD)
│   │   ├── Product.php
│   │   ├── Insumo.php
│   │   ├── Production.php
│   │   ├── Sale.php
│   │   ├── Customer.php
│   │   └── User.php
│   └── views/               # Vistas (interfaz de usuario)
│       ├── layouts/         # Header, sidebar, footer
│       ├── auth/            # Login
│       ├── dashboard/       # Dashboard principal
│       ├── products/        # CRUD productos
│       ├── insumos/         # CRUD insumos
│       ├── production/      # Sistema de producción
│       ├── customers/       # CRUD clientes
│       ├── sales/           # CRUD y reportes de ventas
│       └── users/           # Gestión de usuarios
├── public/                  # Archivos públicos accesibles
│   ├── assets/              # Hyper Admin Template
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── index.php            # Punto de entrada (Front Controller)
├── database.sql             # Script de base de datos
└── README.md
```

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ con PDO (Prepared Statements)
- **Base de Datos**: MySQL 5.7+ / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Template**: Hyper - Responsive Bootstrap 5 Admin Dashboard
- **CSS Framework**: Bootstrap 5.3
- **Gráficos**: Chart.js 4.x
- **Tablas**: DataTables 1.13.7 con extensiones (Excel, PDF, Print)
- **Iconos**: Remix Icons
- **Patrón**: MVC (Model-View-Controller)
- **Sesiones**: PHP Sessions para autenticación

## 📦 Instalación

### 1. Requisitos Previos
- **XAMPP** (o WAMP/LAMP/MAMP)
- **PHP 7.4** o superior (recomendado PHP 8.0+)
- **MySQL 5.7** o superior / MariaDB 10.3+
- Navegador web moderno (Chrome, Firefox, Edge)

### 2. Clonar o Descargar el Proyecto

```bash
# Clonar en htdocs de XAMPP
cd C:\xampp\htdocs
git clone <repository-url> chile_chilito

# O descargar ZIP y extraer en htdocs
```

### 3. Configurar la Base de Datos

#### Opción A: Usar phpMyAdmin
1. Abrir http://localhost/phpmyadmin
2. Crear base de datos `chile_chilito`
3. Importar `database.sql`

#### Opción B: Línea de comandos
```bash
mysql -u root -p
CREATE DATABASE chile_chilito;
USE chile_chilito;
SOURCE /ruta/al/database.sql;
```

### 4. Configurar la Aplicación

Editar `app/config/config.php`:

```php
// Configuración de Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'chile_chilito');
define('DB_USER', 'root');
define('DB_PASS', '');  // Tu contraseña de MySQL

// URL Base (cambiar si instalas en subcarpeta diferente)
define('APP_URL', 'http://localhost/chile_chilito');
```

### 5. Iniciar Servicios

1. Abrir XAMPP Control Panel
2. Iniciar **Apache**
3. Iniciar **MySQL**

### 6. Acceder al Sistema

Abrir navegador:
```
http://localhost/chile_chilito/public/
```

### 7. Credenciales de Prueba

**Administrador:**
- Email: `admin@chilechilito.cl`
- Contraseña: `123`

**Vendedor:**
- Email: `vendedor@chilechilito.cl`
- Contraseña: `123`

## 📊 Funcionalidades Detalladas

### 1. Sistema de Productos

#### Crear Producto
1. Ir a **Productos → Nuevo Producto**
2. Completar formulario:
   - Nombre, categoría, descripción
   - Precio de venta
   - Stock actual y mínimo
   - URL de imagen (opcional)
   - Estado (activo/inactivo)
3. **Configurar Receta** (opcional):
   - Activar "Requiere producción"
   - Agregar insumos necesarios
   - Definir cantidad de cada insumo
   - Especificar unidad de medida

#### Gestionar Productos
- **Ver todos**: Lista con DataTables (búsqueda, ordenamiento, exportar)
- **Editar**: Modificar datos y receta
- **Ver detalle**: Información completa, receta, análisis financiero
- **Eliminar**: Solo si no tiene ventas asociadas
- **Stock bajo**: Filtrar productos que necesitan reposición

### 2. Sistema de Insumos

#### Crear Insumo
1. Ir a **Insumos → Nuevo Insumo**
2. Completar:
   - Nombre, SKU, categoría
   - Unidad de medida (kg, litros, unidades)
   - Stock actual, mínimo, máximo
   - Costo unitario
   - Proveedor

#### Movimientos de Insumos
El sistema registra automáticamente:
- **Compras**: Cuando se adquiere insumo
- **Usos**: Cuando se produce (descuenta según receta)
- **Ajustes**: Correcciones manuales de inventario

#### Análisis de Insumos
- **Alertas de stock**: Notificación cuando stock ≤ mínimo
- **Necesidades de compra**: Calcula qué comprar según producción planificada
- **Productos vinculados**: Ver qué productos usan cada insumo
- **Valor en stock**: Stock actual × costo unitario

### 3. Sistema de Producción

#### Registrar Producción
1. Ir a **Producción → Nueva Producción**
2. Seleccionar producto a producir
3. Ingresar cantidad de unidades
4. El sistema:
   - Valida disponibilidad de insumos según receta
   - Muestra insumos necesarios y disponibles
   - Calcula costo total de producción
5. Al confirmar:
   - Descuenta insumos automáticamente
   - Incrementa stock del producto
   - Registra movimiento en historial

#### Validaciones
- Stock de insumos insuficiente → Error detallado
- Producto sin receta → No permite producción
- Cálculo automático: `cantidad_producto × cantidad_insumo_en_receta`

### 4. Sistema de Ventas

#### Registrar Venta
1. Ir a **Ventas → Nueva Venta**
2. Seleccionar cliente (obligatorio)
3. Agregar productos:
   - Buscar por nombre
   - Ingresar cantidad
   - Sistema valida stock disponible
4. Seleccionar método de pago
5. Confirmar venta:
   - Descuenta stock automáticamente
   - Registra detalle por producto
   - Genera total

#### Reportes de Ventas
- Filtrar por fecha (desde - hasta)
- Ver totales por período
- Análisis por método de pago
- Exportar a Excel/PDF
- Gráfico de tendencias

### 5. Gestión de Clientes

#### Crear Cliente
1. Ir a **Clientes → Nuevo Cliente**
2. Completar:
   - Nombre y apellido
   - RUT (con validación chilena)
   - Email y teléfono
   - Dirección
   - Estado

#### Vista de Cliente
- Información personal con avatar
- **Estadísticas**:
  - Total de compras
  - Total gastado
  - Productos únicos comprados
  - Promedio por compra
- **Top productos**: Los 5 más comprados
- **Historial completo**: Todas las compras con DataTables exportable

### 6. Dashboard Analítico

#### Widgets de Métricas
- **Ventas Hoy**: Total $ y # transacciones
- **Ventas del Mes**: Acumulado mensual
- **Ventas del Año**: Total anual
- **Alertas**: Stock bajo en productos e insumos

#### Gráficos Interactivos
- **Productos más vendidos**: Top 10 con unidades
- **Productos menos vendidos**: Los 10 con menor rotación
- **Ventas por día de semana**: Identifica días pico
- **Mejores clientes**: Top 5 por monto gastado
- **Tendencias mensuales**: Ventas por mes del año

### 7. Gestión de Usuarios (Solo Admin)

#### Crear Usuario
1. Ir a **Usuarios → Nuevo Usuario**
2. Definir:
   - Nombre de usuario (login)
   - Email
   - Contraseña
   - Rol: Admin o Vendedor

#### Roles y Permisos
- **Admin**:
  - Acceso completo
  - Gestión de usuarios
  - Eliminar registros
  - Configuración del sistema
  
- **Vendedor**:
  - Ver productos e insumos
  - Registrar ventas
  - Ver clientes
  - No puede eliminar
  - No accede a usuarios

## 🎯 Casos de Uso Comunes

### Caso 1: Producir Empanadas

**Escenario**: Fabricar 100 empanadas de pino

1. **Configurar Producto "Empanada de Pino"**:
   - Precio: $1500
   - Activar "Requiere producción"
   - Agregar receta:
     - Masa: 0.1 kg por unidad
     - Carne: 0.08 kg por unidad
     - Cebolla: 0.03 kg por unidad
     - Aceitunas: 0.01 kg por unidad

2. **Registrar Producción**:
   - Ir a Producción → Nueva Producción
   - Seleccionar "Empanada de Pino"
   - Cantidad: 100 unidades
   - Sistema calcula:
     - Masa: 10 kg
     - Carne: 8 kg
     - Cebolla: 3 kg
     - Aceitunas: 1 kg
   - Valida stock de insumos
   - Al confirmar: descuenta insumos, suma 100 empanadas al stock

3. **Vender Empanadas**:
   - Ir a Ventas → Nueva Venta
   - Cliente: "Juan Pérez"
   - Producto: Empanada de Pino × 30
   - Total: $45,000
   - Confirmar: descuenta 30 del stock

### Caso 2: Control de Stock Bajo

**Escenario**: Recibir alertas de reposición

1. **Configurar Stocks Mínimos**:
   - Producto: Empanada → Stock mínimo: 50
   - Insumo: Masa → Stock mínimo: 5 kg

2. **Ver Alertas**:
   - Dashboard muestra contador de alertas
   - Productos → Stock Bajo (lista filtrada)
   - Insumos → Alertas de Stock

3. **Necesidades de Compra**:
   - Ir a Insumos → Necesidades de Compra
   - Sistema calcula qué comprar para producir X unidades

### Caso 3: Análisis de Ventas

**Escenario**: Ver rendimiento del mes

1. **Dashboard**:
   - Ver ventas totales del mes
   - Gráfico de productos más vendidos
   - Identificar mejores clientes

2. **Reporte Detallado**:
   - Ir a Ventas → Reportes
   - Filtrar: 01/11/2025 - 30/11/2025
   - Ver tabla con todas las ventas
   - Exportar a Excel para análisis externo

3. **Análisis por Cliente**:
   - Ir a Clientes → Ver cliente
   - Revisar historial de compras
   - Identificar productos favoritos
   - Calcular promedio de compra

## 🔐 Seguridad Implementada

### Prevención de Ataques
- **SQL Injection**: PDO Prepared Statements en todas las consultas
- **XSS**: Sanitización con `htmlspecialchars()` en salidas
- **CSRF**: Validación de sesiones
- **Autenticación**: Sistema de login con sesiones PHP
- **Control de acceso**: Verificación de rol en cada acción

### Validaciones
- **RUT chileno**: Algoritmo de validación con dígito verificador
- **Emails**: Formato válido
- **Stock**: No permite ventas/producción sin disponibilidad
- **Datos requeridos**: Validación frontend y backend
- **Tipos de dato**: Casting y validación estricta

### Buenas Prácticas
```php
// Prepared Statements
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

// Sanitización de salida
echo htmlspecialchars($product['nombre'] ?? '');

// Validación de sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Control de roles
if ($_SESSION['role'] !== 'admin') {
    die('Acceso denegado');
}
```

## 📱 Diseño Responsive

El sistema utiliza **Bootstrap 5** y **Hyper Template** para adaptarse a:

- **Desktop** (≥ 1200px): Sidebar expandido, todas las funciones
- **Tablet** (768px - 1199px): Sidebar colapsable, layout ajustado
- **Mobile** (< 768px): Menú hamburguesa, vistas optimizadas

### Características Responsive
- Tablas con scroll horizontal en móviles
- Cards apiladas en pantallas pequeñas
- Formularios con inputs de ancho completo
- Sidebar oculto por defecto en móvil
- Botones con iconos (sin texto) en espacios reducidos

## 🎨 Personalización

### Cambiar Colores del Tema
Hyper permite cambiar colores desde el panel de configuración:
1. Click en ⚙️ (esquina superior derecha)
2. Seleccionar **Color Scheme**
3. Elegir tema (Light, Dark, etc.)

### Modificar Logo
En `app/views/layouts/topbar.php` y `sidebar.php`:
```php
<span class="text-white fs-4 fw-bold">
    <i class="ri-fire-line"></i> TuNombre
</span>
```

### Agregar Página Personalizada
1. Crear controlador: `app/controllers/MiController.php`
2. Crear modelo: `app/models/MiModelo.php`
3. Crear vistas: `app/views/mi_modulo/`
4. Agregar al menú: `app/views/layouts/sidebar.php`

### Exportar con Logo Personalizado
En DataTables (archivos `index.php`):
```javascript
title: 'Mi Empresa - Reporte'
```

## 📈 Base de Datos

### Estructura Principal

#### Tabla: `products`
- Control de productos terminados
- Stock actual y mínimo
- Precio y categoría
- Flag `requiere_produccion` para productos con receta

#### Tabla: `insumos`
- Materia prima e ingredientes
- Stock, unidad de medida
- Costo unitario y proveedor
- Stocks mínimo y máximo

#### Tabla: `product_insumos` (Recetas)
- Relación N:M entre productos e insumos
- `cantidad_necesaria` por unidad de producto
- Define qué insumos y cuánto necesita cada producto

#### Tabla: `production`
- Historial de producciones
- Producto, cantidad, fecha
- Usuario que registró

#### Tabla: `insumo_movimientos`
- Trazabilidad de insumos
- Tipos: compra, uso, ajuste
- Cantidad y fecha

#### Tabla: `sales`
- Registro de ventas
- Cliente, total, método de pago
- Fecha y usuario vendedor

#### Tabla: `sale_details`
- Detalle de productos por venta
- Cantidad, precio unitario, subtotal

#### Tabla: `customers`
- Clientes con RUT, email, teléfono
- Estado activo/inactivo

#### Tabla: `users`
- Usuarios del sistema
- Roles: admin, vendedor

### Relaciones
```
products 1:N sale_details
products 1:N production
products N:M insumos (through product_insumos)
insumos 1:N insumo_movimientos
customers 1:N sales
sales 1:N sale_details
users 1:N sales
users 1:N production
```

## 🐛 Solución de Problemas

### Error: "Unable to connect to database"
**Causa**: Credenciales incorrectas o MySQL no está corriendo

**Solución**:
```php
// Verificar en app/config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'chile_chilito');
define('DB_USER', 'root');
define('DB_PASS', '');  // Cambiar si tienes contraseña

// Verificar en XAMPP Control Panel
- Apache: Running ✓
- MySQL: Running ✓
```

### Error: "Deprecated: htmlspecialchars(): Passing null"
**Causa**: PHP 8.1+ no acepta null en htmlspecialchars()

**Solución**:
```php
// Usar operador null coalescing
echo htmlspecialchars($variable ?? '');
```

### Página en blanco sin errores
**Solución**:
```php
// Activar errores en app/config/config.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Revisar logs
// XAMPP: C:\xampp\apache\logs\error.log
```

### Gráficos no se muestran
**Causa**: No hay conexión a CDN o no hay datos

**Solución**:
1. Verificar internet (Chart.js viene de CDN)
2. Abrir consola (F12) → buscar errores JavaScript
3. Verificar que hay datos en la BD
4. Revisar consultas en DashboardController

### DataTables no funcionan
**Causa**: Scripts no cargan o conflicto de versiones

**Solución**:
```php
// Verificar orden en header.php
1. DataTables CSS
2. jQuery
3. DataTables JS
4. Extensiones (buttons, jszip, pdfmake)

// Revisar consola del navegador
```

### Error al producir: "Stock insuficiente"
**Causa**: No hay suficientes insumos según receta

**Solución**:
1. Ir a Insumos → Ver el insumo
2. Verificar stock actual vs necesario
3. Registrar compra de insumo
4. Intentar producción nuevamente

### No puedo eliminar producto/insumo
**Causa**: Tiene relaciones en otras tablas

**Solución**:
- Productos con ventas → No se pueden eliminar (integridad)
- Insumos en recetas → Primero quitar de recetas
- Solo Admin puede eliminar

### Sesión expira muy rápido
**Solución**:
```php
// Ajustar en php.ini
session.gc_maxlifetime = 3600  // 1 hora
session.cookie_lifetime = 3600

// O en app/config/config.php
ini_set('session.gc_maxlifetime', 3600);
```

### Error 404 en rutas
**Causa**: APP_URL mal configurado

**Solución**:
```php
// En app/config/config.php
// Si instalaste en subcarpeta:
define('APP_URL', 'http://localhost/chile_chilito');

// Si instalaste en raíz:
define('APP_URL', 'http://localhost');
```

## 🚀 Características Técnicas Avanzadas

### DataTables con Exportación
Todas las tablas incluyen:
- **Búsqueda en tiempo real**
- **Ordenamiento por columnas**
- **Paginación configurable**
- **Exportación**:
  - Excel (.xlsx)
  - PDF
  - Copiar al portapapeles
  - Imprimir
- **Idioma español**
- **Exclusión de columna de acciones** en exportaciones

### Validaciones JavaScript
```javascript
// Validación de RUT chileno
function validarRut(rut) {
    // Algoritmo módulo 11
    // Retorna true/false
}

// Validación de stock en tiempo real
// Antes de agregar producto a venta
```

### AJAX y Carga Dinámica
- Preview en tiempo real en formularios
- Actualización de totales en ventas
- Validación de disponibilidad sin recargar

### Gráficos Interactivos
```javascript
// Chart.js con configuración personalizada
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Lun', 'Mar', 'Mié'...],
        datasets: [{
            label: 'Ventas',
            data: [100, 200, 150...]
        }]
    }
});
```

## 📚 Recursos y Documentación

### Tecnologías Utilizadas
- **PHP**: https://www.php.net/
- **MySQL**: https://dev.mysql.com/doc/
- **Bootstrap 5**: https://getbootstrap.com/docs/5.3/
- **DataTables**: https://datatables.net/
- **Chart.js**: https://www.chartjs.org/docs/
- **Hyper Template**: https://coderthemes.com/hyper/

### Estructura de URLs
```
# Patrón: index.php?controller=X&action=Y&param=Z

# Ejemplos:
/public/index.php?controller=product&action=index
/public/index.php?controller=product&action=create
/public/index.php?controller=product&action=edit&id=5
/public/index.php?controller=sale&action=report

# Auth
/public/index.php?controller=auth&action=login
/public/index.php?controller=auth&action=logout
```

### Flujo de Petición (MVC)
1. **Usuario** → Hace petición a `public/index.php`
2. **Front Controller** → Lee parámetros GET
3. **Controller** → Ejecuta acción solicitada
4. **Model** → Consulta/modifica base de datos
5. **View** → Renderiza HTML con datos
6. **Usuario** → Recibe respuesta

## 🎓 Casos de Uso Avanzados

### Integración con API Externa
```php
// Ejemplo: Obtener tipo de cambio para costos
$url = 'https://mindicador.cl/api';
$data = json_decode(file_get_contents($url), true);
$dolar = $data['dolar']['valor'];
```

### Backup Automático
```bash
# Script para backup diario
mysqldump -u root chile_chilito > backup_$(date +%Y%m%d).sql
```

### Reportes Personalizados
Crear nuevos reportes en `SaleController.php`:
```php
public function customReport() {
    // Tu lógica de reporte
    $data = $this->model->getCustomData();
    include __DIR__ . '/../views/sales/custom_report.php';
}
```

## 🤝 Contribuir

### Cómo Agregar una Nueva Funcionalidad

1. **Crear Modelo** (`app/models/NewModel.php`):
```php
class NewModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM tabla");
        return $stmt->fetchAll();
    }
}
```

2. **Crear Controlador** (`app/controllers/NewController.php`):
```php
class NewController {
    private $model;
    
    public function __construct($pdo) {
        $this->model = new NewModel($pdo);
    }
    
    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/new/index.php';
    }
}
```

3. **Crear Vista** (`app/views/new/index.php`):
```php
<?php 
$pageTitle = 'Nueva Funcionalidad';
include __DIR__ . '/../layouts/header.php'; 
?>
<!-- Tu contenido aquí -->
<?php include __DIR__ . '/../layouts/footer.php'; ?>
```

4. **Agregar al Menú** (`app/views/layouts/sidebar.php`):
```php
<li class="side-nav-item">
    <a href="<?php echo APP_URL; ?>/public/index.php?controller=new&action=index" 
       class="side-nav-link">
        <i class="ri-icon"></i>
        <span> Nuevo Módulo </span>
    </a>
</li>
```

## 📞 Soporte

### Preguntas Frecuentes

**P: ¿Puedo usar este sistema en producción?**
R: Sí, pero considera agregar más validaciones y pruebas de seguridad.

**P: ¿Funciona en hosting compartido?**
R: Sí, siempre que tenga PHP 7.4+ y MySQL.

**P: ¿Puedo modificar el código?**
R: Sí, es de código abierto para uso educativo.

**P: ¿Soporta múltiples monedas?**
R: Actualmente solo pesos chilenos ($). Requiere modificación para multi-moneda.

## 📝 Licencia

Este proyecto fue creado con fines **educativos y de demostración**.

- ✅ Uso libre para aprendizaje
- ✅ Modificación permitida
- ✅ Uso comercial (con atribución)
- ❌ Sin garantía de funcionamiento

## 👨‍💻 Créditos

- **Sistema**: Chile Chilito - Gestión de Inventario y Producción
- **Template**: Hyper - Bootstrap 5 Admin Dashboard by Coderthemes
- **Iconos**: Remix Icons
- **Desarrollado para**: Empresas de producción de alimentos

## 🔄 Historial de Versiones

### v1.0.0 (Noviembre 2025)
- ✅ Sistema MVC completo
- ✅ CRUD de Productos, Insumos, Clientes
- ✅ Sistema de Producción con recetas
- ✅ Gestión de Ventas
- ✅ Dashboard con métricas
- ✅ Roles de usuario (Admin/Vendedor)
- ✅ Exportación a Excel/PDF
- ✅ Diseño Hyper Bootstrap 5
- ✅ Tablas DataTables
- ✅ Gráficos Chart.js

### Próximas Mejoras (Roadmap)
- 🔲 API REST para integración externa
- 🔲 Notificaciones por email
- 🔲 Reportes PDF personalizados
- 🔲 Gestión de proveedores
- 🔲 Órdenes de compra
- 🔲 Múltiples bodegas
- 🔲 Códigos de barra

---

**Versión Actual**: 1.0.0  
**Última Actualización**: 20 de Noviembre 2025  
**Estado**: ✅ Producción

## 🌟 Agradecimientos

Gracias por usar **Chile Chilito**. Si este sistema te fue útil, considera:
- ⭐ Dar una estrella al repositorio
- 🐛 Reportar bugs encontrados
- 💡 Sugerir mejoras
- 🤝 Contribuir con código

**¡Feliz gestión de inventario! 🌶️**
