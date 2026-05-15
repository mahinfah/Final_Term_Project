<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>You are logged out.</h2>
        <a href="index.php"><button>Login Again</button></a>
    </div>
</body>
</html>