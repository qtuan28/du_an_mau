<?php
class Database {
    private $host = "127.0.0.1";
    private $port = "3306";
    private $db_name = "du_an_mau";
    private $username = "root";
    private $password = "tu12345";
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}