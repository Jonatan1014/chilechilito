<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../models/Sale.php';

class DashboardController {
    private $db;
    private $product;
    private $customer;
    private $sale;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->product = new Product($this->db);
        $this->customer = new Customer($this->db);
        $this->sale = new Sale($this->db);
    }

    public function index() {
        // Métricas generales
        $todaySales = $this->sale->getTodaySales();
        $monthSales = $this->sale->getMonthSales();
        $yearSales = $this->sale->getYearSales();
        
        // Productos
        $topSellingProducts = $this->product->getTopSelling(5)->fetchAll();
        $leastSellingProducts = $this->product->getLeastSelling(5)->fetchAll();
        $lowStockProducts = $this->product->getLowStock()->fetchAll();
        
        // Clientes
        $topBuyers = $this->customer->getTopBuyers(5)->fetchAll();
        $leastBuyers = $this->customer->getLeastBuyers(5)->fetchAll();
        
        // Ventas por día de la semana
        $salesByDay = $this->sale->getSalesByDayOfWeek()->fetchAll();
        
        // Ventas por mes
        $salesByMonth = $this->sale->getSalesByMonth()->fetchAll();
        
        include __DIR__ . '/../views/dashboard/index.php';
    }

    // API para obtener datos del dashboard en JSON
    public function getMetrics() {
        $data = [
            'today' => $this->sale->getTodaySales(),
            'month' => $this->sale->getMonthSales(),
            'year' => $this->sale->getYearSales(),
            'topProducts' => $this->product->getTopSelling(10)->fetchAll(),
            'leastProducts' => $this->product->getLeastSelling(10)->fetchAll(),
            'lowStock' => $this->product->getLowStock()->fetchAll(),
            'topCustomers' => $this->customer->getTopBuyers(10)->fetchAll(),
            'leastCustomers' => $this->customer->getLeastBuyers(10)->fetchAll(),
            'salesByDay' => $this->sale->getSalesByDayOfWeek()->fetchAll(),
            'salesByMonth' => $this->sale->getSalesByMonth()->fetchAll()
        ];
        
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
