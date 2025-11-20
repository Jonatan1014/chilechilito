<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Production.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../config/Database.php';

class ProductionController {
    private $productionModel;
    private $recipeModel;
    
    public function __construct() {
        AuthController::checkAuth();
        $this->productionModel = new Production();
        $this->recipeModel = new Recipe();
    }
    
    /**
     * Listar todas las producciones
     */
    public function index() {
        $producciones = $this->productionModel->getAll();
        $estadisticas = $this->productionModel->getEstadisticas(30);
        include __DIR__ . '/../views/production/index.php';
    }
    
    /**
     * Ver detalle de una producción
     */
    public function view() {
        $id = $_GET['id'] ?? 0;
        $produccion = $this->productionModel->getById($id);
        
        if (!$produccion) {
            $_SESSION['error'] = 'Producción no encontrada';
            header('Location: /chilechilito/public/index.php?controller=production&action=index');
            exit();
        }
        
        // Obtener receta del producto
        $receta = $this->recipeModel->getByProductId($produccion['producto_id']);
        
        include __DIR__ . '/../views/production/view.php';
    }
    
    /**
     * Mostrar formulario de nueva producción
     */
    public function create() {
        AuthController::checkRole('supervisor');
        
        // Obtener productos que requieren producción directamente de la BD
        $database = new Database();
        $conn = $database->connect();
        
        $query = "SELECT * FROM productos WHERE requiere_produccion = TRUE AND estado = 'activo' ORDER BY nombre ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../views/production/create.php';
    }
    
    /**
     * Verificar disponibilidad de insumos (AJAX)
     */
    public function verificarDisponibilidad() {
        header('Content-Type: application/json');
        
        $producto_id = $_GET['producto_id'] ?? 0;
        $cantidad = $_GET['cantidad'] ?? 0;
        
        if (!$producto_id || !$cantidad) {
            echo json_encode(['error' => 'Parámetros inválidos']);
            exit();
        }
        
        $verificacion = $this->recipeModel->verificarDisponibilidad($producto_id, $cantidad);
        echo json_encode($verificacion);
        exit();
    }
    
    /**
     * Procesar nueva producción
     */
    public function store() {
        AuthController::checkRole('supervisor');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chilechilito/public/index.php?controller=production&action=index');
            exit();
        }
        
        $producto_id = $_POST['producto_id'] ?? 0;
        $cantidad = $_POST['cantidad'] ?? 0;
        $notas = $_POST['notas'] ?? '';
        
        if (!$producto_id || !$cantidad) {
            $_SESSION['error'] = 'Datos incompletos';
            header('Location: /chilechilito/public/index.php?controller=production&action=create');
            exit();
        }
        
        $resultado = $this->productionModel->create($producto_id, $cantidad, $notas);
        
        if ($resultado['success']) {
            $_SESSION['success'] = "Producción completada. $cantidad unidades producidas. Costo: $" . number_format($resultado['costo_produccion'], 2);
            header('Location: /chilechilito/public/index.php?controller=production&action=view&id=' . $resultado['produccion_id']);
        } else {
            $_SESSION['error'] = 'Error: ' . $resultado['error'];
            header('Location: /chilechilito/public/index.php?controller=production&action=create');
        }
        
        exit();
    }
    
    /**
     * Estadísticas de producción
     */
    public function estadisticas() {
        $estadisticas = $this->productionModel->getEstadisticas(30);
        $productos_mas_producidos = $this->productionModel->getProductosMasProducidos(10);
        
        include __DIR__ . '/../views/production/estadisticas.php';
    }
}
