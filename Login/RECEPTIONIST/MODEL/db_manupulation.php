<?php

// Insert new user
function insert_on_DB($name, $email, $password, $phone, $role, $profile_pic, $is_active, $conn) {
    $sql = "INSERT INTO users (name, email, password_hash, phone, role, profile_pic, is_active) 
            VALUES ('$name', '$email', '$password', '$phone', '$role', '$profile_pic', '$is_active')";
    return mysqli_query($conn, $sql);
}

// Get receptionist profile
function getReceptionistProfile($conn, $email) {
    $sql = "SELECT name, email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row == null) {
        return ['name' => 'Not Found', 'email' => 'Not Found'];
    }
    return $row;
}

// Count total appointments
function countAppointments($conn) {
    $sql = "SELECT COUNT(*) AS total FROM appointments";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Load all appointments
function appointmentLoad($conn) {
    $sql = "SELECT * FROM appointments";
    $result = mysqli_query($conn, $sql);
    $appointments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = array(
            "id"               => $row['id'],
            "patient_id"       => $row['patient_id'],
            "doctor_id"        => $row['doctor_id'],
            "appointment_date" => $row['appointment_date'],
            "appointment_time" => $row['appointment_time'],
            "reason"           => $row['reason'],
            "status"           => $row['status'],
            "booked_by"        => $row['booked_by']
        );
    }
    return $appointments;
}

// Get today appointments joined with patient and doctor name
function getTodayAppointments($conn) {
    $sql = "SELECT a.*, 
                   u_patient.name AS patient_name,
                   u_doctor.name  AS doctor_name
            FROM appointments a
            JOIN patients p      ON a.patient_id = p.id
            JOIN users u_patient ON p.user_id    = u_patient.id
            JOIN doctors d       ON a.doctor_id  = d.id
            JOIN users u_doctor  ON d.user_id    = u_doctor.id
            WHERE DATE(a.appointment_date) = CURDATE()
            ORDER BY a.doctor_id, a.appointment_time";

    $result = mysqli_query($conn, $sql);
    $appointments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }
    return $appointments;
}

// Search patients by name, phone or patient id
function searchPatients($conn, $search) {
    $sql = "SELECT p.id, p.user_id, p.date_of_birth, p.blood_group,
                   p.gender, p.address, p.emergency_contact_name,
                   p.emergency_contact_phone, p.medical_history_notes,
                   u.name, u.email, u.phone
            FROM patients p
            JOIN users u ON p.user_id = u.id
            WHERE u.name  LIKE '%$search%'
            OR u.phone    LIKE '%$search%'
            OR p.id            = '$search'";

    $result = mysqli_query($conn, $sql);
    $patients = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
    return $patients;
}

// Get single patient profile
function getPatientProfile($conn, $patient_id) {
    $sql = "SELECT p.id, p.user_id, p.date_of_birth, p.blood_group,
                   p.gender, p.address, p.emergency_contact_name,
                   p.emergency_contact_phone, p.medical_history_notes,
                   u.name, u.email, u.phone
            FROM patients p
            JOIN users u ON p.user_id = u.id
            WHERE p.id = '$patient_id'";

    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Get upcoming appointments of a patient
function getPatientUpcomingAppointments($conn, $patient_id) {
    $sql = "SELECT a.*, du.name AS doctor_name
            FROM appointments a
            JOIN doctors d  ON a.doctor_id = d.id
            JOIN users du   ON d.user_id   = du.id
            WHERE a.patient_id      = '$patient_id'
            AND a.appointment_date >= CURDATE()
            ORDER BY a.appointment_date, a.appointment_time";

    $result = mysqli_query($conn, $sql);
    $appointments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }
    return $appointments;
}

// Get billing of a patient
function getPatientBilling($conn, $patient_id) {
    $sql = "SELECT id, appointment_id, patient_id,
                   amount, payment_method, payment_status, paid_at
            FROM billing
            WHERE patient_id = '$patient_id'
            ORDER BY paid_at DESC";

    $result = mysqli_query($conn, $sql);
    $bills = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = $row;
    }
    return $bills;
}

// Get all doctors
function getDoctors($conn) {
    $sql = "SELECT d.id, u.name 
            FROM doctors d
            JOIN users u ON d.user_id = u.id";
    $result = mysqli_query($conn, $sql);
    $doctors = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
    return $doctors;
}

// Book appointment
function bookAppointment($conn, $patient_id, $doctor_id, $date, $time, $reason) {
    $sql = "INSERT INTO appointments 
                (patient_id, doctor_id, appointment_date, appointment_time, reason, status, booked_by)
            VALUES 
                ('$patient_id', '$doctor_id', '$date', '$time', '$reason', 'pending', 'receptionist')";
    return mysqli_query($conn, $sql);
}

//  Get outstanding bills - FIXED unpaid to pending
function getOutstandingBills($conn) {
    $sql = "SELECT b.id, b.appointment_id, b.patient_id, 
                   b.amount, b.payment_method, b.payment_status, b.paid_at,
                   u.name AS patient_name,
                   a.appointment_date, a.appointment_time, a.reason
            FROM billing b
            JOIN patients p     ON b.patient_id     = p.id
            JOIN users u        ON p.user_id         = u.id
            JOIN appointments a ON b.appointment_id  = a.id
            WHERE b.payment_status = 'pending'
            ORDER BY b.id DESC";

    $result = mysqli_query($conn, $sql);
    $bills  = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = $row;
    }
    return $bills;
}

// Get single bill by id
function getBillById($conn, $bill_id) {
    $sql = "SELECT b.id, 
                   b.appointment_id, 
                   b.patient_id,
                   b.amount, 
                   b.payment_method, 
                   b.payment_status, 
                   b.paid_at,
                   u.name  AS patient_name, 
                   u.phone AS phone,
                   a.appointment_date, 
                   a.appointment_time, 
                   a.reason,
                   du.name AS doctor_name
            FROM billing b
            JOIN patients p     ON b.patient_id     = p.id
            JOIN users u        ON p.user_id         = u.id
            JOIN appointments a ON b.appointment_id  = a.id
            JOIN doctors d      ON a.doctor_id       = d.id
            JOIN users du       ON d.user_id         = du.id
            WHERE b.id = '$bill_id'";

    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Mark bill as paid
function markBillAsPaid($conn, $bill_id, $payment_method) {
    $sql = "UPDATE billing 
            SET payment_status = 'paid',
                payment_method = '$payment_method',
                paid_at        = NOW()
            WHERE id = '$bill_id'";
    return mysqli_query($conn, $sql);
}

function registerUser($conn, $name, $email, $password, $phone) {

    //  Check if email already exists
    $check = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        return false; //  Email already exists
    }

    //  Insert if email not found
    $sql = "INSERT INTO users (name, email, password_hash, phone, role, is_active)
            VALUES ('$name', '$email', '$password', '$phone', 'patient', 1)";
    return mysqli_query($conn, $sql);
}
//
function registerPatient($conn, $user_id, $dob, $blood_group, $gender, $address, $emergency_name, $emergency_phone, $medical_history) {
    $sql = "INSERT INTO patients (user_id, date_of_birth, blood_group, gender, address, emergency_contact_name, emergency_contact_phone, medical_history_notes)
            VALUES ('$user_id', '$dob', '$blood_group', '$gender', '$address', '$emergency_name', '$emergency_phone', '$medical_history')";
    return mysqli_query($conn, $sql);
}