<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Sale.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Insumo.php';

class SaleController {
    private $db;
    private $sale;
    private $product;
    private $customer;
    private $recipe;
    private $insumo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->sale = new Sale($this->db);
        $this->product = new Product($this->db);
        $this->customer = new Customer($this->db);
        $this->recipe = new Recipe();
        $this->insumo = new Insumo();
    }

    public function index() {
        $result = $this->sale->getAll();
        $sales = $result->fetchAll();
        include __DIR__ . '/../views/sales/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->db->beginTransaction();

                // Crear la venta
                $this->sale->cliente_id = $_POST['cliente_id'];
                $this->sale->total = $_POST['total'];
                $this->sale->metodo_pago = $_POST['metodo_pago'];
                $this->sale->estado = 'completada';
                $this->sale->observaciones = $_POST['observaciones'] ?? '';

                $sale_id = $this->sale->create();

                if ($sale_id) {
                    // Añadir los productos
                    $productos = json_decode($_POST['productos'], true);
                    
                    foreach ($productos as $item) {
                        $this->sale->addDetail(
                            $sale_id, 
                            $item['producto_id'], 
                            $item['cantidad'], 
                            $item['precio_unitario']
                        );
                        
                        // Actualizar stock del producto
                        $this->product->updateStock($item['producto_id'], $item['cantidad']);
                        
                        // Deducir insumos si el producto tiene receta
                        $producto = $this->product->getById($item['producto_id']);
                        
                        if (isset($producto['requiere_produccion']) && $producto['requiere_produccion']) {
                            $receta = $this->recipe->getByProductId($item['producto_id']);
                            
                            foreach ($receta as $ingrediente) {
                                $cantidad_a_deducir = $ingrediente['cantidad_necesaria'] * $item['cantidad'];
                                
                                // Actualizar stock del insumo
                                $nuevo_stock = $ingrediente['stock_actual'] - $cantidad_a_deducir;
                                $this->insumo->actualizarStock($ingrediente['insumo_id'], $nuevo_stock);
                                
                                // Registrar movimiento de salida
                                $this->insumo->registrarMovimiento(
                                    $ingrediente['insumo_id'],
                                    'venta',
                                    $cantidad_a_deducir,
                                    $sale_id,
                                    "Venta #{$sale_id} - {$item['cantidad']} unidades de {$producto['nombre']}"
                                );
                            }
                        }
                    }

                    $this->db->commit();
                    $_SESSION['success'] = 'Venta registrada exitosamente. Se han actualizado los stocks de productos e insumos.';
                    header('Location: ' . APP_URL . '/public/index.php?controller=sale&action=view&id=' . $sale_id);
                    exit();
                } else {
                    $this->db->rollBack();
                    $error = "Error al crear la venta";
                }
            } catch (Exception $e) {
                $this->db->rollBack();
                $error = "Error: " . $e->getMessage();
            }
        }
        
        // Obtener clientes y productos para el formulario
        $customers = $this->customer->getActive()->fetchAll();
        $products = $this->product->getActive()->fetchAll();
        
        include __DIR__ . '/../views/sales/create.php';
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ' . APP_URL . '/public/index.php?controller=sale&action=index');
            exit();
        }

        $sale = $this->sale->getById($id);
        $details = $this->sale->getDetails($id)->fetchAll();
        
        include __DIR__ . '/../views/sales/view.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $this->sale->id = $id;
            if($this->sale->delete()) {
                header('Location: ' . APP_URL . '/public/index.php?controller=sale&action=index&msg=deleted');
            } else {
                header('Location: ' . APP_URL . '/public/index.php?controller=sale&action=index&msg=error');
            }
        }
        exit();
    }

    public function report() {
        $start_date = $_GET['start_date'] ?? date('Y-m-01');
        $end_date = $_GET['end_date'] ?? date('Y-m-d');
        
        $result = $this->sale->getByDateRange($start_date, $end_date);
        $sales = $result->fetchAll();
        
        include __DIR__ . '/../views/sales/report.php';
    }
}
