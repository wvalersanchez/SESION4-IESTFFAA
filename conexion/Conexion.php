<?php

class Conexion
{
    //variables privadas que alamcena las credenciales de conexion a la bd
    private $host = "localhost"; //localhost = 127.0.0.1 ip local de la pc
    private $db = "crud_iestpffaa"; //nombre de la base de datos a usar
    private $user = "root"; //nombre del usaurio definido en mysql, por defecto root
    private $pass = ""; //contraseña asginado al usaurio mysql, por defecto vacio

    public $conn; //-> varible publico que se utilizara de manera global

    public function conectar()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo 'Error de conexion a la base de datos' . $e->getMessage();
        }
    }
}