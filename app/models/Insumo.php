<?php
require_once __DIR__ . '/../config/Database.php';

class Insumo {
    private $conn;
    private $table = 'insumos';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    /**
     * Obtener todos los insumos
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener insumos activos
     */
    public function getActivos() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE estado = 'activo' 
                  ORDER BY nombre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener insumo por ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener insumos con stock bajo
     */
    public function getStockBajo() {
        $query = "SELECT * FROM v_insumos_stock_bajo ORDER BY faltante DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener insumos por categoría
     */
    public function getByCategoria($categoria) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE categoria = :categoria 
                  ORDER BY nombre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear nuevo insumo
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (nombre, sku, descripcion, categoria, unidad_medida, 
                   stock_actual, stock_minimo, stock_maximo, costo_unitario, 
                   proveedor, estado, notas) 
                  VALUES (:nombre, :sku, :descripcion, :categoria, :unidad_medida, 
                          :stock_actual, :stock_minimo, :stock_maximo, :costo_unitario, 
                          :proveedor, :estado, :notas)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':unidad_medida', $data['unidad_medida']);
        $stmt->bindParam(':stock_actual', $data['stock_actual']);
        $stmt->bindParam(':stock_minimo', $data['stock_minimo']);
        $stmt->bindParam(':stock_maximo', $data['stock_maximo']);
        $stmt->bindParam(':costo_unitario', $data['costo_unitario']);
        $stmt->bindParam(':proveedor', $data['proveedor']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':notas', $data['notas']);
        
