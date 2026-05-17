<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$message      = '';
$conn         = conn_open();
$receptionists = getAllReceptionists($conn);
$editData     = null;

// ✅ Handle create
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $phone    = $_POST['phone'];

    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $message = "error:All fields are required";
    } else {
        $result = createReceptionist($conn, $name, $email, $password, $phone);
        if ($result) {
            $message       = "success:Receptionist created successfully";
            $receptionists = getAllReceptionists($conn);
        } else {
            $message = "error:Email already exists";
        }
    }
}

// ✅ Handle edit form load
if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $editData = getReceptionistById($conn, $_GET['edit_id']);
}

// ✅ Handle edit submit
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (empty($name) || empty($email) || empty($phone)) {
        $message = "error:All fields are required";
    } else {
        $result = editReceptionist($conn, $id, $name, $email, $phone);
        if ($result) {
            $message       = "success:Receptionist updated successfully";
            $receptionists = getAllReceptionists($conn);
            $editData      = null;
        } else {
            $message = "error:Something went wrong";
        }
    }
}

// ✅ Handle deactivate
if (isset($_GET['deactivate_id']) && !empty($_GET['deactivate_id'])) {
    $result = deactivateReceptionist($conn, $_GET['deactivate_id']);
    if ($result) {
        $message       = "success:Receptionist deactivated";
        $receptionists = getAllReceptionists($conn);
    }
}

// ✅ Handle activate
if (isset($_GET['activate_id']) && !empty($_GET['activate_id'])) {
    $result = activateReceptionist($conn, $_GET['activate_id']);
    if ($result) {
        $message       = "success:Receptionist activated";
        $receptionists = getAllReceptionists($conn);
    }
}

conn_close($conn);