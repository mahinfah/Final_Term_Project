<?php
require_once '../MODEL/db_manupulation.php';
require_once '../MODEL/db_connection.php';
require_once '../MODEL/db_close.php';

$message         = '';
$conn            = conn_open();
$specializations = getAllSpecializations($conn);
$editData        = null;


if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $name        = $_POST['name'];
    $description = $_POST['description'];

    if (empty($name)) {
        $message = "error:Name is required";
    } else {
        $result = addSpecialization($conn, $name, $description);
        if ($result) {
            $message         = "success:Specialization added successfully";
            $specializations = getAllSpecializations($conn);
        } else {
            $message = "error:Something went wrong";
        }
    }
}

if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $editData = getSpecializationById($conn, $_GET['edit_id']);
}

if (isset($_POST['action']) && $_POST['action'] === 'rename') {
    $id          = $_POST['id'];
    $name        = $_POST['name'];
    $description = $_POST['description'];

    if (empty($name)) {
        $message = "error:Name is required";
    } else {
        $result = renameSpecialization($conn, $id, $name, $description);
        if ($result) {
            $message         = "success:Specialization updated successfully";
            $specializations = getAllSpecializations($conn);
            $editData        = null;
        } else {
            $message = "error:Something went wrong";
        }
    }
}


if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $result = deleteSpecialization($conn, $_GET['delete_id']);
    if ($result) {
        $message         = "success:Specialization deleted successfully";
        $specializations = getAllSpecializations($conn);
    } else {
        $message = "error:Cannot delete — doctors may be using this specialization";
    }
}

conn_close($conn);