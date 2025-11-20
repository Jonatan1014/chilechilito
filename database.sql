-- Active: 1761924533466@@127.0.0.1@3306@chile_chilito
-- =====================================================
-- SISTEMA COMPLETO CHILE CHILITO
-- Base de datos con gestión de productos, insumos y recetas
-- =====================================================

DROP DATABASE IF EXISTS chile_chilito;
CREATE DATABASE chile_chilito CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE chile_chilito;

-- =====================================================
-- TABLAS DE PRODUCTOS Y CLIENTES (ORIGINALES)
-- =====================================================

-- Tabla de productos terminados
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock_actual INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 10,
    categoria VARCHAR(100),
    imagen VARCHAR(255),
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    requiere_produccion BOOLEAN DEFAULT TRUE COMMENT 'Si el producto necesita insumos para producirse',
    costo_produccion DECIMAL(10,2) DEFAULT 0 COMMENT 'Costo calculado de los insumos',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (categoria),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    telefono VARCHAR(20),
    direccion TEXT,
    rut VARCHAR(20) UNIQUE,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    total_compras DECIMAL(10,2) DEFAULT 0,
    cantidad_compras INT DEFAULT 0,
    fecha_ultima_compra TIMESTAMP NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(10, 2) NOT NULL,
    impuesto DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia') DEFAULT 'efectivo',
    estado_pago ENUM('pendiente', 'pagado', 'cancelado') DEFAULT 'pagado',
    estado ENUM('completada', 'pendiente', 'cancelada') DEFAULT 'completada',
    observaciones TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    INDEX idx_fecha (fecha_venta),
    INDEX idx_cliente (cliente_id),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de detalle de ventas
