<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Insumo.php';
require_once __DIR__ . '/AuthController.php';

class ProductController {
    private $db;
    private $product;
    private $recipe;
    private $insumo;

    public function __construct() {
        AuthController::checkAuth();
        $database = new Database();
        $this->db = $database->connect();
        $this->product = new Product($this->db);
        $this->recipe = new Recipe();
        $this->insumo = new Insumo();
    }

    public function index() {
        $result = $this->product->getAll();
        $products = $result->fetchAll();
        include __DIR__ . '/../views/products/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Crear producto
                $this->product->nombre = $_POST['nombre'];
                $this->product->descripcion = $_POST['descripcion'];
                $this->product->precio = $_POST['precio'];
                $this->product->stock_actual = $_POST['stock_actual'];
                $this->product->stock_minimo = $_POST['stock_minimo'];
                $this->product->categoria = $_POST['categoria'];
                $this->product->imagen = $_POST['imagen'] ?? '';
                $this->product->estado = $_POST['estado'] ?? 'activo';

                if($this->product->create()) {
                    $producto_id = $this->db->lastInsertId();
                    
                    // Guardar receta si se definió
                    if (isset($_POST['requiere_produccion']) && $_POST['requiere_produccion'] == '1') {
                        // Actualizar flag de requiere_produccion
                        $query = "UPDATE productos SET requiere_produccion = TRUE WHERE id = :id";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id', $producto_id);
                        $stmt->execute();
                        
                        // Guardar ingredientes de la receta
                        if (isset($_POST['insumos']) && is_array($_POST['insumos'])) {
                            foreach ($_POST['insumos'] as $insumo_id) {
                                if (!empty($insumo_id) && isset($_POST['cantidades'][$insumo_id])) {
                                    $cantidad = $_POST['cantidades'][$insumo_id];
                                    $unidad = $_POST['unidades'][$insumo_id];
                                    $notas = $_POST['notas_insumo'][$insumo_id] ?? '';
                                    
                                    if ($cantidad > 0) {
                                        $this->recipe->agregarIngrediente(
                                            $producto_id,
                                            $insumo_id,
                                            $cantidad,
                                            $unidad,
                                            $notas
                                        );
                                    }
                                }
                            }
                        }
                        
                        // Calcular y actualizar costo de producción
                        $costo = $this->recipe->calcularCostoProduccion($producto_id);
                        $query = "UPDATE productos SET costo_produccion = :costo WHERE id = :id";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':costo', $costo);
                        $stmt->bindParam(':id', $producto_id);
                        $stmt->execute();
                    }
                    
                    $_SESSION['success'] = 'Producto creado exitosamente';
                    header('Location: ' . APP_URL . '/public/index.php?controller=product&action=view&id=' . $producto_id);
                    exit();
                } else {
                    $error = "Error al crear el producto";
                }
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
        
        // Obtener todos los insumos para el formulario
        $insumos = $this->insumo->getActivos();
        include __DIR__ . '/../views/products/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ' . APP_URL . '/public/index.php?controller=product&action=index');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->product->id = $id;
                $this->product->nombre = $_POST['nombre'];
                $this->product->descripcion = $_POST['descripcion'];
                $this->product->precio = $_POST['precio'];
                $this->product->stock_actual = $_POST['stock_actual'];
                $this->product->stock_minimo = $_POST['stock_minimo'];
                $this->product->categoria = $_POST['categoria'];
                $this->product->imagen = $_POST['imagen'] ?? '';
                $this->product->estado = $_POST['estado'];

                if($this->product->update()) {
                    // Actualizar receta
                    $requiere_produccion = isset($_POST['requiere_produccion']) && $_POST['requiere_produccion'] == '1';
                    
                    $query = "UPDATE productos SET requiere_produccion = :req WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':req', $requiere_produccion, PDO::PARAM_BOOL);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    
                    if ($requiere_produccion) {
                        // Eliminar receta anterior
                        $this->recipe->eliminarReceta($id);
                        
                        // Guardar nueva receta
                        if (isset($_POST['insumos']) && is_array($_POST['insumos'])) {
                            foreach ($_POST['insumos'] as $insumo_id) {
                                if (!empty($insumo_id) && isset($_POST['cantidades'][$insumo_id])) {
                                    $cantidad = $_POST['cantidades'][$insumo_id];
                                    $unidad = $_POST['unidades'][$insumo_id];
                                    $notas = $_POST['notas_insumo'][$insumo_id] ?? '';
                                    
                                    if ($cantidad > 0) {
                                        $this->recipe->agregarIngrediente($id, $insumo_id, $cantidad, $unidad, $notas);
                                    }
                                }
                            }
                        }
                        
                        // Recalcular costo
                        $costo = $this->recipe->calcularCostoProduccion($id);
                        $query = "UPDATE productos SET costo_produccion = :costo WHERE id = :id";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':costo', $costo);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();
                    }
                    
                    $_SESSION['success'] = 'Producto actualizado exitosamente';
                    header('Location: ' . APP_URL . '/public/index.php?controller=product&action=view&id=' . $id);
                    exit();
                } else {
                    $error = "Error al actualizar el producto";
                }
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }

        $product = $this->product->getById($id);
        $insumos = $this->insumo->getActivos();
        $receta_actual = $this->recipe->getByProductId($id);
        include __DIR__ . '/../views/products/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $this->product->id = $id;
            if($this->product->delete()) {
                header('Location: ' . APP_URL . '/public/index.php?controller=product&action=index&msg=deleted');
            } else {
                header('Location: ' . APP_URL . '/public/index.php?controller=product&action=index&msg=error');
            }
        }
        exit();
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ' . APP_URL . '/public/index.php?controller=product&action=index');
            exit();
        }

        $product = $this->product->getById($id);
        
        if (!$product) {
            header('Location: ' . APP_URL . '/public/index.php?controller=product&action=index&msg=notfound');
            exit();
        }

        // Obtener receta si requiere producción
        $receta = [];
        $costo_produccion = 0;
        $margen_utilidad = 0;
        
        if (isset($product['requiere_produccion']) && $product['requiere_produccion']) {
            $receta = $this->recipe->getByProductId($id);
            $costo_produccion = $this->recipe->calcularCostoProduccion($id);
            
            if ($costo_produccion > 0 && $product['precio'] > 0) {
                $margen_utilidad = (($product['precio'] - $costo_produccion) / $product['precio']) * 100;
            }
        }
        
        include __DIR__ . '/../views/products/view.php';
    }

    public function lowStock() {
        $result = $this->product->getLowStock();
        $products = $result->fetchAll();
        include __DIR__ . '/../views/products/low_stock.php';
    }

    // API para obtener datos JSON
    public function getJson() {
        $result = $this->product->getActive();
        $products = $result->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($products);
        exit();
    }
}
