<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Insumo.php';

class InsumoController {
    private $insumoModel;
    
    public function __construct() {
        AuthController::checkAuth();
        $this->insumoModel = new Insumo();
    }
    
    /**
     * Listar todos los insumos
     */
    public function index() {
        $insumos = $this->insumoModel->getAll();
        include __DIR__ . '/../views/insumos/index.php';
    }
    
    /**
     * Ver insumos con stock bajo
     */
    public function stockBajo() {
        $insumos = $this->insumoModel->getStockBajo();
        include __DIR__ . '/../views/insumos/stock_bajo.php';
    }
    
    /**
     * Calcular necesidades de compra
     */
    public function necesidadesCompra() {
        // Obtener días de proyección: primero custom, luego radio buttons, por defecto 30
        $dias_proyeccion = 30;
        
        if (isset($_GET['dias_custom']) && !empty($_GET['dias_custom'])) {
            $dias_proyeccion = max(1, min(365, intval($_GET['dias_custom'])));
        } elseif (isset($_GET['dias'])) {
            $dias_proyeccion = max(1, min(365, intval($_GET['dias'])));
        }
        
        $necesidades = $this->insumoModel->calcularNecesidadesCompra($dias_proyeccion);
        include __DIR__ . '/../views/insumos/necesidades_compra.php';
    }
    
    /**
     * Ver detalle de un insumo
     */
    public function view() {
        $id = $_GET['id'] ?? 0;
        $insumo = $this->insumoModel->getById($id);
        
        if (!$insumo) {
            $_SESSION['error'] = 'Insumo no encontrado';
            header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
            exit();
        }
        
        // Obtener movimientos
        $movimientos = $this->insumoModel->getMovimientos($id);
        
        // Obtener productos que usan este insumo
        require_once __DIR__ . '/../models/Recipe.php';
        $recipeModel = new Recipe();
        $productos = $recipeModel->getProductosByInsumoId($id);
        
        include __DIR__ . '/../views/insumos/view.php';
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function create() {
        AuthController::checkRole('supervisor');
        include __DIR__ . '/../views/insumos/create.php';
    }
    
    /**
     * Guardar nuevo insumo
     */
    public function store() {
        AuthController::checkRole('supervisor');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
            exit();
        }
        
        $data = [
            'nombre' => $_POST['nombre'] ?? '',
            'sku' => $_POST['sku'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'categoria' => $_POST['categoria'] ?? '',
            'unidad_medida' => $_POST['unidad_medida'] ?? 'unidades',
            'stock_actual' => $_POST['stock_actual'] ?? 0,
            'stock_minimo' => $_POST['stock_minimo'] ?? 10,
            'stock_maximo' => $_POST['stock_maximo'] ?? 100,
            'costo_unitario' => $_POST['costo_unitario'] ?? 0,
            'proveedor' => $_POST['proveedor'] ?? '',
            'estado' => $_POST['estado'] ?? 'activo',
            'notas' => $_POST['notas'] ?? ''
        ];
        
        if ($this->insumoModel->create($data)) {
            $_SESSION['success'] = 'Insumo creado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear el insumo';
        }
        
        header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
        exit();
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function edit() {
        AuthController::checkRole('supervisor');
        
        $id = $_GET['id'] ?? 0;
        $insumo = $this->insumoModel->getById($id);
        
        if (!$insumo) {
            $_SESSION['error'] = 'Insumo no encontrado';
            header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
            exit();
        }
        
        include __DIR__ . '/../views/insumos/edit.php';
    }
    
    /**
     * Actualizar insumo
     */
    public function update() {
        AuthController::checkRole('supervisor');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        
        $data = [
            'nombre' => $_POST['nombre'] ?? '',
            'sku' => $_POST['sku'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'categoria' => $_POST['categoria'] ?? '',
            'unidad_medida' => $_POST['unidad_medida'] ?? 'unidades',
            'stock_actual' => $_POST['stock_actual'] ?? 0,
            'stock_minimo' => $_POST['stock_minimo'] ?? 10,
            'stock_maximo' => $_POST['stock_maximo'] ?? 100,
            'costo_unitario' => $_POST['costo_unitario'] ?? 0,
            'proveedor' => $_POST['proveedor'] ?? '',
            'estado' => $_POST['estado'] ?? 'activo',
            'notas' => $_POST['notas'] ?? ''
        ];
        
        if ($this->insumoModel->update($id, $data)) {
            $_SESSION['success'] = 'Insumo actualizado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el insumo';
        }
        
        header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
        exit();
    }
    
    /**
     * Eliminar insumo
     */
    public function delete() {
        AuthController::checkRole('admin');
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->insumoModel->delete($id)) {
            $_SESSION['success'] = 'Insumo eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el insumo. Puede estar siendo usado en recetas.';
        }
        
        header('Location: /chilechilito/public/index.php?controller=insumo&action=index');
        exit();
    }
    
    /**
     * Registrar compra de insumos
     */
    public function registrarCompra() {
        AuthController::checkRole('supervisor');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chilechilito/public/index.php?controller=insumo&action=necesidadesCompra');
            exit();
        }
        
        $insumo_id = $_POST['insumo_id'] ?? 0;
        $cantidad = $_POST['cantidad'] ?? 0;
        $notas = $_POST['notas'] ?? '';
        
        $insumo = $this->insumoModel->getById($insumo_id);
        
        if (!$insumo) {
            $_SESSION['error'] = 'Insumo no encontrado';
            header('Location: /chilechilito/public/index.php?controller=insumo&action=necesidadesCompra');
            exit();
        }
        
        // Actualizar stock
        $nuevo_stock = $insumo['stock_actual'] + $cantidad;
        $this->insumoModel->actualizarStock($insumo_id, $nuevo_stock);
        
        // Registrar movimiento
        $this->insumoModel->registrarMovimiento(
            $insumo_id,
            'compra',
            $cantidad,
            $insumo['unidad_medida'],
            null,
            $notas
        );
        
        $_SESSION['success'] = 'Compra registrada exitosamente';
        header('Location: /chilechilito/public/index.php?controller=insumo&action=view&id=' . $insumo_id);
        exit();
    }
}
