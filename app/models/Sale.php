<?php
class Sale {
    private $conn;
    private $table = 'ventas';

    public $id;
    public $cliente_id;
    public $fecha_venta;
    public $total;
    public $metodo_pago;
    public $estado;
    public $observaciones;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las ventas
    public function getAll() {
        $query = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre
                  FROM " . $this->table . " v
                  INNER JOIN clientes c ON v.cliente_id = c.id
                  ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener venta por ID
    public function getById($id) {
        $query = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre, 
                  c.email, c.telefono
                  FROM " . $this->table . " v
                  INNER JOIN clientes c ON v.cliente_id = c.id
                  WHERE v.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Crear venta
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (cliente_id, total, metodo_pago, estado, observaciones) 
                  VALUES (:cliente_id, :total, :metodo_pago, :estado, :observaciones)";
        
        $stmt = $this->conn->prepare($query);

        $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->metodo_pago = htmlspecialchars(strip_tags($this->metodo_pago));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->observaciones = htmlspecialchars(strip_tags($this->observaciones));

        $stmt->bindParam(':cliente_id', $this->cliente_id);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':metodo_pago', $this->metodo_pago);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':observaciones', $this->observaciones);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Actualizar venta
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET cliente_id = :cliente_id, total = :total, metodo_pago = :metodo_pago, 
                      estado = :estado, observaciones = :observaciones
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->metodo_pago = htmlspecialchars(strip_tags($this->metodo_pago));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->observaciones = htmlspecialchars(strip_tags($this->observaciones));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':cliente_id', $this->cliente_id);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':metodo_pago', $this->metodo_pago);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':observaciones', $this->observaciones);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar venta
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener detalle de venta
    public function getDetails($sale_id) {
        $query = "SELECT dv.*, p.nombre as producto_nombre, p.categoria
                  FROM detalle_ventas dv
                  INNER JOIN productos p ON dv.producto_id = p.id
                  WHERE dv.venta_id = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sale_id', $sale_id);
        $stmt->execute();
        return $stmt;
    }

    // Añadir detalle a la venta
    public function addDetail($venta_id, $producto_id, $cantidad, $precio_unitario) {
        $query = "INSERT INTO detalle_ventas 
                  (venta_id, producto_id, cantidad, precio_unitario, subtotal) 
                  VALUES (:venta_id, :producto_id, :cantidad, :precio_unitario, :subtotal)";
        
        $stmt = $this->conn->prepare($query);
        
        $subtotal = $cantidad * $precio_unitario;
        
        $stmt->bindParam(':venta_id', $venta_id);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio_unitario', $precio_unitario);
        $stmt->bindParam(':subtotal', $subtotal);

        return $stmt->execute();
    }

    // Ventas por rango de fechas
    public function getByDateRange($start_date, $end_date) {
        $query = "SELECT v.*, CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre
                  FROM " . $this->table . " v
                  INNER JOIN clientes c ON v.cliente_id = c.id
                  WHERE DATE(v.fecha_venta) BETWEEN :start_date AND :end_date
                  ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt;
    }

    // Ventas por día de la semana
    public function getSalesByDayOfWeek() {
        $query = "SELECT DAYOFWEEK(fecha_venta) as dia_semana, 
                  DAYNAME(fecha_venta) as nombre_dia,
                  COUNT(*) as total_ventas, 
                  SUM(total) as monto_total
                  FROM " . $this->table . "
                  WHERE estado = 'completada'
                  GROUP BY dia_semana, nombre_dia
                  ORDER BY dia_semana";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ventas totales por mes
    public function getSalesByMonth($year = null) {
        if ($year === null) {
            $year = date('Y');
        }
        
        $query = "SELECT MONTH(fecha_venta) as mes, 
                  MONTHNAME(fecha_venta) as nombre_mes,
                  COUNT(*) as total_ventas, 
                  SUM(total) as monto_total
                  FROM " . $this->table . "
                  WHERE YEAR(fecha_venta) = :year AND estado = 'completada'
                  GROUP BY mes, nombre_mes
                  ORDER BY mes";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt;
    }

    // Total de ventas del día
    public function getTodaySales() {
        $query = "SELECT COUNT(*) as total_ventas, COALESCE(SUM(total), 0) as monto_total
                  FROM " . $this->table . "
                  WHERE DATE(fecha_venta) = CURDATE() AND estado = 'completada'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Total de ventas del mes
    public function getMonthSales() {
        $query = "SELECT COUNT(*) as total_ventas, COALESCE(SUM(total), 0) as monto_total
                  FROM " . $this->table . "
                  WHERE MONTH(fecha_venta) = MONTH(CURDATE()) 
                  AND YEAR(fecha_venta) = YEAR(CURDATE())
                  AND estado = 'completada'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Total de ventas del año
    public function getYearSales() {
        $query = "SELECT COUNT(*) as total_ventas, COALESCE(SUM(total), 0) as monto_total
                  FROM " . $this->table . "
                  WHERE YEAR(fecha_venta) = YEAR(CURDATE())
                  AND estado = 'completada'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
