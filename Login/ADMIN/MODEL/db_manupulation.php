<?php

function insert_on_DB($name, $email, $password, $phone, $role,$profile_pic, $is_active, $conn) {

    $sql = "INSERT INTO users(name, email, password_hash, phone, role, profile_pic, is_active) VALUES ('$name', '$email', '$password', '$phone', '$role', '$profile_pic', '$is_active')";
    return mysqli_query($conn, $sql);
}

function countAppointments($conn) {
    $sql = "SELECT COUNT(*) AS total FROM appointments";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function appointmentLoad($conn){

    $sql = "SELECT * FROM appointments";

    $result = mysqli_query($conn, $sql);

    $appointments = array();

    while($row = mysqli_fetch_assoc($result)){

        $appointment = array(

            "id" => $row['id'],
            "patient_id" => $row['patient_id'],
            "doctor_id" => $row['doctor_id'],
            "appointment_date" => $row['appointment_date'],
            "appointment_time" => $row['appointment_time'],
            "reason" => $row['reason'],
            "status" => $row['status'],
            "booked_by" => $row['booked_by']

        );

        array_push($appointments, $appointment);
    }

    return $appointments;
}

//  Get all specializations for dropdown
function getSpecializations($conn) {
    $sql = "SELECT id, name FROM specializations";
    $result = mysqli_query($conn, $sql);
    $specializations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $specializations[] = $row;
    }
    return $specializations;
}

// Register doctor user account
function registerDoctorUser($conn, $name, $email, $password, $phone) {

    // Check if email already exists
    $check  = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    //  Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password_hash, phone, role, is_active)
            VALUES ('$name', '$email', '$hashed', '$phone', 'doctor', 1)";
    return mysqli_query($conn, $sql);
}

//  Register doctor profile
function registerDoctor($conn, $user_id, $specialization_id, $bio, $consultation_fee, $photo_path, $license_number, $experience_years) {
    $sql = "INSERT INTO doctors 
                (user_id, specialization_id, bio, consultation_fee, photo_path, license_number, experience_years, is_approved)
            VALUES 
                ('$user_id', '$specialization_id', '$bio', '$consultation_fee', '$photo_path', '$license_number', '$experience_years', 0)";
    return mysqli_query($conn, $sql);
}

//  Get all receptionists
function getAllReceptionists($conn) {
    $sql = "SELECT * FROM users WHERE role = 'receptionist'";
    $result = mysqli_query($conn, $sql);
    $receptionists = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $receptionists[] = $row;
    }
    return $receptionists;
}

//  Get single receptionist by id
function getReceptionistById($conn, $id) {
    $sql    = "SELECT * FROM users WHERE id = '$id' AND role = 'receptionist'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Create receptionist
function createReceptionist($conn, $name, $email, $password, $phone) {

    //  Check email exists
    $check  = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql    = "INSERT INTO users (name, email, password_hash, phone, role, is_active)
               VALUES ('$name', '$email', '$hashed', '$phone', 'receptionist', 1)";
    return mysqli_query($conn, $sql);
}

//  Edit receptionist
function editReceptionist($conn, $id, $name, $email, $phone) {
    $sql = "UPDATE users 
            SET name  = '$name',
                email = '$email',
                phone = '$phone'
            WHERE id = '$id' AND role = 'receptionist'";
    return mysqli_query($conn, $sql);
}

//  Deactivate receptionist
function deactivateReceptionist($conn, $id) {
    $sql = "UPDATE users 
            SET is_active = 0
            WHERE id = '$id' AND role = 'receptionist'";
    return mysqli_query($conn, $sql);
}

//  Activate receptionist
function activateReceptionist($conn, $id) {
    $sql = "UPDATE users 
            SET is_active = 1
            WHERE id = '$id' AND role = 'receptionist'";
    return mysqli_query($conn, $sql);
}

//  Get all specializations
function getAllSpecializations($conn) {
    $sql    = "SELECT * FROM specializations";
    $result = mysqli_query($conn, $sql);
    $specializations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $specializations[] = $row;
    }
    return $specializations;
}

//  Get single specialization by id
function getSpecializationById($conn, $id) {
    $sql    = "SELECT * FROM specializations WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

//  Add specialization
function addSpecialization($conn, $name, $description) {
    $sql = "INSERT INTO specializations (name, description)
            VALUES ('$name', '$description')";
    return mysqli_query($conn, $sql);
}

//  Rename specialization
function renameSpecialization($conn, $id, $name, $description) {
    $sql = "UPDATE specializations 
            SET name        = '$name',
                description = '$description'
            WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}

//  Delete specialization
function deleteSpecialization($conn, $id) {
    $sql = "DELETE FROM specializations WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}
//  Count total registered patients
function countPatients($conn) {
    $sql    = "SELECT COUNT(*) AS total FROM patients";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return $row['total'];
}

//  Count total active doctors
function countActiveDoctors($conn) {
    $sql    = "SELECT COUNT(*) AS total FROM users WHERE role = 'doctor' AND is_active = 1";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Count total pending billing
function countPendingBilling($conn) {
    $sql    = "SELECT COUNT(*) AS total FROM billing WHERE payment_status = 'pending'";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Get total revenue
function getTotalRevenue($conn) {
    $sql    = "SELECT SUM(amount) AS total FROM billing WHERE payment_status = 'paid'";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function getDoctorReviews($conn) {
    $sql = "SELECT dr.id,
                   dr.appointment_id,
                   dr.patient_id,
                   dr.doctor_id,
                   dr.rating,
                   dr.review_text,
                   dr.created_at,
                   du.name AS doctor_name,
                   u.name  AS patient_name
            FROM doctor_reviews dr
            JOIN doctors d  ON dr.doctor_id  = d.id
            JOIN users du   ON d.user_id     = du.id
            JOIN patients p ON dr.patient_id = p.id
            JOIN users u    ON p.user_id     = u.id
            ORDER BY dr.created_at DESC";

    $result  = mysqli_query($conn, $sql);
    $reviews = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
    return $reviews;
}