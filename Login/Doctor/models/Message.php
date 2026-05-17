<?php
require_once _DIR_ . '/../config/database.php';
class Message {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getConversations($doctor_id) {
        $stmt = $this->conn->prepare("SELECT DISTINCT u.id, u.name, u.profile_pic, 
                                      (SELECT message FROM messages WHERE (sender_id = u.id OR receiver_id = u.id) AND (receiver_id = ? OR sender_id = ?) ORDER BY created_at DESC LIMIT 1) as last_message,
                                      (SELECT created_at FROM messages WHERE (sender_id = u.id OR receiver_id = u.id) AND (receiver_id = ? OR sender_id = ?) ORDER BY created_at DESC LIMIT 1) as last_time
                                      FROM messages m 
                                      JOIN users u ON (m.sender_id = u.id OR m.receiver_id = u.id)
                                      WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
                                      GROUP BY u.id");
        $stmt->bind_param("iiiiii", $doctor_id, $doctor_id, $doctor_id, $doctor_id, $doctor_id, $doctor_id, $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conversations = [];
        while($row = $result->fetch_assoc()) $conversations[] = $row;
        return $conversations;
    }
    public function getMessages($doctor_id, $other_user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
        $stmt->bind_param("iiii", $doctor_id, $other_user_id, $other_user_id, $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];
        while($row = $result->fetch_assoc()) $messages[] = $row;
        return $messages;
    }
    public function sendMessage($sender_id, $receiver_id, $appointment_id, $message) {
        $stmt = $this->conn->prepare("INSERT INTO messages (sender_id, receiver_id, appointment_id, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $sender_id, $receiver_id, $appointment_id, $message);
        return $stmt->execute();
    }
    public function markRead($doctor_id, $sender_id) {
        $stmt = $this->conn->prepare("UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ?");
        $stmt->bind_param("ii", $doctor_id, $sender_id);
        return $stmt->execute();
    }
}
?>