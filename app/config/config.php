<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'chile_chilito');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'Chile.Chilito - Sistema de Gestión');
define('APP_URL', 'http://localhost/chile_chilito');
define('BASE_PATH', dirname(dirname(__DIR__)));

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de errores (cambiar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
