<?php
class DoctorModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getDoctorByUserId($user_id) {
        $sql = "SELECT d.*, u.name, u.email, u.phone, u.profile_pic, s.name as specialization_name 
                FROM doctors d 
                JOIN users u ON d.user_id = u.id 
                LEFT JOIN specializations s ON d.specialization_id = s.id 
                WHERE d.user_id = ?";
        $result = $this->db->select($sql, [$user_id], "i");
        return $result->fetch_assoc();
    }

    public function updateProfile($doctor_id, $bio, $specialization_id, $fee, $experience, $license) {
        $sql = "UPDATE doctors SET bio=?, specialization_id=?, consultation_fee=?, experience_years=?, license_number=? WHERE id=?";
        return $this->db->execute($sql, [$bio, $specialization_id, $fee, $experience, $license, $doctor_id], "sidiis");
    }

    public function updatePhoto($doctor_id, $photo_path) {
        $sql = "UPDATE doctors SET photo_path=? WHERE id=?";
        return $this->db->execute($sql, [$photo_path, $doctor_id], "si");
    }

    public function getSpecializations() {
        $result = $this->db->select("SELECT * FROM specializations ORDER BY name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>