        return $stmt->execute();
    }
    
    /**
     * Actualizar insumo
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, 
                      sku = :sku, 
                      descripcion = :descripcion, 
                      categoria = :categoria, 
                      unidad_medida = :unidad_medida, 
                      stock_actual = :stock_actual, 
                      stock_minimo = :stock_minimo, 
                      stock_maximo = :stock_maximo, 
                      costo_unitario = :costo_unitario, 
                      proveedor = :proveedor, 
                      estado = :estado, 
                      notas = :notas 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':unidad_medida', $data['unidad_medida']);
        $stmt->bindParam(':stock_actual', $data['stock_actual']);
        $stmt->bindParam(':stock_minimo', $data['stock_minimo']);
        $stmt->bindParam(':stock_maximo', $data['stock_maximo']);
        $stmt->bindParam(':costo_unitario', $data['costo_unitario']);
        $stmt->bindParam(':proveedor', $data['proveedor']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':notas', $data['notas']);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar insumo
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Registrar movimiento de insumo
     */
    public function registrarMovimiento($insumo_id, $tipo, $cantidad, $unidad_medida, $referencia_id = null, $notas = '') {
        $query = "INSERT INTO movimientos_insumos 
                  (insumo_id, tipo_movimiento, cantidad, unidad_medida, referencia_id, notas) 
                  VALUES (:insumo_id, :tipo, :cantidad, :unidad_medida, :referencia_id, :notas)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':insumo_id', $insumo_id);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':unidad_medida', $unidad_medida);
        $stmt->bindParam(':referencia_id', $referencia_id);
        $stmt->bindParam(':notas', $notas);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener movimientos de un insumo
     */
    public function getMovimientos($insumo_id, $limit = 50) {
        $query = "SELECT * FROM movimientos_insumos 
                  WHERE insumo_id = :insumo_id 
                  ORDER BY fecha_movimiento DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':insumo_id', $insumo_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Calcular necesidades de compra basadas en ventas proyectadas
     */
    public function calcularNecesidadesCompra($dias_proyeccion = 30) {
        // Obtener insumos con stock bajo o que necesitarán reposición
        $insumosStockBajo = $this->getStockBajo();
        
        $necesidades = [];
        
        foreach ($insumosStockBajo as $insumo) {
            // Calcular consumo promedio diario con mayor precisión
            // Usar múltiples períodos para mejor exactitud
            $query = "SELECT 
                        SUM(CASE WHEN fecha_movimiento >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN cantidad ELSE 0 END) as consumo_7dias,
                        SUM(CASE WHEN fecha_movimiento >= DATE_SUB(NOW(), INTERVAL 15 DAY) THEN cantidad ELSE 0 END) as consumo_15dias,
                        SUM(CASE WHEN fecha_movimiento >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN cantidad ELSE 0 END) as consumo_30dias,
                        COUNT(DISTINCT DATE(fecha_movimiento)) as dias_con_movimiento
                      FROM movimientos_insumos 
                      WHERE insumo_id = :insumo_id 
                      AND tipo_movimiento IN ('venta', 'produccion') 
                      AND fecha_movimiento >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':insumo_id', $insumo['id']);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Calcular consumo diario promedio ponderado (dar más peso a períodos recientes)
            $consumo_7dias = ($resultado['consumo_7dias'] ?? 0) / 7;
            $consumo_15dias = ($resultado['consumo_15dias'] ?? 0) / 15;
            $consumo_30dias = ($resultado['consumo_30dias'] ?? 0) / 30;
            
            // Promedio ponderado: 50% últimos 7 días, 30% últimos 15 días, 20% últimos 30 días
            $consumo_diario = ($consumo_7dias * 0.5) + ($consumo_15dias * 0.3) + ($consumo_30dias * 0.2);
            
            // Si no hay historial, estimar consumo basado en recetas activas
            if ($consumo_diario == 0) {
                $query_recetas = "SELECT SUM(r.cantidad) as consumo_estimado
                                  FROM recetas_productos r
                                  INNER JOIN productos p ON r.producto_id = p.id
                                  WHERE r.insumo_id = :insumo_id 
                                  AND p.estado = 'activo'";
                
                $stmt_recetas = $this->conn->prepare($query_recetas);
                $stmt_recetas->bindParam(':insumo_id', $insumo['id']);
                $stmt_recetas->execute();
                $receta_result = $stmt_recetas->fetch(PDO::FETCH_ASSOC);
                
                // Estimar un consumo mínimo basado en recetas (ej: 1 producción diaria)
                $consumo_diario = ($receta_result['consumo_estimado'] ?? 0) * 0.5;
            }
            
            // Calcular días de stock disponibles
            $stock_actual = $insumo['stock_actual'];
            $dias_stock_actual = $consumo_diario > 0 ? $stock_actual / $consumo_diario : 999;
            
            // Calcular cantidad necesaria
            $consumo_proyectado = $consumo_diario * $dias_proyeccion;
            
            // Fórmula mejorada: Comprar hasta stock máximo + consumo proyectado - stock actual
            // Esto asegura tener stock máximo después del período de proyección
            $stock_objetivo = $insumo['stock_maximo'];
            $cantidad_comprar = max(0, $stock_objetivo + $consumo_proyectado - $stock_actual);
            
            // Agregar margen de seguridad del 10% para insumos críticos
            if ($dias_stock_actual < 7 && $cantidad_comprar > 0) {
                $cantidad_comprar *= 1.1;
            }
            
            // Solo agregar si necesita compra o si el stock no durará el período proyectado
            if ($cantidad_comprar > 0 || $dias_stock_actual < $dias_proyeccion) {
                if ($cantidad_comprar == 0) {
                    // Si no calculó cantidad pero no durará, comprar lo que falta
                    $cantidad_comprar = max(0, $consumo_proyectado - $stock_actual + $insumo['stock_minimo']);
                }
                
                $necesidades[] = [
                    'insumo' => $insumo,
                    'consumo_diario' => round($consumo_diario, 2),
                    'consumo_proyectado' => round($consumo_proyectado, 2),
                    'cantidad_comprar' => round($cantidad_comprar, 2),
                    'costo_estimado' => round($cantidad_comprar * $insumo['costo_unitario'], 2),
                    'dias_stock_actual' => round($dias_stock_actual, 1),
                    'stock_final_proyectado' => round($stock_actual + $cantidad_comprar - $consumo_proyectado, 2)
                ];
            }
        }
        
        return $necesidades;
    }
    
    /**
     * Actualizar stock de insumo
     */
    public function actualizarStock($insumo_id, $nueva_cantidad) {
        $query = "UPDATE " . $this->table . " 
                  SET stock_actual = :stock_actual 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $insumo_id);
        $stmt->bindParam(':stock_actual', $nueva_cantidad);
        
        return $stmt->execute();
    }
}
