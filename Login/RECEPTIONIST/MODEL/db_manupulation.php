<?php

function insert_on_DB($name, $email, $password, $phone, $role,$profile_pic, $is_active, $conn) {

    $sql = "INSERT INTO users (name, email, password_hash, phone, role, profile_pic, is_active) VALUES ('$name', '$email', '$password', '$phone', '$role', '$profile_pic', '$is_active')";
    return mysqli_query($conn, $sql);
}

function getReceptionistProfile($conn, $email) {
    $sql = "SELECT name, email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
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