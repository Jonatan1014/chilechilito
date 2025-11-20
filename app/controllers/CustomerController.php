<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {
    private $db;
    private $customer;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->customer = new Customer($this->db);
    }

    public function index() {
        $result = $this->customer->getAll();
        $customers = $result->fetchAll();
        include __DIR__ . '/../views/customers/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->customer->nombre = $_POST['nombre'];
            $this->customer->apellido = $_POST['apellido'];
            $this->customer->email = $_POST['email'];
            $this->customer->telefono = $_POST['telefono'];
            $this->customer->direccion = $_POST['direccion'];
            $this->customer->rut = $_POST['rut'];
            $this->customer->estado = $_POST['estado'] ?? 'activo';

            if($this->customer->create()) {
                header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index&msg=created');
                exit();
            } else {
                $error = "Error al crear el cliente";
            }
        }
        
        include __DIR__ . '/../views/customers/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->customer->id = $id;
            $this->customer->nombre = $_POST['nombre'];
            $this->customer->apellido = $_POST['apellido'];
            $this->customer->email = $_POST['email'];
            $this->customer->telefono = $_POST['telefono'];
            $this->customer->direccion = $_POST['direccion'];
            $this->customer->rut = $_POST['rut'];
            $this->customer->estado = $_POST['estado'];

            if($this->customer->update()) {
                header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index&msg=updated');
                exit();
            } else {
                $error = "Error al actualizar el cliente";
            }
        }

        $customer = $this->customer->getById($id);
        include __DIR__ . '/../views/customers/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $this->customer->id = $id;
            if($this->customer->delete()) {
                header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index&msg=deleted');
            } else {
                header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index&msg=error');
            }
        }
        exit();
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ' . APP_URL . '/public/index.php?controller=customer&action=index');
            exit();
        }

        $customer = $this->customer->getById($id);
        
        // Obtener productos más comprados por este cliente
        $topProducts = $this->customer->getCustomerTopProducts($id)->fetchAll();
        
        // Obtener historial de compras
        $purchaseHistory = $this->customer->getCustomerPurchaseHistory($id)->fetchAll();
        
        include __DIR__ . '/../views/customers/view.php';
    }

    // API para obtener datos JSON
    public function getJson() {
        $result = $this->customer->getActive();
        $customers = $result->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($customers);
        exit();
    }
}
