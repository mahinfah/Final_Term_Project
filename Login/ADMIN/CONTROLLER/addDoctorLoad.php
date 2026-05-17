<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$message         = '';
$conn            = conn_open();
$specializations = getSpecializations($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name              = $_POST['name'];
    $email             = $_POST['email'];
    $password          = $_POST['password'];
    $phone             = $_POST['phone'];
    $specialization_id = $_POST['specialization_id'];
    $bio               = $_POST['bio'];
    $consultation_fee  = $_POST['consultation_fee'];
    $license_number    = $_POST['license_number'];
    $experience_years  = $_POST['experience_years'];
    $photo_path        = ''; 
    
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($license_number)) {
        $message = "error:Name, email, password, phone and license number are required";

    } else {

    
        $userResult = registerDoctorUser($conn, $name, $email, $password, $phone);

        if ($userResult) {

            // ✅ Step 2 - Get new user id
            $user_id = mysqli_insert_id($conn);

            // ✅ Step 3 - Insert into doctors table
            $doctorResult = registerDoctor(
                $conn, $user_id, $specialization_id, $bio,
                $consultation_fee, $photo_path, $license_number, $experience_years
            );

            if ($doctorResult) {
                $message = "success:Doctor added successfully";
            } else {
                $message = "error:Failed to save doctor profile";
            }

        } else {
            $message = "error:Email already exists please use different email";
        }
    }

    conn_close($conn);
}