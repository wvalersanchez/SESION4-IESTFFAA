<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once '../modelos/Producto.php';

$producto = new Producto();
$op = $_GET['op'] ?? '';

function logOperacion($operacion, $datos = [])
{
    $log = date('Y-m-d H:i:s') . " - [PRODUCTO] $operacion - " . json_encode($datos) . "\n";
    error_log($log);
}

try {
    switch ($op) {
        case 'listar':
            logOperacion('listar');
            $resultado = $producto->listarProductos();
            echo json_encode($resultado['data']);
            break;

        case 'guardar':
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            
            logOperacion('guardar', ['nombre' => $nombre, 'precio' => $precio, 'stock' => $stock]);
            
            if (empty($nombre)) {
                echo json_encode([
                    "status" => false,
                    "message" => "⚠️ El nombre del producto es obligatorio"
                ]);
                break;
            }
            
            if ($precio <= 0) {
                echo json_encode([
                    "status" => false,
                    "message" => "⚠️ El precio debe ser mayor a 0"
                ]);
                break;
            }
            
            if ($stock < 0) {
                echo json_encode([
                    "status" => false,
                    "message" => "⚠️ El stock no puede ser negativo"
                ]);
                break;
            }
            
            $resultado = $producto->insertar($nombre, $descripcion, $precio, $stock);
            echo json_encode($resultado);
            break;

        case 'actualizar':
            $id = (int)($_POST['id'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            
            logOperacion('actualizar', ['id' => $id, 'nombre' => $nombre]);
            
            if ($id <= 0) {
                echo json_encode([
                    "status" => false,
                    "message" => "⚠️ ID inválido"
                ]);
                break;
            }
            
            $resultado = $producto->actualizar($id, $nombre, $descripcion, $precio, $stock);
            echo json_encode($resultado);
            break;

        case 'eliminar':
            $id = (int)($_POST['id'] ?? 0);
            
            logOperacion('eliminar', ['id' => $id]);
            
            if ($id <= 0) {
                echo json_encode([
                    "status" => false,
                    "message" => "⚠️ ID inválido"
                ]);
                break;
            }
            
            $resultado = $producto->eliminar($id);
            echo json_encode($resultado);
            break;
            
        case 'buscar':
            $id = (int)($_GET['id'] ?? 0);
            $resultado = $producto->buscarPorId($id);
            echo json_encode($resultado);
            break;
            
        case 'total':
            $total = $producto->totalProductos();
            $valorInventario = $producto->valorInventario();
            echo json_encode([
                "total" => $total,
                "valorInventario" => $valorInventario
            ]);
            break;
            
        case 'bajoStock':
            $limite = $_GET['limite'] ?? 10;
            $resultado = $producto->productosBajoStock($limite);
            echo json_encode($resultado);
            break;

        default:
            echo json_encode([
                "status" => false,
                "error" => "Operación no válida",
                "operaciones_disponibles" => ["listar", "guardar", "actualizar", "eliminar", "buscar", "total", "bajoStock"]
            ]);
            break;
    }
} catch (Exception $e) {
    logOperacion('ERROR', ['message' => $e->getMessage()]);
    echo json_encode([
        "status" => false,
        "message" => "Error del servidor: " . $e->getMessage()
    ]);
}
?>