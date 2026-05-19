<?php
class Database {
    private $host = "localhost";
    private $db_name = "hospital_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8mb4");
        } catch(Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>