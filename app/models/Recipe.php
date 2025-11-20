<?php
require_once __DIR__ . '/../config/Database.php';

class Recipe {
    private $conn;
    private $table = 'recetas_productos';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    /**
     * Obtener receta completa de un producto
     */
    public function getByProductId($producto_id) {
        $query = "SELECT rp.*, i.nombre as insumo_nombre, i.stock_actual, 
                         i.unidad_medida as insumo_unidad, i.costo_unitario,
                         (rp.cantidad_necesaria * i.costo_unitario) as costo_linea
                  FROM " . $this->table . " rp
                  INNER JOIN insumos i ON rp.insumo_id = i.id
                  WHERE rp.producto_id = :producto_id
                  ORDER BY i.nombre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener productos que usan un insumo específico
     */
    public function getProductosByInsumoId($insumo_id) {
        $query = "SELECT rp.*, p.nombre as producto_nombre, p.precio
                  FROM " . $this->table . " rp
                  INNER JOIN productos p ON rp.producto_id = p.id
                  WHERE rp.insumo_id = :insumo_id
                  ORDER BY p.nombre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':insumo_id', $insumo_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Verificar si hay suficientes insumos para producir cantidad de producto
     */
    public function verificarDisponibilidad($producto_id, $cantidad_producir) {
        $receta = $this->getByProductId($producto_id);
        $faltantes = [];
        $disponible = true;
        
        foreach ($receta as $ingrediente) {
            $cantidad_necesaria = $ingrediente['cantidad_necesaria'] * $cantidad_producir;
            
            if ($ingrediente['stock_actual'] < $cantidad_necesaria) {
                $disponible = false;
                $faltantes[] = [
                    'insumo_id' => $ingrediente['insumo_id'],
                    'insumo_nombre' => $ingrediente['insumo_nombre'],
                    'necesario' => $cantidad_necesaria,
                    'disponible' => $ingrediente['stock_actual'],
                    'faltante' => $cantidad_necesaria - $ingrediente['stock_actual'],
                    'unidad_medida' => $ingrediente['unidad_medida']
                ];
            }
        }
        
        return [
            'disponible' => $disponible,
            'faltantes' => $faltantes,
            'receta' => $receta
        ];
    }
    
    /**
     * Calcular costo de producción de un producto
     */
    public function calcularCostoProduccion($producto_id, $cantidad = 1) {
        $receta = $this->getByProductId($producto_id);
        $costo_total = 0;
        
        foreach ($receta as $ingrediente) {
            $costo_total += $ingrediente['costo_linea'] * $cantidad;
        }
        
        return round($costo_total, 2);
    }
    
    /**
     * Agregar ingrediente a receta
     */
    public function agregarIngrediente($producto_id, $insumo_id, $cantidad_necesaria, $unidad_medida, $notas = '') {
        $query = "INSERT INTO " . $this->table . " 
                  (producto_id, insumo_id, cantidad_necesaria, unidad_medida, notas) 
                  VALUES (:producto_id, :insumo_id, :cantidad_necesaria, :unidad_medida, :notas)
                  ON DUPLICATE KEY UPDATE 
                  cantidad_necesaria = :cantidad_necesaria2, 
                  unidad_medida = :unidad_medida2, 
                  notas = :notas2";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':insumo_id', $insumo_id);
        $stmt->bindParam(':cantidad_necesaria', $cantidad_necesaria);
        $stmt->bindParam(':unidad_medida', $unidad_medida);
        $stmt->bindParam(':notas', $notas);
        $stmt->bindParam(':cantidad_necesaria2', $cantidad_necesaria);
        $stmt->bindParam(':unidad_medida2', $unidad_medida);
        $stmt->bindParam(':notas2', $notas);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar ingrediente de receta
     */
    public function eliminarIngrediente($producto_id, $insumo_id) {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE producto_id = :producto_id AND insumo_id = :insumo_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':insumo_id', $insumo_id);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar toda la receta de un producto
     */
    public function eliminarReceta($producto_id) {
        $query = "DELETE FROM " . $this->table . " WHERE producto_id = :producto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener análisis de recetas (productos sin receta definida)
     */
    public function getProductosSinReceta() {
        $query = "SELECT p.* 
                  FROM productos p
                  LEFT JOIN " . $this->table . " rp ON p.id = rp.producto_id
                  WHERE p.requiere_produccion = TRUE 
                  AND rp.producto_id IS NULL
                  AND p.estado = 'activo'
                  ORDER BY p.nombre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
