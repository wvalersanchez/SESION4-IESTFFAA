<?php
require_once '../conexion/Conexion.php';

class Producto
{
    private $conn;
    private $table = 'productos';

    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->conectar();
    }

    // Validar datos del producto
    private function validarDatos($nombre, $precio, $stock)
    {
        $errores = [];
        
        if (empty($nombre) || strlen($nombre) < 3) {
            $errores[] = "El nombre debe tener al menos 3 caracteres";
        }
        
        if (!is_numeric($precio) || $precio <= 0) {
            $errores[] = "El precio debe ser mayor a 0";
        }
        
        if (!is_numeric($stock) || $stock < 0) {
            $errores[] = "El stock no puede ser negativo";
        }
        
        return $errores;
    }

    // Listar todos los productos
    public function listarProductos()
    {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id_producto DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            return [
                "status" => true,
                "data" => $result,
                "total" => count($result)
            ];
        } catch (PDOException $e) {
            error_log("Error listar productos: " . $e->getMessage());
            return [
                "status" => false,
                "data" => [],
                "message" => "Error al listar productos"
            ];
        }
    }

    // Insertar nuevo producto
    public function insertar($nombre, $descripcion, $precio, $stock)
    {
        try {
            $errores = $this->validarDatos($nombre, $precio, $stock);
            if (!empty($errores)) {
                return [
                    "status" => false,
                    "message" => implode(", ", $errores)
                ];
            }
            
            $sql = "INSERT INTO {$this->table} (nombre, descripcion, precio, stock) 
                    VALUES (:nombre, :descripcion, :precio, :stock)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':nombre' => trim($nombre),
                ':descripcion' => $descripcion ?: null,
                ':precio' => $precio,
                ':stock' => $stock
            ]);
            
            return [
                "status" => $result,
                "message" => $result ? "✅ Producto guardado exitosamente" : "❌ Error al guardar producto",
                "id" => $this->conn->lastInsertId()
            ];
        } catch (PDOException $e) {
            error_log("Error insertar producto: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Error en la base de datos"
            ];
        }
    }

    // Actualizar producto
    public function actualizar($id, $nombre, $descripcion, $precio, $stock)
    {
        try {
            if (!$id || $id <= 0) {
                return [
                    "status" => false,
                    "message" => "ID inválido"
                ];
            }
            
            $errores = $this->validarDatos($nombre, $precio, $stock);
            if (!empty($errores)) {
                return [
                    "status" => false,
                    "message" => implode(", ", $errores)
                ];
            }
            
            $sql = "UPDATE {$this->table} SET 
                    nombre = :nombre, 
                    descripcion = :descripcion, 
                    precio = :precio, 
                    stock = :stock 
                    WHERE id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':id' => $id,
                ':nombre' => trim($nombre),
                ':descripcion' => $descripcion ?: null,
                ':precio' => $precio,
                ':stock' => $stock
            ]);
            
            return [
                "status" => $result,
                "message" => $result ? "✅ Producto actualizado exitosamente" : "❌ Error al actualizar"
            ];
        } catch (PDOException $e) {
            error_log("Error actualizar producto: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Error en la base de datos"
            ];
        }
    }

    // Eliminar producto
    public function eliminar($id)
    {
        try {
            if (!$id || $id <= 0) {
                return [
                    "status" => false,
                    "message" => "ID inválido"
                ];
            }
            
            // Verificar si existe
            $checkSql = "SELECT id_producto FROM {$this->table} WHERE id_producto = :id";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([':id' => $id]);
            
            if (!$checkStmt->fetch()) {
                return [
                    "status" => false,
                    "message" => "El producto no existe"
                ];
            }
            
            $sql = "DELETE FROM {$this->table} WHERE id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            return [
                "status" => $result,
                "message" => $result ? "✅ Producto eliminado exitosamente" : "❌ Error al eliminar"
            ];
        } catch (PDOException $e) {
            error_log("Error eliminar producto: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Error en la base de datos"
            ];
        }
    }

    // Buscar producto por ID
    public function buscarPorId($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error buscar producto: " . $e->getMessage());
            return null;
        }
    }

    // Actualizar stock
    public function actualizarStock($id, $stock)
    {
        try {
            $sql = "UPDATE {$this->table} SET stock = :stock WHERE id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':stock' => $stock
            ]);
        } catch (PDOException $e) {
            error_log("Error actualizar stock: " . $e->getMessage());
            return false;
        }
    }

    // Productos con bajo stock
    public function productosBajoStock($limite = 10)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE stock <= :limite ORDER BY stock ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':limite' => $limite]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error bajo stock: " . $e->getMessage());
            return [];
        }
    }

    // Total de productos
    public function totalProductos()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Valor total del inventario
    public function valorInventario()
    {
        try {
            $sql = "SELECT SUM(precio * stock) as total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?>