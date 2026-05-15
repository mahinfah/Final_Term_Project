<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.container {
    width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;

}

h2 {
    text-align: center;
}

label {
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #903e9fe8;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #31ba85de;
}
</style>
    <h2>User Registration Form</h2>

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

</body>
</html>