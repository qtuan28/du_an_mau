<?php
class Database {
    private $host = "localhost";
    private $db_name = "du_an_mau";
    private $username = "root";
    private $password = "tu12345";
    public $conn;
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8",$this->username,$this->password);
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}