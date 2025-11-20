<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación del Sistema - Chile Chilito</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #d32f2f;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .check-item.success {
            background: #c8e6c9;
            border-left: 4px solid #4caf50;
        }
        .check-item.error {
            background: #ffcdd2;
            border-left: 4px solid #f44336;
        }
        .check-item.warning {
            background: #ffe0b2;
            border-left: 4px solid #ff9800;
        }
        .icon {
            font-size: 24px;
            font-weight: bold;
        }
        .success .icon { color: #4caf50; }
        .error .icon { color: #f44336; }
        .warning .icon { color: #ff9800; }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2196f3;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: #d32f2f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #b71c1c;
            box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
        }
        .section {
            margin: 30px 0;
        }
        .section h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌶️ Chile.Chilito</h1>
        <p class="subtitle">Sistema de Gestión de Inventario y Ventas - Verificación de Instalación</p>

        <?php
        $errores = 0;
        $advertencias = 0;
        
        // Verificar versión de PHP
        echo '<div class="section"><h2>🔧 Requisitos del Sistema</h2>';
        
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '7.4.0') >= 0) {
            echo '<div class="check-item success">
                    <span class="icon">✓</span>
                    <div><strong>PHP Version:</strong> ' . $phpVersion . ' (OK)</div>
                  </div>';
        } else {
            echo '<div class="check-item error">
                    <span class="icon">✗</span>
                    <div><strong>PHP Version:</strong> ' . $phpVersion . ' (Se requiere 7.4 o superior)</div>
                  </div>';
            $errores++;
        }

        // Verificar PDO
        if (extension_loaded('pdo_mysql')) {
            echo '<div class="check-item success">
                    <span class="icon">✓</span>
                    <div><strong>PDO MySQL:</strong> Instalado</div>
                  </div>';
        } else {
            echo '<div class="check-item error">
                    <span class="icon">✗</span>
                    <div><strong>PDO MySQL:</strong> No instalado (Requerido)</div>
                  </div>';
            $errores++;
        }

        // Verificar estructura de carpetas
        echo '</div><div class="section"><h2>📁 Estructura de Archivos</h2>';
        
        $carpetas = [
            'app/config' => 'Configuración',
            'app/models' => 'Modelos',
            'app/controllers' => 'Controladores',
            'app/views' => 'Vistas',
            'public/css' => 'Estilos CSS',
            'public/js' => 'JavaScript'
        ];

        foreach ($carpetas as $carpeta => $nombre) {
            if (is_dir('../' . $carpeta)) {
                echo '<div class="check-item success">
                        <span class="icon">✓</span>
                        <div><strong>' . $nombre . ':</strong> ' . $carpeta . '</div>
                      </div>';
            } else {
                echo '<div class="check-item error">
                        <span class="icon">✗</span>
                        <div><strong>' . $nombre . ':</strong> No encontrada</div>
                      </div>';
                $errores++;
            }
        }

        // Verificar archivos importantes
        echo '</div><div class="section"><h2>📄 Archivos Principales</h2>';
        
        $archivos = [
            '../app/config/config.php' => 'Configuración',
            '../app/config/Database.php' => 'Conexión BD',
            '../public/index.php' => 'Router Principal',
            '../database.sql' => 'Script de BD'
        ];

        foreach ($archivos as $archivo => $nombre) {
            if (file_exists($archivo)) {
                echo '<div class="check-item success">
                        <span class="icon">✓</span>
                        <div><strong>' . $nombre . ':</strong> Encontrado</div>
                      </div>';
            } else {
                echo '<div class="check-item error">
                        <span class="icon">✗</span>
                        <div><strong>' . $nombre . ':</strong> No encontrado</div>
                      </div>';
                $errores++;
            }
        }

        // Intentar conexión a la base de datos
        echo '</div><div class="section"><h2>🗄️ Conexión a Base de Datos</h2>';
        
        if (file_exists('../app/config/config.php')) {
            require_once '../app/config/config.php';
            require_once '../app/config/Database.php';
            
            try {
                $database = new Database();
                $db = $database->connect();
                
                echo '<div class="check-item success">
                        <span class="icon">✓</span>
                        <div><strong>Conexión MySQL:</strong> Exitosa</div>
                      </div>';

                // Verificar tablas
                $tablas = ['productos', 'clientes', 'ventas', 'detalle_ventas'];
                $tablasExistentes = 0;
                
                foreach ($tablas as $tabla) {
                    $query = "SHOW TABLES LIKE '$tabla'";
                    $stmt = $db->query($query);
                    if ($stmt->rowCount() > 0) {
                        $tablasExistentes++;
                        echo '<div class="check-item success">
                                <span class="icon">✓</span>
                                <div><strong>Tabla:</strong> ' . $tabla . ' (Existe)</div>
                              </div>';
                    } else {
                        echo '<div class="check-item error">
                                <span class="icon">✗</span>
                                <div><strong>Tabla:</strong> ' . $tabla . ' (No encontrada)</div>
                              </div>';
                        $errores++;
                    }
                }

            } catch (Exception $e) {
                echo '<div class="check-item error">
                        <span class="icon">✗</span>
                        <div><strong>Error de Conexión:</strong> ' . $e->getMessage() . '</div>
                      </div>';
                $errores++;
                
                echo '<div class="info">
                        <strong>💡 Solución:</strong><br>
                        1. Asegúrate de que MySQL esté corriendo en XAMPP<br>
                        2. Verifica que la base de datos "chile_chilito" exista<br>
                        3. Importa el archivo database.sql en phpMyAdmin<br>
                        4. Verifica las credenciales en app/config/config.php
                      </div>';
            }
        }

        // Resultado final
        echo '</div><div class="section"><h2>📊 Resultado de la Verificación</h2>';
        
        if ($errores == 0) {
            echo '<div class="check-item success">
                    <span class="icon">✓</span>
                    <div>
                        <strong>¡Sistema Listo!</strong><br>
                        Todos los componentes están instalados correctamente.
                    </div>
                  </div>';
            echo '<a href="index.php" class="btn">🚀 Ir al Sistema</a>';
        } else {
            echo '<div class="check-item error">
                    <span class="icon">✗</span>
                    <div>
                        <strong>Errores Encontrados:</strong> ' . $errores . '<br>
                        Por favor, corrige los errores antes de continuar.
                    </div>
                  </div>';
            
            echo '<div class="info">
                    <strong>📖 Consulta la Guía de Instalación:</strong><br>
                    Lee el archivo INSTALACION.md para instrucciones detalladas.
                  </div>';
        }

        echo '</div>';
        ?>

        <div class="info">
            <strong>📚 Documentación:</strong><br>
            • README.md - Documentación completa del sistema<br>
            • INSTALACION.md - Guía rápida de instalación<br>
            • database.sql - Script de la base de datos
        </div>
    </div>
</body>
</html>