CREATE TABLE detalle_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    descuento DECIMAL(10, 2) DEFAULT 0,
    subtotal DECIMAL(10, 2) NOT NULL,
    insumos_deducidos BOOLEAN DEFAULT FALSE COMMENT 'Flag para evitar deducción duplicada',
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    INDEX idx_venta (venta_id),
    INDEX idx_producto (producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLAS DE INSUMOS Y RECETAS (NUEVAS)
-- =====================================================

-- Tabla de insumos (materias primas)
CREATE TABLE insumos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    sku VARCHAR(100) UNIQUE,
    descripcion TEXT,
    categoria VARCHAR(100) COMMENT 'Dulces, Salsas, Especias, Empaques, Otros',
    unidad_medida ENUM('unidades', 'gramos', 'kilogramos', 'litros', 'mililitros') NOT NULL,
    stock_actual DECIMAL(10,2) NOT NULL DEFAULT 0,
    stock_minimo DECIMAL(10,2) NOT NULL DEFAULT 10,
    stock_maximo DECIMAL(10,2) NOT NULL DEFAULT 100,
    costo_unitario DECIMAL(10,2) DEFAULT 0 COMMENT 'Costo por unidad de medida',
    proveedor VARCHAR(255),
    estado ENUM('activo', 'inactivo', 'descontinuado') DEFAULT 'activo',
    notas TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (categoria),
    INDEX idx_estado (estado),
    INDEX idx_stock (stock_actual)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de recetas (relación N:M entre productos e insumos)
CREATE TABLE recetas_productos (
    producto_id INT NOT NULL,
    insumo_id INT NOT NULL,
    cantidad_necesaria DECIMAL(10,2) NOT NULL COMMENT 'Cantidad del insumo necesaria para 1 unidad del producto',
    unidad_medida ENUM('unidades', 'gramos', 'kilogramos', 'litros', 'mililitros') NOT NULL,
    notas TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (producto_id, insumo_id),
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (insumo_id) REFERENCES insumos(id) ON DELETE CASCADE,
    INDEX idx_producto (producto_id),
    INDEX idx_insumo (insumo_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de movimientos de insumos (para trazabilidad)
CREATE TABLE movimientos_insumos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    insumo_id INT NOT NULL,
    tipo_movimiento ENUM('compra', 'venta', 'ajuste', 'produccion', 'devolucion') NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    unidad_medida ENUM('unidades', 'gramos', 'kilogramos', 'litros', 'mililitros') NOT NULL,
    referencia_id INT COMMENT 'ID de venta o producción que generó el movimiento',
    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notas TEXT,
    FOREIGN KEY (insumo_id) REFERENCES insumos(id) ON DELETE CASCADE,
    INDEX idx_insumo (insumo_id),
    INDEX idx_fecha (fecha_movimiento),
    INDEX idx_tipo (tipo_movimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de producciones (cuando se fabrican productos)
CREATE TABLE producciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    cantidad_producida INT NOT NULL,
    costo_produccion DECIMAL(10,2) NOT NULL,
    fecha_produccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notas TEXT,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    INDEX idx_producto (producto_id),
    INDEX idx_fecha (fecha_produccion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de historial de stock (para auditoría de productos)
CREATE TABLE historial_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida', 'ajuste') NOT NULL,
    cantidad INT NOT NULL,
    stock_anterior INT NOT NULL,
    stock_nuevo INT NOT NULL,
    motivo VARCHAR(255),
    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    INDEX idx_producto (producto_id),
    INDEX idx_fecha (fecha_movimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de usuarios/administradores
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL COMMENT 'Contraseña encriptada con password_hash',
    role ENUM('admin', 'supervisor', 'vendedor') DEFAULT 'vendedor',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- VISTAS ANALÍTICAS
-- =====================================================

-- Vista: Insumos con stock bajo
CREATE OR REPLACE VIEW v_insumos_stock_bajo AS
SELECT 
    i.id,
    i.nombre,
    i.sku,
    i.categoria,
    i.stock_actual,
    i.stock_minimo,
    i.unidad_medida,
    i.proveedor,
    (i.stock_minimo - i.stock_actual) as faltante
FROM insumos i
WHERE i.stock_actual <= i.stock_minimo 
AND i.estado = 'activo'
ORDER BY (i.stock_actual / i.stock_minimo) ASC;

-- Vista: Costo de producción calculado por producto
CREATE OR REPLACE VIEW v_costo_produccion_productos AS
SELECT 
    p.id as producto_id,
    p.nombre as producto_nombre,
    p.categoria,
    SUM(rp.cantidad_necesaria * i.costo_unitario) as costo_produccion_calculado,
    p.precio as precio_venta,
    (p.precio - SUM(rp.cantidad_necesaria * i.costo_unitario)) as margen_utilidad,
    ROUND(((p.precio - SUM(rp.cantidad_necesaria * i.costo_unitario)) / p.precio * 100), 2) as margen_porcentaje
FROM productos p
LEFT JOIN recetas_productos rp ON p.id = rp.producto_id
LEFT JOIN insumos i ON rp.insumo_id = i.id
WHERE p.requiere_produccion = TRUE
GROUP BY p.id, p.nombre, p.categoria, p.precio;

-- Vista: Productos más vendidos
CREATE OR REPLACE VIEW v_productos_mas_vendidos AS
SELECT 
    p.id,
    p.nombre,
    p.categoria,
    p.precio,
    COUNT(dv.id) as cantidad_ventas,
    SUM(dv.cantidad) as unidades_vendidas,
    SUM(dv.subtotal) as ingresos_totales
FROM productos p
INNER JOIN detalle_ventas dv ON p.id = dv.producto_id
INNER JOIN ventas v ON dv.venta_id = v.id
WHERE v.estado = 'completada'
GROUP BY p.id, p.nombre, p.categoria, p.precio
ORDER BY unidades_vendidas DESC;

-- Vista: Mejores clientes
CREATE OR REPLACE VIEW v_mejores_clientes AS
SELECT 
    c.id,
    CONCAT(c.nombre, ' ', c.apellido) as nombre_completo,
    c.email,
    c.telefono,
    COUNT(DISTINCT v.id) as cantidad_compras,
    SUM(v.total) as total_gastado,
    AVG(v.total) as promedio_compra,
    MAX(v.fecha_venta) as ultima_compra
FROM clientes c
INNER JOIN ventas v ON c.id = v.cliente_id
WHERE v.estado = 'completada'
GROUP BY c.id, c.nombre, c.apellido, c.email, c.telefono
ORDER BY total_gastado DESC;

-- Vista: Ventas por día de la semana
CREATE OR REPLACE VIEW v_ventas_por_dia AS
SELECT 
    DAYNAME(fecha_venta) as dia_semana,
    DAYOFWEEK(fecha_venta) as num_dia,
    COUNT(*) as cantidad_ventas,
    SUM(total) as total_vendido,
    AVG(total) as promedio_venta
FROM ventas
WHERE estado = 'completada'
GROUP BY DAYNAME(fecha_venta), DAYOFWEEK(fecha_venta)
ORDER BY num_dia;

-- Vista: Productos de bajo movimiento (últimos 3 meses)
CREATE OR REPLACE VIEW v_productos_bajo_movimiento AS
SELECT 
    p.id,
    p.nombre,
    p.categoria,
    p.precio,
    p.stock_actual,
    COALESCE(SUM(dv.cantidad), 0) as total_vendido,
    COUNT(DISTINCT dv.venta_id) as veces_vendido,
    MAX(v.fecha_venta) as ultima_venta
FROM productos p
LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id
LEFT JOIN ventas v ON dv.venta_id = v.id 
    AND v.estado = 'completada'
    AND v.fecha_venta >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
WHERE p.estado = 'activo'
GROUP BY p.id, p.nombre, p.categoria, p.precio, p.stock_actual
HAVING total_vendido < 5 OR total_vendido = 0
ORDER BY total_vendido ASC, ultima_venta ASC;

-- Vista: Clientes inactivos (sin compras en 90 días)
CREATE OR REPLACE VIEW v_clientes_inactivos AS
SELECT 
    c.id,
    CONCAT(c.nombre, ' ', c.apellido) as nombre_completo,
    c.email,
    c.telefono,
    MAX(v.fecha_venta) as ultima_compra,
    DATEDIFF(NOW(), MAX(v.fecha_venta)) as dias_inactivo,
    COUNT(v.id) as total_compras_historico
FROM clientes c
LEFT JOIN ventas v ON c.id = v.cliente_id AND v.estado = 'completada'
WHERE c.estado = 'activo'
GROUP BY c.id, c.nombre, c.apellido, c.email, c.telefono
HAVING dias_inactivo > 90 OR dias_inactivo IS NULL
ORDER BY dias_inactivo DESC;

-- Vista: Preferencias de productos por cliente
CREATE OR REPLACE VIEW v_preferencias_clientes AS
SELECT 
    c.id as cliente_id,
    CONCAT(c.nombre, ' ', c.apellido) as nombre_cliente,
    p.id as producto_id,
    p.nombre as producto_nombre,
    p.categoria,
    COUNT(dv.id) as veces_comprado,
    SUM(dv.cantidad) as cantidad_total,
    SUM(dv.subtotal) as gasto_total_producto,
    MAX(v.fecha_venta) as ultima_compra_producto
FROM clientes c
INNER JOIN ventas v ON c.id = v.cliente_id
INNER JOIN detalle_ventas dv ON v.id = dv.venta_id
INNER JOIN productos p ON dv.producto_id = p.id
WHERE v.estado = 'completada'
GROUP BY c.id, c.nombre, c.apellido, p.id, p.nombre, p.categoria
ORDER BY c.id, veces_comprado DESC;

-- Vista: Ventas por mes (últimos 12 meses)
CREATE OR REPLACE VIEW v_ventas_por_mes AS
SELECT 
    DATE_FORMAT(fecha_venta, '%Y-%m') as mes,
    DATE_FORMAT(fecha_venta, '%M %Y') as mes_nombre,
    COUNT(*) as cantidad_ventas,
    SUM(total) as total_vendido,
    AVG(total) as promedio_venta,
    COUNT(DISTINCT cliente_id) as clientes_unicos
FROM ventas
WHERE estado = 'completada'
    AND fecha_venta >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(fecha_venta, '%Y-%m'), DATE_FORMAT(fecha_venta, '%M %Y')
ORDER BY mes DESC;

-- Vista: Análisis de categorías de productos
CREATE OR REPLACE VIEW v_analisis_categorias AS
SELECT 
    p.categoria,
    COUNT(DISTINCT p.id) as productos_activos,
    SUM(p.stock_actual) as stock_total,
    COALESCE(SUM(dv.cantidad), 0) as unidades_vendidas,
    COALESCE(SUM(dv.subtotal), 0) as ingresos_categoria,
    COUNT(DISTINCT dv.venta_id) as ventas_realizadas
FROM productos p
LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id
LEFT JOIN ventas v ON dv.venta_id = v.id AND v.estado = 'completada'
WHERE p.estado = 'activo'
GROUP BY p.categoria
ORDER BY ingresos_categoria DESC;

-- Vista: Mejores y peores días de venta
CREATE OR REPLACE VIEW v_dias_venta_ranking AS
SELECT 
    DATE(fecha_venta) as fecha,
    DAYNAME(fecha_venta) as dia_semana,
    COUNT(*) as ventas_dia,
    SUM(total) as total_dia,
    AVG(total) as promedio_venta
FROM ventas
WHERE estado = 'completada'
    AND fecha_venta >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
GROUP BY DATE(fecha_venta), DAYNAME(fecha_venta)
ORDER BY total_dia DESC;

-- Vista: Stock crítico de productos
CREATE OR REPLACE VIEW v_productos_stock_critico AS
SELECT 
    p.id,
    p.nombre,
    p.categoria,
    p.stock_actual,
    p.stock_minimo,
    (p.stock_minimo - p.stock_actual) as unidades_faltantes,
    COALESCE(AVG(dv.cantidad), 0) as promedio_venta_diaria,
    CASE 
        WHEN COALESCE(AVG(dv.cantidad), 0) > 0 
        THEN ROUND(p.stock_actual / AVG(dv.cantidad), 1)
        ELSE NULL 
    END as dias_stock_restante
FROM productos p
LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id
LEFT JOIN ventas v ON dv.venta_id = v.id 
    AND v.estado = 'completada'
    AND v.fecha_venta >= DATE_SUB(NOW(), INTERVAL 30 DAY)
WHERE p.estado = 'activo'
    AND p.stock_actual <= p.stock_minimo
GROUP BY p.id, p.nombre, p.categoria, p.stock_actual, p.stock_minimo
ORDER BY dias_stock_restante ASC, unidades_faltantes DESC;

-- =====================================================
-- DATOS DE EJEMPLO - PRODUCTOS CHILE CHILITO
-- =====================================================

INSERT INTO productos (nombre, descripcion, precio, stock_actual, stock_minimo, categoria, requiere_produccion) VALUES
('Sandiitas 250g', 'Gomitas sabor sandía cubiertas con chile y azúcar, jugosas y picosas', 1700.00, 45, 15, 'Gomitas Enchiladas', TRUE),
('Ski Dots 50g', 'Pequeños caramelos ácidos cubiertos con chile y azúcar', 6000.00, 30, 10, 'Caramelos Ácidos', TRUE),
('SP 50g', 'Gomitas en forma de personajes ácidos, recubiertas con chile y azúcar', 6500.00, 25, 10, 'Gomitas Ácidas', TRUE),
('Splashers 200g', 'Gomitas rellenas con líquido frutal picante, cubiertas con chile y azúcar', 3400.00, 35, 12, 'Gomitas Rellenas', TRUE),
('Fettuxile 200g', 'Dulces tipo "espagueti" enchilado, incluye sachet de salsa tipo chamoy', 2500.00, 40, 15, 'Dulces Especiales', TRUE),
('Tiritas de Sandía 200g', 'Finas tiras de gomita sabor sandía cubiertas con chile y azúcar', 2300.00, 50, 18, 'Tiritas Enchiladas', TRUE),
('Tiritas de Fresa 200g', 'Tiras de gomita enchiladas sabor fresa, dulces y picosas', 2500.00, 48, 18, 'Tiritas Enchiladas', TRUE),
('Tiritas de Manzana 200g', 'Tiras de gomita enchiladas sabor manzana verde', 2300.00, 42, 15, 'Tiritas Enchiladas', TRUE),
('Watermelon Mix 250g', 'Mezcla de gomitas sabor sandía enchiladas', 1800.00, 38, 15, 'Mix Enchilados', TRUE),
('Watermelon Pops 250g', 'Bolitas enchiladas sabor sandía, con chile y azúcar', 1900.00, 40, 15, 'Mix Enchilados', TRUE),
('Tirimix 200g', 'Mix de tiras (fresa, frambuesa, sandía, manzana) cubiertas con chile', 4900.00, 28, 10, 'Mix Premium', TRUE),
('Xile Chilito 150g', 'Chile en polvo intenso, ideal para espolvorear sobre frutas y gomitas', 6000.00, 20, 8, 'Condimentos', FALSE);

-- =====================================================
-- DATOS DE EJEMPLO - INSUMOS/MATERIAS PRIMAS
-- =====================================================

INSERT INTO insumos (nombre, sku, descripcion, categoria, unidad_medida, stock_actual, stock_minimo, stock_maximo, costo_unitario, proveedor) VALUES
-- Gomitas base
('Gomitas Sandía Base', 'GOM-SAN-001', 'Gomitas sabor sandía sin enchilado (a granel)', 'Dulces', 'gramos', 5000, 1000, 10000, 8.50, 'Distribuidora Dulces del Valle'),
('Gomitas Fresa Base', 'GOM-FRE-001', 'Gomitas sabor fresa sin enchilado', 'Dulces', 'gramos', 4500, 1000, 10000, 9.00, 'Distribuidora Dulces del Valle'),
('Gomitas Manzana Base', 'GOM-MAN-001', 'Gomitas sabor manzana verde sin enchilado', 'Dulces', 'gramos', 4200, 1000, 10000, 8.75, 'Distribuidora Dulces del Valle'),
('Caramelos Ácidos Base', 'CAR-ACI-001', 'Caramelos ácidos tipo Ski Dots sin enchilado', 'Dulces', 'gramos', 3000, 800, 8000, 12.00, 'Importadora Candy Plus'),
('Gomitas Personajes SP', 'GOM-SP-001', 'Gomitas ácidas en forma de personajes', 'Dulces', 'gramos', 2500, 800, 8000, 13.50, 'Importadora Candy Plus'),
('Gomitas Rellenas Splashers', 'GOM-SPL-001', 'Gomitas con relleno líquido frutal', 'Dulces', 'gramos', 3500, 1000, 8000, 15.00, 'Distribuidora Dulces del Valle'),
('Dulce Espagueti Base', 'DUL-ESP-001', 'Dulce tipo espagueti sin enchilado', 'Dulces', 'gramos', 4000, 1000, 10000, 7.50, 'Distribuidora Dulces del Valle'),

-- Salsas y chile
('Chile Chamoy en Polvo', 'CHI-CHA-001', 'Chile chamoy en polvo para enchilado', 'Salsas', 'gramos', 8000, 2000, 15000, 6.20, 'Especias y Salsas del Norte'),
('Chile Tajín Sustituto', 'CHI-TAJ-001', 'Mezcla de chile, limón y sal tipo Tajín', 'Salsas', 'gramos', 7500, 2000, 15000, 5.80, 'Especias y Salsas del Norte'),
('Ají Picante en Polvo', 'AJI-PIC-001', 'Ají picante molido extra fuerte', 'Especias', 'gramos', 6000, 1500, 12000, 8.50, 'Especias y Salsas del Norte'),
('Salsa Chamoy Líquida', 'SAL-CHA-001', 'Salsa tipo chamoy para sachets', 'Salsas', 'mililitros', 10000, 3000, 20000, 4.50, 'Especias y Salsas del Norte'),
('Chile Piquín Molido', 'CHI-PIQ-001', 'Chile piquín molido puro', 'Especias', 'gramos', 5000, 1000, 10000, 18.00, 'Especias y Salsas del Norte'),

-- Otros ingredientes
('Azúcar Refinada', 'AZU-REF-001', 'Azúcar blanca refinada para mezclas', 'Otros', 'gramos', 15000, 5000, 30000, 1.50, 'Distribuidora General'),
('Ácido Cítrico', 'ACI-CIT-001', 'Ácido cítrico para dar acidez', 'Especias', 'gramos', 3000, 500, 5000, 12.00, 'Insumos Químicos SA'),
('Colorante Rojo Natural', 'COL-ROJ-001', 'Colorante natural rojo para enchilados', 'Otros', 'gramos', 2000, 500, 4000, 22.00, 'Insumos Químicos SA'),

-- Empaques
('Bolsas Plásticas 250g', 'EMP-BOL-250', 'Bolsas transparentes con cierre para 250g', 'Empaques', 'unidades', 5000, 1000, 10000, 80.00, 'Empaques del Pacífico'),
('Bolsas Plásticas 200g', 'EMP-BOL-200', 'Bolsas transparentes con cierre para 200g', 'Empaques', 'unidades', 4500, 1000, 10000, 75.00, 'Empaques del Pacífico'),
('Bolsas Plásticas 150g', 'EMP-BOL-150', 'Bolsas transparentes con cierre para 150g', 'Empaques', 'unidades', 4000, 800, 8000, 70.00, 'Empaques del Pacífico'),
('Bolsas Plásticas 50g', 'EMP-BOL-050', 'Bolsas pequeñas para productos de 50g', 'Empaques', 'unidades', 3000, 800, 8000, 60.00, 'Empaques del Pacífico'),
('Sachets para Salsa', 'EMP-SAC-001', 'Sachets de 10ml para salsa chamoy', 'Empaques', 'unidades', 2000, 500, 5000, 45.00, 'Empaques del Pacífico'),
('Etiquetas Chile Chilito', 'EMP-ETI-001', 'Etiquetas adhesivas con logo Chile Chilito', 'Empaques', 'unidades', 3000, 800, 8000, 95.00, 'Imprenta Digital Express');

-- =====================================================
-- RECETAS DE PRODUCTOS
-- =====================================================

-- Receta: Sandiitas 250g (por cada bolsa de 250g)
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(1, 1, 200, 'gramos', 'Gomitas sandía base'),
(1, 8, 40, 'gramos', 'Chile chamoy para enchilado'),
(1, 13, 10, 'gramos', 'Azúcar para mezcla'),
(1, 16, 1, 'unidades', 'Bolsa de empaque 250g'),
(1, 21, 1, 'unidades', 'Etiqueta Chile Chilito');

-- Receta: Ski Dots 50g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(2, 4, 40, 'gramos', 'Caramelos ácidos base'),
(2, 8, 8, 'gramos', 'Chile chamoy'),
(2, 13, 2, 'gramos', 'Azúcar'),
(2, 19, 1, 'unidades', 'Bolsa 50g'),
(2, 21, 1, 'unidades', 'Etiqueta');

-- Receta: SP 50g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(3, 5, 40, 'gramos', 'Gomitas personajes SP'),
(3, 9, 8, 'gramos', 'Chile Tajín'),
(3, 13, 2, 'gramos', 'Azúcar'),
(3, 19, 1, 'unidades', 'Bolsa 50g'),
(3, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Splashers 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(4, 6, 160, 'gramos', 'Gomitas rellenas Splashers'),
(4, 8, 30, 'gramos', 'Chile chamoy'),
(4, 10, 10, 'gramos', 'Ají picante'),
(4, 17, 1, 'unidades', 'Bolsa 200g'),
(4, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Fettuxile 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(5, 7, 180, 'gramos', 'Dulce espagueti base'),
(5, 8, 15, 'gramos', 'Chile chamoy polvo'),
(5, 11, 10, 'mililitros', 'Salsa chamoy para sachet'),
(5, 17, 1, 'unidades', 'Bolsa 200g'),
(5, 20, 1, 'unidades', 'Sachet para salsa'),
(5, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Tiritas de Sandía 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(6, 1, 150, 'gramos', 'Gomitas sandía en tiras'),
(6, 8, 35, 'gramos', 'Chile chamoy'),
(6, 10, 15, 'gramos', 'Ají picante'),
(6, 17, 1, 'unidades', 'Bolsa 200g'),
(6, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Tiritas de Fresa 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(7, 2, 150, 'gramos', 'Gomitas fresa en tiras'),
(7, 9, 35, 'gramos', 'Chile Tajín'),
(7, 13, 15, 'gramos', 'Azúcar'),
(7, 17, 1, 'unidades', 'Bolsa 200g'),
(7, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Tiritas de Manzana 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(8, 3, 150, 'gramos', 'Gomitas manzana en tiras'),
(8, 8, 35, 'gramos', 'Chile chamoy'),
(8, 14, 15, 'gramos', 'Ácido cítrico para acidez extra'),
(8, 17, 1, 'unidades', 'Bolsa 200g'),
(8, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Watermelon Mix 250g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(9, 1, 200, 'gramos', 'Gomitas sandía variadas'),
(9, 8, 40, 'gramos', 'Chile chamoy'),
(9, 13, 10, 'gramos', 'Azúcar'),
(9, 16, 1, 'unidades', 'Bolsa 250g'),
(9, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Watermelon Pops 250g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(10, 1, 200, 'gramos', 'Gomitas sandía bolitas'),
(10, 9, 40, 'gramos', 'Chile Tajín'),
(10, 13, 10, 'gramos', 'Azúcar'),
(10, 16, 1, 'unidades', 'Bolsa 250g'),
(10, 21, 1, 'unidades', 'Etiqueta');

-- Receta: Tirimix 200g
INSERT INTO recetas_productos (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) VALUES
(11, 1, 50, 'gramos', 'Tiras sandía'),
(11, 2, 50, 'gramos', 'Tiras fresa'),
(11, 3, 50, 'gramos', 'Tiras manzana'),
(11, 8, 30, 'gramos', 'Chile chamoy'),
(11, 10, 20, 'gramos', 'Ají picante'),
(11, 17, 1, 'unidades', 'Bolsa 200g'),
(11, 21, 1, 'unidades', 'Etiqueta');

-- Xile Chilito NO tiene receta (se vende el chile directo)

-- Actualizar costos de producción calculados
UPDATE productos p
SET costo_produccion = (
    SELECT SUM(rp.cantidad_necesaria * i.costo_unitario)
    FROM recetas_productos rp
    JOIN insumos i ON rp.insumo_id = i.id
    WHERE rp.producto_id = p.id
)
WHERE requiere_produccion = TRUE;

-- =====================================================
-- DATOS DE EJEMPLO - CLIENTES
-- =====================================================

INSERT INTO clientes (nombre, apellido, email, telefono, direccion, rut) VALUES
('Valentina', 'Rodríguez', 'valentina.rodriguez@email.com', '+57312345678', 'Cra 15 #34-56, Bogotá', '12345678-9'),
('Santiago', 'Martínez', 'santiago.martinez@email.com', '+57320987654', 'Calle 72 #10-20, Medellín', '98765432-1'),
('Camila', 'López', 'camila.lopez@email.com', '+57315223344', 'Av. Boyacá #45-78, Bogotá', '11223344-5'),
('Sebastián', 'García', 'sebastian.garcia@email.com', '+57318334455', 'Cra 7 #85-12, Bogotá', '22334455-6'),
('Isabella', 'Hernández', 'isabella.hernandez@email.com', '+57314445566', 'Calle 116 #23-45, Cali', '33445566-7'),
('Mateo', 'Ramírez', 'mateo.ramirez@email.com', '+57319556677', 'Cra 50 #12-34, Barranquilla', '44556677-8'),
('Sofía', 'Torres', 'sofia.torres@email.com', '+57317667788', 'Av. Chile #56-78, Bogotá', '55667788-9');

-- =====================================================
-- DATOS DE EJEMPLO - VENTAS
-- =====================================================

-- Ventas de noviembre 2025
INSERT INTO ventas (cliente_id, fecha_venta, subtotal, impuesto, total, metodo_pago, estado) VALUES
(1, '2025-11-01 10:30:00', 10252.10, 1947.90, 12200.00, 'efectivo', 'completada'),
(2, '2025-11-02 14:15:00', 15882.35, 3017.65, 18900.00, 'tarjeta', 'completada'),
(3, '2025-11-03 09:45:00', 7983.19, 1516.81, 9500.00, 'transferencia', 'completada'),
(1, '2025-11-05 16:20:00', 12436.97, 2363.03, 14800.00, 'efectivo', 'completada'),
(4, '2025-11-08 11:00:00', 17983.19, 3416.81, 21400.00, 'tarjeta', 'completada'),
(2, '2025-11-10 13:30:00', 9411.76, 1788.24, 11200.00, 'efectivo', 'completada'),
(5, '2025-11-12 10:15:00', 14033.61, 2666.39, 16700.00, 'transferencia', 'completada'),
(3, '2025-11-14 15:45:00', 7478.99, 1421.01, 8900.00, 'tarjeta', 'completada'),
(6, '2025-11-15 11:00:00', 11344.54, 2155.46, 13500.00, 'efectivo', 'completada'),
(7, '2025-11-16 10:30:00', 16134.45, 3065.55, 19200.00, 'tarjeta', 'completada'),
(1, '2025-11-16 15:00:00', 13109.24, 2490.76, 15600.00, 'efectivo', 'completada'),
(4, '2025-11-17 14:30:00', 10336.13, 1963.87, 12300.00, 'tarjeta', 'completada');

-- Detalle de ventas
INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario, descuento, subtotal, insumos_deducidos) VALUES
-- Venta 1 (Valentina - 01 nov)
(1, 1, 3, 1700.00, 0, 5100.00, TRUE),
(1, 6, 2, 2300.00, 0, 4600.00, TRUE),
(1, 9, 1, 1800.00, 0, 1800.00, TRUE),

-- Venta 2 (Santiago - 02 nov)
(2, 2, 2, 6000.00, 0, 12000.00, TRUE),
(2, 4, 2, 3400.00, 0, 6800.00, TRUE),

-- Venta 3 (Camila - 03 nov)
(3, 7, 2, 2500.00, 0, 5000.00, TRUE),
(3, 8, 2, 2300.00, 0, 4600.00, TRUE),

-- Venta 4 (Valentina - 05 nov)
(4, 11, 2, 4900.00, 0, 9800.00, TRUE),
(4, 1, 3, 1700.00, 0, 5100.00, TRUE),

-- Venta 5 (Sebastián - 08 nov)
(5, 2, 2, 6000.00, 0, 12000.00, TRUE),
(5, 3, 1, 6500.00, 0, 6500.00, TRUE),
(5, 10, 1, 1900.00, 0, 1900.00, TRUE),

-- Venta 6 (Santiago - 10 nov)
(6, 6, 3, 2300.00, 0, 6900.00, TRUE),
(6, 5, 1, 2500.00, 0, 2500.00, TRUE),
(6, 9, 1, 1800.00, 0, 1800.00, TRUE),

-- Venta 7 (Isabella - 12 nov)
(7, 11, 2, 4900.00, 0, 9800.00, TRUE),
(7, 12, 1, 6000.00, 0, 6000.00, FALSE),

-- Venta 8 (Camila - 14 nov)
(8, 4, 2, 3400.00, 0, 6800.00, TRUE),
(8, 7, 1, 2500.00, 0, 2500.00, TRUE),

-- Venta 9 (Mateo - 15 nov)
(9, 1, 4, 1700.00, 0, 6800.00, TRUE),
(9, 6, 3, 2300.00, 0, 6900.00, TRUE),

-- Venta 10 (Sofía - 16 nov)
(10, 2, 2, 6000.00, 0, 12000.00, TRUE),
(10, 3, 1, 6500.00, 0, 6500.00, TRUE),

-- Venta 11 (Valentina - 16 nov)
(11, 11, 2, 4900.00, 0, 9800.00, TRUE),
(11, 7, 2, 2500.00, 0, 5000.00, TRUE),

-- Venta 12 (Sebastián - 17 nov)
(12, 8, 3, 2300.00, 0, 6900.00, TRUE),
(12, 10, 3, 1900.00, 0, 5700.00, TRUE);

-- Actualizar estadísticas de clientes
UPDATE clientes c SET 
    cantidad_compras = (SELECT COUNT(*) FROM ventas v WHERE v.cliente_id = c.id AND v.estado = 'completada'),
    total_compras = (SELECT COALESCE(SUM(v.total), 0) FROM ventas v WHERE v.cliente_id = c.id AND v.estado = 'completada'),
    fecha_ultima_compra = (SELECT MAX(v.fecha_venta) FROM ventas v WHERE v.cliente_id = c.id AND v.estado = 'completada');

-- =====================================================
-- REGISTRAR MOVIMIENTOS DE INSUMOS POR LAS VENTAS
-- =====================================================

-- Simular la deducción de insumos por las ventas realizadas
-- (En producción esto lo hace automáticamente SaleService.php)

-- Ejemplo para Venta 1 - 3 Sandiitas
INSERT INTO movimientos_insumos (insumo_id, tipo_movimiento, cantidad, unidad_medida, referencia_id, notas) VALUES
(1, 'venta', 600, 'gramos', 1, 'Deducción automática por venta #1 - 3x Sandiitas'),
(8, 'venta', 120, 'gramos', 1, 'Deducción automática por venta #1 - 3x Sandiitas'),
(13, 'venta', 30, 'gramos', 1, 'Deducción automática por venta #1 - 3x Sandiitas'),
(16, 'venta', 3, 'unidades', 1, 'Deducción automática por venta #1 - 3x Sandiitas'),
(21, 'venta', 3, 'unidades', 1, 'Deducción automática por venta #1 - 3x Sandiitas');

-- Ejemplo para Venta 1 - 2 Tiritas de Sandía
INSERT INTO movimientos_insumos (insumo_id, tipo_movimiento, cantidad, unidad_medida, referencia_id, notas) VALUES
(1, 'venta', 300, 'gramos', 1, 'Deducción automática por venta #1 - 2x Tiritas Sandía'),
(8, 'venta', 70, 'gramos', 1, 'Deducción automática por venta #1 - 2x Tiritas Sandía'),
(10, 'venta', 30, 'gramos', 1, 'Deducción automática por venta #1 - 2x Tiritas Sandía'),
(17, 'venta', 2, 'unidades', 1, 'Deducción automática por venta #1 - 2x Tiritas Sandía'),
(21, 'venta', 2, 'unidades', 1, 'Deducción automática por venta #1 - 2x Tiritas Sandía');

-- Actualizar stock de insumos después de las ventas
UPDATE insumos SET stock_actual = stock_actual - 900 WHERE id = 1;  -- Gomitas sandía
UPDATE insumos SET stock_actual = stock_actual - 190 WHERE id = 8;  -- Chile chamoy
UPDATE insumos SET stock_actual = stock_actual - 30 WHERE id = 10;  -- Ají
UPDATE insumos SET stock_actual = stock_actual - 30 WHERE id = 13;  -- Azúcar
UPDATE insumos SET stock_actual = stock_actual - 3 WHERE id = 16;   -- Bolsas 250g
UPDATE insumos SET stock_actual = stock_actual - 2 WHERE id = 17;   -- Bolsas 200g
UPDATE insumos SET stock_actual = stock_actual - 5 WHERE id = 21;   -- Etiquetas

-- =====================================================
-- USUARIOS DEL SISTEMA
-- =====================================================

-- Usuario admin por defecto
-- Usuario: admin@chilechilito.cl
-- Contraseña: 123
-- Hash generado con password_hash('123', PASSWORD_DEFAULT)
INSERT INTO users (username, email, password, role, is_active) VALUES
('admin', 'admin@chilechilito.cl', '$2y$10$4ch8QBRsDGBW119RzOTpM.t2.tjaTYJVYc7hOcWKWzn17SUUlRMJi', 'admin', 1);

-- Usuario de prueba vendedor
-- Usuario: vendedor@chilechilito.cl
-- Contraseña: 123
INSERT INTO users (username, email, password, role, is_active) VALUES
('vendedor', 'vendedor@chilechilito.cl', '$2y$10$4ch8QBRsDGBW119RzOTpM.t2.tjaTYJVYc7hOcWKWzn17SUUlRMJi', 'vendedor', 1);

-- =====================================================
-- FIN DE LA BASE DE DATOS
-- =====================================================

-- Verificación de datos
SELECT 'RESUMEN DE LA BASE DE DATOS' as '';
SELECT COUNT(*) as total_productos FROM productos;
SELECT COUNT(*) as total_insumos FROM insumos;
SELECT COUNT(*) as total_recetas FROM recetas_productos;
SELECT COUNT(*) as total_clientes FROM clientes;
SELECT COUNT(*) as total_ventas FROM ventas;
SELECT COUNT(*) as total_detalle_ventas FROM detalle_ventas;
SELECT COUNT(*) as total_movimientos_insumos FROM movimientos_insumos;

SELECT '------------------------------' as '';
SELECT 'Top 5 Productos Más Vendidos' as '';
SELECT * FROM v_productos_mas_vendidos LIMIT 5;

SELECT '------------------------------' as '';
SELECT 'Mejores Clientes' as '';
SELECT * FROM v_mejores_clientes;

SELECT '------------------------------' as '';
SELECT 'Insumos con Stock Bajo' as '';
SELECT * FROM v_insumos_stock_bajo;

SELECT '------------------------------' as '';
SELECT 'Costos de Producción' as '';
SELECT * FROM v_costo_produccion_productos;
