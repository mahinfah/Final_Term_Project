<?php
class MessageModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getConversations($doctor_user_id, $doctor_id) {
        $sql = "SELECT DISTINCT p.id as patient_id, u.name as patient_name, u.id as patient_user_id,
                (SELECT message FROM messages WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id) 
                 ORDER BY created_at DESC LIMIT 1) as last_message,
                (SELECT created_at FROM messages WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id) 
                 ORDER BY created_at DESC LIMIT 1) as last_time
                FROM patients p 
                JOIN users u ON p.user_id = u.id 
                JOIN appointments a ON a.patient_id = p.id 
                WHERE a.doctor_id = ? 
                GROUP BY p.id
                ORDER BY last_time DESC";
        $result = $this->db->select($sql, [$doctor_user_id, $doctor_user_id, $doctor_user_id, $doctor_user_id, $doctor_id], "iiiii");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMessages($doctor_user_id, $patient_user_id) {
        $sql = "SELECT * FROM messages 
                WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) 
                ORDER BY created_at ASC";
        $result = $this->db->select($sql, [$doctor_user_id, $patient_user_id, $patient_user_id, $doctor_user_id], "iiii");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function sendMessage($sender_id, $receiver_id, $appointment_id, $message) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, appointment_id, message) VALUES (?, ?, ?, ?)";
        return $this->db->insert($sql, [$sender_id, $receiver_id, $appointment_id, $message], "iiis");
    }

    public function markAsRead($receiver_id, $sender_id) {
        $sql = "UPDATE messages SET is_read=1 WHERE receiver_id=? AND sender_id=?";
        return $this->db->execute($sql, [$receiver_id, $sender_id], "ii");
    }
}
?>