<?php
require_once __DIR__ . '/../config/Database.php';

class Production {
    private $conn;
    private $table = 'producciones';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    /**
     * Obtener todas las producciones
     */
    public function getAll($limit = 100) {
        $query = "SELECT pr.*, p.nombre as producto_nombre, p.categoria
                  FROM " . $this->table . " pr
                  INNER JOIN productos p ON pr.producto_id = p.id
                  ORDER BY pr.fecha_produccion DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener producción por ID
     */
    public function getById($id) {
        $query = "SELECT pr.*, p.nombre as producto_nombre, p.categoria, p.precio
                  FROM " . $this->table . " pr
                  INNER JOIN productos p ON pr.producto_id = p.id
                  WHERE pr.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener producciones de un producto específico
     */
    public function getByProductId($producto_id, $limit = 50) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE producto_id = :producto_id 
                  ORDER BY fecha_produccion DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear producción (producir productos y descontar insumos)
     */
    public function create($producto_id, $cantidad_producir, $notas = '') {
        try {
            $this->conn->beginTransaction();
            
            // 1. Obtener receta del producto
            require_once __DIR__ . '/Recipe.php';
            $recipeModel = new Recipe();
            $verificacion = $recipeModel->verificarDisponibilidad($producto_id, $cantidad_producir);
            
            if (!$verificacion['disponible']) {
                throw new Exception('Insumos insuficientes para producir la cantidad solicitada');
            }
            
            // 2. Calcular costo de producción
            $costo_produccion = $recipeModel->calcularCostoProduccion($producto_id, $cantidad_producir);
            
            // 3. Registrar producción
            $query = "INSERT INTO " . $this->table . " 
                      (producto_id, cantidad_producida, costo_produccion, notas) 
                      VALUES (:producto_id, :cantidad_producida, :costo_produccion, :notas)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':producto_id', $producto_id);
            $stmt->bindParam(':cantidad_producida', $cantidad_producir);
            $stmt->bindParam(':costo_produccion', $costo_produccion);
            $stmt->bindParam(':notas', $notas);
            $stmt->execute();
            
            $produccion_id = $this->conn->lastInsertId();
            
            // 4. Descontar insumos del stock
            require_once __DIR__ . '/Insumo.php';
            $insumoModel = new Insumo();
            
            foreach ($verificacion['receta'] as $ingrediente) {
                $cantidad_descontar = $ingrediente['cantidad_necesaria'] * $cantidad_producir;
                $nuevo_stock = $ingrediente['stock_actual'] - $cantidad_descontar;
                
                // Actualizar stock de insumo
                $insumoModel->actualizarStock($ingrediente['insumo_id'], $nuevo_stock);
                
                // Registrar movimiento de insumo
                $insumoModel->registrarMovimiento(
                    $ingrediente['insumo_id'],
                    'produccion',
                    $cantidad_descontar,
                    $ingrediente['unidad_medida'],
                    $produccion_id,
                    "Producción de $cantidad_producir unidades - Producción #$produccion_id"
                );
            }
            
            // 5. Aumentar stock del producto terminado
            $query = "UPDATE productos 
                      SET stock_actual = stock_actual + :cantidad,
                          costo_produccion = :costo_unitario
                      WHERE id = :producto_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cantidad', $cantidad_producir);
            $costo_unitario = $costo_produccion / $cantidad_producir;
            $stmt->bindParam(':costo_unitario', $costo_unitario);
            $stmt->bindParam(':producto_id', $producto_id);
            $stmt->execute();
            
            // 6. Registrar en historial de stock del producto
            $query = "INSERT INTO historial_stock 
                      (producto_id, tipo_movimiento, cantidad, stock_anterior, stock_nuevo, motivo) 
                      SELECT :producto_id, 'entrada', :cantidad, 
                             stock_actual - :cantidad2, stock_actual, 
                             CONCAT('Producción #', :produccion_id)
                      FROM productos WHERE id = :producto_id2";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':producto_id', $producto_id);
            $stmt->bindParam(':cantidad', $cantidad_producir);
            $stmt->bindParam(':cantidad2', $cantidad_producir);
            $stmt->bindParam(':produccion_id', $produccion_id);
            $stmt->bindParam(':producto_id2', $producto_id);
            $stmt->execute();
            
            $this->conn->commit();
            
            return [
                'success' => true,
                'produccion_id' => $produccion_id,
                'costo_produccion' => $costo_produccion,
                'costo_unitario' => $costo_unitario
            ];
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Obtener estadísticas de producción
     */
    public function getEstadisticas($dias = 30) {
        $query = "SELECT 
                      COUNT(*) as total_producciones,
                      SUM(cantidad_producida) as total_unidades,
                      SUM(costo_produccion) as costo_total,
                      AVG(costo_produccion / cantidad_producida) as costo_promedio_unitario
                  FROM " . $this->table . "
                  WHERE fecha_produccion >= DATE_SUB(NOW(), INTERVAL :dias DAY)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dias', $dias, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener productos más producidos
     */
    public function getProductosMasProducidos($limit = 10) {
        $query = "SELECT 
                      p.id, p.nombre, p.categoria,
                      COUNT(pr.id) as veces_producido,
                      SUM(pr.cantidad_producida) as total_producido,
                      SUM(pr.costo_produccion) as costo_total,
                      MAX(pr.fecha_produccion) as ultima_produccion
                  FROM productos p
                  INNER JOIN " . $this->table . " pr ON p.id = pr.producto_id
                  GROUP BY p.id, p.nombre, p.categoria
                  ORDER BY total_producido DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Eliminar producción
     */
    public function delete($id) {
        // Nota: Esto NO revertirá los cambios en stock
        // Para revertir, se debería implementar una función más compleja
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
