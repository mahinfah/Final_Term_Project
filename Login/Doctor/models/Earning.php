<?php
require_once _DIR_ . '/../config/database.php';
class Earning {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getEarnings($doctor_id, $period = 'day') {
        // period: 'day', 'week', 'month'
        $interval = "DAY";
        if($period == 'week') $interval = "WEEK";
        if($period == 'month') $interval = "MONTH";
        $sql = "SELECT DATE_FORMAT(a.appointment_date, '%Y-%m-%d') as date, COUNT(*) as completed, SUM(d.consultation_fee) as total
                FROM appointments a
                JOIN doctors d ON a.doctor_id = d.id
                WHERE a.doctor_id = $doctor_id AND a.status = 'completed'
                GROUP BY DATE_FORMAT(a.appointment_date, '%Y-%m-%d')
                ORDER BY date DESC";
        $result = $this->conn->query($sql);
        $earnings = [];
        while($row = $result->fetch_assoc()) $earnings[] = $row;
        return $earnings;
    }
    public function getStats($doctor_id) {
        $stats = [];
        $total_completed = $this->conn->query("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'completed'")->fetch_assoc()['cnt'];
        $total_cancelled = $this->conn->query("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'cancelled'")->fetch_assoc()['cnt'];
        $total_no_show = $this->conn->query("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'no_show'")->fetch_assoc()['cnt'];
        $stats['completed'] = $total_completed;
        $stats['cancelled'] = $total_cancelled;
        $stats['no_show'] = $total_no_show;
        $stats['no_show_rate'] = ($total_completed + $total_cancelled + $total_no_show) > 0 ? round($total_no_show / ($total_completed + $total_cancelled + $total_no_show) * 100, 2) : 0;
        
        // Busiest days: day of week counts
        $busy = $this->conn->query("SELECT DAYNAME(appointment_date) as day, COUNT(*) as cnt FROM appointments WHERE doctor_id = $doctor_id GROUP BY DAYNAME(appointment_date) ORDER BY cnt DESC LIMIT 1");
        $stats['busiest_day'] = $busy->num_rows ? $busy->fetch_assoc()['day'] : 'N/A';
        
        $busy_hour = $this->conn->query("SELECT HOUR(appointment_time) as hour, COUNT(*) as cnt FROM appointments WHERE doctor_id = $doctor_id GROUP BY HOUR(appointment_time) ORDER BY cnt DESC LIMIT 1");
        $stats['busiest_hour'] = $busy_hour->num_rows ? $busy_hour->fetch_assoc()['hour'] . ':00' : 'N/A';
        return $stats;
    }
}
?>