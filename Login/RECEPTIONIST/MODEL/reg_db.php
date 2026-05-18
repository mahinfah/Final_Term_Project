<?php
function insert_user_on_DB($name, $email, $password_hash, $phone, $role, $profile_pic, $is_active, $conn) {

    $sql = "INSERT INTO users 
            (name, email, password_hash, phone, role, profile_pic, is_active, created_at) 
            VALUES 
            ('$name', '$email', '$password_hash', '$phone', '$role', '$profile_pic', '$is_active', NOW())";

    return mysqli_query($conn, $sql);
}


?>