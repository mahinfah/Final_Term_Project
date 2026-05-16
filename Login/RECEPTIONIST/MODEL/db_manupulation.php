<?php

function insert_on_DB($name, $email, $password, $phone, $role,$profile_pic, $is_active, $conn) {

    $sql = "INSERT INTO users (name, email, password_hash, phone, role, profile_pic, is_active) VALUES ('$name', '$email', '$password', '$phone', '$role', '$profile_pic', '$is_active')";
    return mysqli_query($conn, $sql);
}
