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
    background: #fff;
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
}


input, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.95rem;
}

input[type="submit"] {
    background-color: #903e9fe8;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 15px;
    padding: 10px 0;
}

input[type="submit"]:hover {
    background-color: #31ba85de;
}
</style>
    <div class="container">
        <h2>Receptionist Registration Form</h2>

        <form action="register.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="receptionist">Receptionist</option>
        </select><br><br>

        <label>Profile Picture:</label><br>
        <input type="file" name="profile_pic"><br><br>

        <label>Active Status:</label><br>
        <select name="is_active">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select><br><br>

        <input type="submit" name="register" value="Register">

    </form>
    </div>

</body>
</html>