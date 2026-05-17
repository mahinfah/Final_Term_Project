<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Get form data
    $name            = $_POST['name'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];
    $phone           = $_POST['phone'];
    $dob             = $_POST['dob'];
    $blood_group     = $_POST['blood_group'];
    $gender          = $_POST['gender'];
    $address         = $_POST['address'];
    $emergency_name  = $_POST['emergency_name'];
    $emergency_phone = $_POST['emergency_phone'];
    $medical_history = $_POST['medical_history'];

    // ✅ Check empty fields
    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $message = "error:Name, email, password and phone are required";

    } else {

        // ✅ Open connection here
        $conn = conn_open();

        // ✅ Step 1 - Insert into users table
        $userResult = registerUser($conn, $name, $email, $password, $phone);

        if ($userResult) {

            // ✅ Step 2 - Get the new user id
            $user_id = mysqli_insert_id($conn);

            // ✅ Step 3 - Insert into patients table
            $patientResult = registerPatient(
                $conn, $user_id, $dob, $blood_group, $gender,
                $address, $emergency_name, $emergency_phone, $medical_history
            );

            if ($patientResult) {
                $message = "success:Patient registered successfully";
            } else {
                $message = "error:Failed to save patient details";
            }

        } else {
            $message = "error:Email already exists please use different email";
        }

        // ✅ Close connection here
        conn_close($conn);
    }
}