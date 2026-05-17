<?php
session_start();

define('ROOT_PATH', dirname(__DIR__) . '/');

require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'models/Doctor.php';
require_once ROOT_PATH . 'models/Appointment.php';
require_once ROOT_PATH . 'models/ConsultationNote.php';
require_once ROOT_PATH . 'models/Review.php';
require_once ROOT_PATH . 'models/Message.php';

class DoctorController {
    private $db, $doctorModel, $appointmentModel, $consultModel, $reviewModel, $messageModel;
    private $doctor_id, $user_id;

    public function __construct($db) {
        $this->db = $db;
        $this->doctorModel = new DoctorModel($db);
        $this->appointmentModel = new AppointmentModel($db);
        $this->consultModel = new ConsultationNoteModel($db);
        $this->reviewModel = new ReviewModel($db);
        $this->messageModel = new MessageModel($db);
        
        if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'doctor') {
            $this->user_id = $_SESSION['user_id'];
            $doc = $this->doctorModel->getDoctorByUserId($this->user_id);
            $this->doctor_id = $doc ? $doc['id'] : null;
        }
    }

    private function isLoggedIn() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM users WHERE email=? AND role='doctor' AND is_active=1";
            $result = $this->db->select($sql, [$email], "s");
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'doctor';
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Invalid email or password";
            }
        }
        include ROOT_PATH . 'views/doctor/login.php';
    }

    public function dashboard() {
        $this->isLoggedIn();
        $today = date('Y-m-d');
        $pending = $this->db->select("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id=? AND appointment_date=? AND status='pending'", [$this->doctor_id, $today], "is")->fetch_assoc()['cnt'];
        $confirmed = $this->db->select("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id=? AND appointment_date=? AND status='confirmed'", [$this->doctor_id, $today], "is")->fetch_assoc()['cnt'];
        $completed = $this->db->select("SELECT COUNT(*) as cnt FROM appointments WHERE doctor_id=? AND status='completed'", [$this->doctor_id], "i")->fetch_assoc()['cnt'];
        include ROOT_PATH . 'views/doctor/dashboard.php';
    }

    public function profile() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bio = $_POST['bio'];
            $specialization_id = $_POST['specialization_id'];
            $fee = $_POST['consultation_fee'];
            $experience = $_POST['experience_years'];
            $license = $_POST['license_number'];
            $this->doctorModel->updateProfile($this->doctor_id, $bio, $specialization_id, $fee, $experience, $license);
            
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "uploads/doctors/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $filename = "doctor_" . $this->doctor_id . "_" . time() . "." . $ext;
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    $this->doctorModel->updatePhoto($this->doctor_id, $target_file);
                }
            }
            $success = "Profile updated successfully";
        }
        $doctor = $this->doctorModel->getDoctorByUserId($this->user_id);
        $specializations = $this->doctorModel->getSpecializations();
        include ROOT_PATH . 'views/doctor/profile.php';
    }

    public function availability() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->db->execute("DELETE FROM doctor_availability WHERE doctor_id=?", [$this->doctor_id], "i");
            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            foreach ($days as $day) {
                $start = $_POST["start_$day"] ?? null;
                $end = $_POST["end_$day"] ?? null;
                $duration = $_POST["duration_$day"] ?? 30;
                $available = isset($_POST["available_$day"]) ? 1 : 0;
                if ($available && $start && $end) {
                    $sql = "INSERT INTO doctor_availability (doctor_id, day_of_week, start_time, end_time, slot_duration_minutes, is_available) VALUES (?,?,?,?,?,1)";
                    $this->db->execute($sql, [$this->doctor_id, $day, $start, $end, $duration], "isssi");
                }
            }
            $success = "Availability saved";
        }
        $avail = [];
        $result = $this->db->select("SELECT * FROM doctor_availability WHERE doctor_id=?", [$this->doctor_id], "i");
        while ($row = $result->fetch_assoc()) {
            $avail[$row['day_of_week']] = $row;
        }
        include ROOT_PATH . 'views/doctor/availability.php';
    }

    public function leaveDates() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_leave'])) {
            $date = $_POST['leave_date'];
            $reason = $_POST['reason'];
            $this->db->execute("INSERT INTO leave_dates (doctor_id, leave_date, reason) VALUES (?,?,?)", [$this->doctor_id, $date, $reason], "iss");
            $success = "Leave date added";
        }
        if (isset($_GET['delete'])) {
            $this->db->execute("DELETE FROM leave_dates WHERE id=? AND doctor_id=?", [$_GET['delete'], $this->doctor_id], "ii");
            header("Location: index.php?action=leave_dates");
            exit;
        }
        $leaves = $this->db->select("SELECT * FROM leave_dates WHERE doctor_id=? ORDER BY leave_date", [$this->doctor_id], "i")->fetch_all(MYSQLI_ASSOC);
        include ROOT_PATH . 'views/doctor/leave_dates.php';
    }

    public function todaySchedule() {
        $this->isLoggedIn();
        $appointments = $this->appointmentModel->getTodayAppointments($this->doctor_id);
        include ROOT_PATH . 'views/doctor/today_schedule.php';
    }

    public function weeklyCalendar() {
        $this->isLoggedIn();
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime('+6 days'));
        $appointments = $this->appointmentModel->getWeeklyAppointments($this->doctor_id, $start, $end);
        include ROOT_PATH . 'views/doctor/weekly_calendar.php';
    }

    public function confirmAppointment() {
        $this->isLoggedIn();
        if (isset($_GET['id'])) {
            $this->appointmentModel->updateStatus($_GET['id'], 'confirmed');
        }
        header("Location: index.php?action=today_schedule");
    }

    public function rejectAppointment() {
        $this->isLoggedIn();
        if (isset($_GET['id'])) {
            $this->appointmentModel->updateStatus($_GET['id'], 'cancelled');
        }
        header("Location: index.php?action=today_schedule");
    }

    public function noShowAppointment() {
        $this->isLoggedIn();
        if (isset($_GET['id'])) {
            $this->appointmentModel->updateStatus($_GET['id'], 'no_show');
        }
        header("Location: index.php?action=today_schedule");
    }

    public function checkinAjax() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment_id = $_POST['appointment_id'];
            $sql = "UPDATE appointments SET status='checked_in' WHERE id=? AND doctor_id=?";
            $success = $this->db->execute($sql, [$appointment_id, $this->doctor_id], "ii");
            echo json_encode(['success' => $success]);
            exit;
        }
    }

    public function addConsultation() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment_id = $_POST['appointment_id'];
            $symptoms = $_POST['symptoms'];
            $diagnosis = $_POST['diagnosis'];
            $prescription = $_POST['prescription'];
            $follow_up = $_POST['follow_up_date'] ?: null;
            $apt = $this->appointmentModel->getAppointmentById($appointment_id, $this->doctor_id);
            if ($apt) {
                $this->consultModel->addNote($appointment_id, $this->doctor_id, $apt['patient_id'], $symptoms, $diagnosis, $prescription, $follow_up);
                $this->appointmentModel->updateStatus($appointment_id, 'completed');
                header("Location: index.php?action=today_schedule");
                exit;
            }
        }
        $appointment_id = $_GET['id'];
        $appointment = $this->appointmentModel->getAppointmentById($appointment_id, $this->doctor_id);
        include ROOT_PATH . 'views/doctor/consultation_note.php';
    }

    public function patientNotes() {
        $this->isLoggedIn();
        $patient_user_id = $_GET['patient_id'];
        $notes = $this->consultModel->getPatientNotes($this->doctor_id, $patient_user_id);
        include ROOT_PATH . 'views/doctor/patient_notes.php';
    }

    public function reviews() {
        $this->isLoggedIn();
        $reviews = $this->reviewModel->getForDoctor($this->doctor_id);
        include ROOT_PATH . 'views/doctor/reviews.php';
    }

    public function replyReview() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $review_id = $_POST['review_id'];
            $reply = $_POST['reply'];
            $this->reviewModel->addReply($review_id, $reply);
            header("Location: index.php?action=reviews");
            exit;
        }
    }

    public function earnings() {
        $this->isLoggedIn();
        $period = $_GET['period'] ?? 'month';
        if ($period == 'day') $group = "DATE(a.appointment_date)";
        elseif ($period == 'week') $group = "YEARWEEK(a.appointment_date)";
        else $group = "DATE_FORMAT(a.appointment_date, '%Y-%m')";
        $sql = "SELECT $group as label, COUNT(*) as completed, SUM(d.consultation_fee) as total_earned 
                FROM appointments a 
                JOIN doctors d ON a.doctor_id = d.id 
                WHERE a.doctor_id = ? AND a.status = 'completed' 
                GROUP BY label ORDER BY label DESC LIMIT 12";
        $result = $this->db->select($sql, [$this->doctor_id], "i");
        $earnings = $result->fetch_all(MYSQLI_ASSOC);
        include ROOT_PATH . 'views/doctor/earnings.php';
    }

    public function statistics() {
        $this->isLoggedIn();
        $total_sql = "SELECT 
                        SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as completed,
                        SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) as cancelled,
                        SUM(CASE WHEN status='no_show' THEN 1 ELSE 0 END) as noshow
                      FROM appointments WHERE doctor_id=?";
        $totals = $this->db->select($total_sql, [$this->doctor_id], "i")->fetch_assoc();
        $total = $totals['completed'] + $totals['cancelled'] + $totals['noshow'];
        $noshow_rate = $total ? round($totals['noshow'] / $total * 100, 2) : 0;
        
        $busy_days = $this->db->select("SELECT DAYNAME(appointment_date) as day, COUNT(*) as cnt FROM appointments WHERE doctor_id=? GROUP BY day ORDER BY cnt DESC LIMIT 3", [$this->doctor_id], "i")->fetch_all(MYSQLI_ASSOC);
        $busy_times = $this->db->select("SELECT HOUR(appointment_time) as hour, COUNT(*) as cnt FROM appointments WHERE doctor_id=? GROUP BY hour ORDER BY cnt DESC LIMIT 3", [$this->doctor_id], "i")->fetch_all(MYSQLI_ASSOC);
        
        include ROOT_PATH . 'views/doctor/statistics.php';
    }

    public function followups() {
        $this->isLoggedIn();
        $followups = $this->consultModel->getFollowUps($this->doctor_id);
        include ROOT_PATH . 'views/doctor/followups.php';
    }

    public function messages() {
        $this->isLoggedIn();
        if (isset($_GET['patient_id'])) {
            $patient_user_id = $_GET['patient_id'];
            $this->messageModel->markAsRead($this->user_id, $patient_user_id);
            $messages = $this->messageModel->getMessages($this->user_id, $patient_user_id);
            include ROOT_PATH . 'views/doctor/message_detail.php';
        } else {
            $conversations = $this->messageModel->getConversations($this->user_id, $this->doctor_id);
            include ROOT_PATH . 'views/doctor/messages.php';
        }
    }

    public function sendMessage() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $receiver_id = $_POST['receiver_id'];
            $message = $_POST['message'];
            $appointment_id = $_POST['appointment_id'] ?? null;
            $this->messageModel->sendMessage($this->user_id, $receiver_id, $appointment_id, $message);
            header("Location: index.php?action=messages&patient_id=" . $receiver_id);
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
?>