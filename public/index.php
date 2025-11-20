<?php
/**
 * Chile Chilito - Sistema de Gestión de Inventario, Ventas y Producción
 * Archivo principal (Router)
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once __DIR__ . '/../app/config/config.php';

// Obtener parámetros de la URL
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'showLogin';

// Mapeo de controladores
$controllers = [
    'auth' => 'AuthController',
    'dashboard' => 'DashboardController',
    'product' => 'ProductController',
    'customer' => 'CustomerController',
    'sale' => 'SaleController',
    'insumo' => 'InsumoController',
    'production' => 'ProductionController'
];

// Controladores públicos (sin autenticación requerida)
$publicControllers = ['auth'];
$publicActions = ['showLogin', 'login'];

// Validar controlador
if (!isset($controllers[$controller])) {
    die('Controlador no encontrado');
}

// Cargar el controlador
$controllerClass = $controllers[$controller];
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    die('Archivo del controlador no encontrado: ' . $controllerClass);
}

require_once $controllerFile;

// Verificar autenticación (excepto para rutas públicas)
if (!in_array($controller, $publicControllers) || !in_array($action, $publicActions)) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
        exit();
    }
}

// Instanciar controlador
$controllerInstance = new $controllerClass();

// Validar acción
if (!method_exists($controllerInstance, $action)) {
    die('Acción no encontrada: ' . $action);
}

// Ejecutar acción
$controllerInstance->$action();
