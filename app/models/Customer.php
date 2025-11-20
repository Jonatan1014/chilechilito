<?php
class Customer {
    private $conn;
    private $table = 'clientes';

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $direccion;
    public $rut;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los clientes
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener clientes activos
    public function getActive() {
        $query = "SELECT * FROM " . $this->table . " WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener cliente por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Crear cliente
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nombre, apellido, email, telefono, direccion, rut, estado) 
                  VALUES (:nombre, :apellido, :email, :telefono, :direccion, :rut, :estado)";
        
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->rut = htmlspecialchars(strip_tags($this->rut));
        $this->estado = htmlspecialchars(strip_tags($this->estado));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':rut', $this->rut);
        $stmt->bindParam(':estado', $this->estado);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar cliente
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, apellido = :apellido, email = :email, 
                      telefono = :telefono, direccion = :direccion, rut = :rut, estado = :estado
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->rut = htmlspecialchars(strip_tags($this->rut));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':rut', $this->rut);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar cliente
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

    // Clientes que más compran
    public function getTopBuyers($limit = 10) {
        $query = "SELECT c.*, COUNT(v.id) as total_compras, SUM(v.total) as monto_total
                  FROM " . $this->table . " c
                  INNER JOIN ventas v ON c.id = v.cliente_id
                  WHERE v.estado = 'completada'
                  GROUP BY c.id
                  ORDER BY monto_total DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Clientes que menos compran
    public function getLeastBuyers($limit = 10) {
        $query = "SELECT c.*, COUNT(v.id) as total_compras, COALESCE(SUM(v.total), 0) as monto_total
                  FROM " . $this->table . " c
                  LEFT JOIN ventas v ON c.id = v.cliente_id AND v.estado = 'completada'
                  WHERE c.estado = 'activo'
                  GROUP BY c.id
                  ORDER BY monto_total ASC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Productos más comprados por cliente
    public function getCustomerTopProducts($customer_id, $limit = 5) {
        $query = "SELECT p.*, SUM(dv.cantidad) as total_comprado, 
                  COUNT(DISTINCT v.id) as veces_comprado
                  FROM productos p
                  INNER JOIN detalle_ventas dv ON p.id = dv.producto_id
                  INNER JOIN ventas v ON dv.venta_id = v.id
                  WHERE v.cliente_id = :customer_id AND v.estado = 'completada'
                  GROUP BY p.id
                  ORDER BY total_comprado DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Historial de compras del cliente
    public function getCustomerPurchaseHistory($customer_id) {
        $query = "SELECT v.*, 
                  (SELECT COUNT(*) FROM detalle_ventas WHERE venta_id = v.id) as items_count
                  FROM ventas v
                  WHERE v.cliente_id = :customer_id
                  ORDER BY v.fecha_venta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        return $stmt;
    }
}
