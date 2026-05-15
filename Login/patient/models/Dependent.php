<?php
require_once 'config/database.php';
class Dependent {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function add($patient_id, $name, $dob, $relationship, $blood_group) {
        $stmt = $this->conn->prepare("INSERT INTO dependents (primary_patient_id, name, date_of_birth, relationship, blood_group) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $patient_id, $name, $dob, $relationship, $blood_group);
        return $stmt->execute();
    }
    public function getByPatient($patient_id) {
        $stmt = $this->conn->prepare("SELECT * FROM dependents WHERE primary_patient_id = ?");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = [];
        while($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }
    public function update($id, $patient_id, $name, $dob, $relationship, $blood_group) {
        $stmt = $this->conn->prepare("UPDATE dependents SET name=?, date_of_birth=?, relationship=?, blood_group=? WHERE id=? AND primary_patient_id=?");
        $stmt->bind_param("ssssii", $name, $dob, $relationship, $blood_group, $id, $patient_id);
        return $stmt->execute();
    }
    public function delete($id, $patient_id) {
        $stmt = $this->conn->prepare("DELETE FROM dependents WHERE id = ? AND primary_patient_id = ?");
        $stmt->bind_param("ii", $id, $patient_id);
        return $stmt->execute();
    }
}
?>