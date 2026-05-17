<?php
require_once __DIR__ . '/../config/database.php';

class Message {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    
    public function getConversations($doctor_id) {
        $sql = "SELECT DISTINCT u.id, u.name, u.profile_pic
                FROM messages m
                JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id)
                WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
                GROUP BY u.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $doctor_id, $doctor_id, $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $conversations = [];
        while ($row = $result->fetch_assoc()) {
            // Get last message for each conversation
            $last_sql = "SELECT message, created_at FROM messages 
                         WHERE (sender_id = ? AND receiver_id = ?) 
                            OR (sender_id = ? AND receiver_id = ?)
                         ORDER BY created_at DESC LIMIT 1";
            $last_stmt = $this->conn->prepare($last_sql);
            $last_stmt->bind_param("iiii", $doctor_id, $row['id'], $row['id'], $doctor_id);
            $last_stmt->execute();
            $last_res = $last_stmt->get_result();
            if ($last = $last_res->fetch_assoc()) {
                $row['last_message'] = $last['message'];
                $row['last_time'] = $last['created_at'];
            } else {
                $row['last_message'] = '';
                $row['last_time'] = '';
            }
            $conversations[] = $row;
        }
        return $conversations;
    }
    

    public function getMessages($doctor_id, $other_user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM messages 
                                      WHERE (sender_id = ? AND receiver_id = ?)
                                         OR (sender_id = ? AND receiver_id = ?)
                                      ORDER BY created_at ASC");
        $stmt->bind_param("iiii", $doctor_id, $other_user_id, $other_user_id, $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
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
