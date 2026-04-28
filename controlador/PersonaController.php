<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../modelos/Persona.php';

$persona = new Persona();

$op = $_GET['op'] ?? '';

try {
    switch ($op) {
        case 'listar':
            $result = $persona->listarPersona();
            echo json_encode($result);
            break;

        case 'guardar':
            $nombre = $_POST['nombre'] ?? '';
            $edad = $_POST['edad'] ?? '';
            
            if (empty($nombre) || empty($edad)) {
                echo json_encode([
                    "status" => false,
                    "message" => "Todos los campos son requeridos"
                ]);
                break;
            }
            
            $result = $persona->insertar($nombre, $edad);
            echo json_encode([
                "status" => $result,
                "message" => $result ? "Guardado correctamente" : "Error al guardar"
            ]);
            break;

        case 'actualizar':
            $id = $_POST['id'] ?? 0;
            $nombre = $_POST['nombre'] ?? '';
            $edad = $_POST['edad'] ?? '';
            
            if ($id <= 0 || empty($nombre) || empty($edad)) {
                echo json_encode([
                    "status" => false,
                    "message" => "Datos inválidos"
                ]);
                break;
            }
            
            $result = $persona->actualizar($id, $nombre, $edad);
            echo json_encode([
                "status" => $result,
                "message" => $result ? "Actualizado correctamente" : "Error al actualizar"
            ]);
            break;

        case 'eliminar':
            $id = $_POST['id'] ?? 0;
            
            if ($id <= 0) {
                echo json_encode([
                    "status" => false,
                    "message" => "ID inválido"
                ]);
                break;
            }
            
            $result = $persona->eliminar($id);
            echo json_encode([
                "status" => $result,
                "message" => $result ? "Eliminado correctamente" : "Error al eliminar"
            ]);
            break;

        default:
            echo json_encode(["error" => "Operación no válida"]);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>