<?php
require_once 'config/database.php';
class Announcement {
    private mysqli $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getForRole($role) {
        $stmt = $this->conn->prepare("SELECT a.*, u.name as author_name FROM announcements a JOIN users u ON a.author_id = u.id WHERE a.target_role = 'all' OR a.target_role = ? ORDER BY a.published_at DESC");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = [];
        while($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }
}
?>