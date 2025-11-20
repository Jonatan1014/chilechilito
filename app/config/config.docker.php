<?php
/**
 * Configuración de la Aplicación - Docker
 * Chile Chilito - Sistema de Gestión de Inventario
 */

// Configuración de errores (desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de sesión
ini_set('session.gc_maxlifetime', 3600);
session_start();

// Configuración de Base de Datos (desde variables de entorno Docker)
define('DB_HOST', getenv('DB_HOST') ?: 'systemautomatic.xyz:3307');
define('DB_NAME', getenv('DB_NAME') ?: 'chile_chilito');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'Balon100.');
define('DB_CHARSET', 'utf8mb4');

// URL Base de la Aplicación
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8080');

// Rutas del sistema
define('APP_ROOT', dirname(dirname(__DIR__)));
define('PUBLIC_PATH', APP_ROOT . '/public');

// Configuración de la aplicación
define('APP_NAME', 'ChileChilito');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'docker'); // desarrollo, producción, docker

// Configuración de uploads (si se implementa)
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10 MB

// Debug mode (cambiar a false en producción)
define('DEBUG_MODE', true);

// Función helper para debugging
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

// Logging simple
function logError($message) {
    $logFile = APP_ROOT . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
