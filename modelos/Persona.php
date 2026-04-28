<?php
require_once '../conexion/Conexion.php';

class Persona
{
    private $conn;
    private $table = 'persona';

    public function __construct()
    {
        $db = new Conexion();
        $this->conn = $db->conectar();
    }

    public function listarPersona()
    {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en listarPersona: " . $e->getMessage());
            return [];
        }
    }

    public function insertar($nombre, $edad)
    {
        try {
            $sql = "INSERT INTO {$this->table} (nombre, edad) VALUES (:nombre, :edad)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':edad' => $edad
            ]);
        } catch (PDOException $e) {
            error_log("Error en insertar: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar($id, $nombre, $edad)
    {
        try {
            $sql = "UPDATE {$this->table} SET nombre = :nombre, edad = :edad WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':nombre' => $nombre,
                ':edad' => $edad
            ]);
        } catch (PDOException $e) {
            error_log("Error en actualizar: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error en eliminar: " . $e->getMessage());
            return false;
        }
    }
}
?>