<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title> Receptionist Registration </title>
</head>
<body>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.container {
    width: 340px;
    max-width: 90%;
    margin: 20px auto;
    background: #fdc3d3df;
    padding: 18px;
    border-radius: 10px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

h2 {
    text-align: center;
    color: #b949cde8;
    background-color: #d8ebe3de;
    padding: 10px;
    font-size: 1.2rem;
    margin: 0 0 16px;
}

label {
    font-weight: bold;
    font-size: 0.95rem;
    margin-left: 10px;
    
}



button {
    background-color: #6dd9fa;
    color: #ffffff;
    border: none;
    padding: 10px 16px;
    border-radius: 5px;
    cursor: pointer;
}

#login {
    background-color: #4CAF50;
    margin-left: 10px;
}

button:hover {
    background-color: #45a049;
}

</style>
    <div class="container">
        <h2>Receptionist Registration Form</h2>
        

<?php


if (isset($_SESSION['msg'])) {
    echo "<p>" . $_SESSION['msg'] . "</p>";
    unset($_SESSION['msg']);
}
?>
        <form action="../CONTROLLER/regform_validation.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" ><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" ><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" ><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="receptionist">Receptionist</option>
        </select><br><br>

        <label>Profile Picture:</label><br>
        <input type="file" name="profile_pic" accept="image/*"><br><br>

        <label>Active Status:</label><br>
        <select name="is_active">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select><br><br>

       	<button type="submit" name="action" id="insert" value="insert">Register</button>
        <button type="submit" name="action" value="login">Login</button>

	<span id="msg"></span>

  
    </form>

    </div>

</body>
</html>