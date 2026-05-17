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

// ✅ Get all specializations for dropdown
function getSpecializations($conn) {
    $sql = "SELECT id, name FROM specializations";
    $result = mysqli_query($conn, $sql);
    $specializations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $specializations[] = $row;
    }
    return $specializations;
}

// ✅ Register doctor user account
function registerDoctorUser($conn, $name, $email, $password, $phone) {

    // ✅ Check if email already exists
    $check  = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    // ✅ Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password_hash, phone, role, is_active)
            VALUES ('$name', '$email', '$hashed', '$phone', 'doctor', 1)";
    return mysqli_query($conn, $sql);
}

// ✅ Register doctor profile
function registerDoctor($conn, $user_id, $specialization_id, $bio, $consultation_fee, $photo_path, $license_number, $experience_years) {
    $sql = "INSERT INTO doctors 
                (user_id, specialization_id, bio, consultation_fee, photo_path, license_number, experience_years, is_approved)
            VALUES 
                ('$user_id', '$specialization_id', '$bio', '$consultation_fee', '$photo_path', '$license_number', '$experience_years', 0)";
    return mysqli_query($conn, $sql);
}