<?php
class Product {
    private $conn;
    private $table = 'productos';

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock_actual;
    public $stock_minimo;
    public $categoria;
    public $imagen;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los productos
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener productos activos
    public function getActive() {
        $query = "SELECT * FROM " . $this->table . " WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener producto por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Crear producto
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nombre, descripcion, precio, stock_actual, stock_minimo, categoria, imagen, estado) 
                  VALUES (:nombre, :descripcion, :precio, :stock_actual, :stock_minimo, :categoria, :imagen, :estado)";
        
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock_actual = htmlspecialchars(strip_tags($this->stock_actual));
        $this->stock_minimo = htmlspecialchars(strip_tags($this->stock_minimo));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->estado = htmlspecialchars(strip_tags($this->estado));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_minimo);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':estado', $this->estado);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar producto
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, descripcion = :descripcion, precio = :precio, 
                      stock_actual = :stock_actual, stock_minimo = :stock_minimo, 
                      categoria = :categoria, imagen = :imagen, estado = :estado
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock_actual = htmlspecialchars(strip_tags($this->stock_actual));
        $this->stock_minimo = htmlspecialchars(strip_tags($this->stock_minimo));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock_actual', $this->stock_actual);
        $stmt->bindParam(':stock_minimo', $this->stock_minimo);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar producto
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

    // Obtener productos con stock bajo
    public function getLowStock() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE stock_actual <= stock_minimo AND estado = 'activo' 
                  ORDER BY stock_actual ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar stock
    public function updateStock($id, $cantidad) {
        $query = "UPDATE " . $this->table . " SET stock_actual = stock_actual - :cantidad WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Obtener categorías únicas
    public function getCategories() {
        $query = "SELECT DISTINCT categoria FROM " . $this->table . " WHERE categoria IS NOT NULL ORDER BY categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Productos más vendidos
    public function getTopSelling($limit = 10) {
        $query = "SELECT p.*, SUM(dv.cantidad) as total_vendido, 
                  COUNT(DISTINCT dv.venta_id) as veces_vendido
                  FROM " . $this->table . " p
                  INNER JOIN detalle_ventas dv ON p.id = dv.producto_id
                  GROUP BY p.id
                  ORDER BY total_vendido DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Productos menos vendidos
    public function getLeastSelling($limit = 10) {
        $query = "SELECT p.*, COALESCE(SUM(dv.cantidad), 0) as total_vendido
                  FROM " . $this->table . " p
                  LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id
                  WHERE p.estado = 'activo'
                  GROUP BY p.id
                  ORDER BY total_vendido ASC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
