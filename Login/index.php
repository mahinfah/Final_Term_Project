<?php
session_start();

require_once 'RECEPTIONIST/MODEL/db_connection.php';
require_once 'RECEPTIONIST/MODEL/db_manupulation.php';
require_once 'RECEPTIONIST/MODEL/db_close.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}

$action = $_POST['action'] ?? '';

if ($action === "login") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = strtolower(trim($_POST['role'] ?? ''));

    if (empty($email) || empty($password) || empty($role)) {
        $_SESSION['msg'] = "Email, password, and role required";
        header("Location: index.php");
        exit;
    }

    $conn = conn_open();

    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ? AND is_active = 1");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password_hash'];
            $passwordMatches = password_verify($password, $storedPassword) || hash_equals($storedPassword, $password);

            if ($passwordMatches) {
                $_SESSION['msg'] = "Login Successful";
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['username'] = $row['name'];
                $_SESSION['role'] = strtolower(trim($row['role']));

                switch ($_SESSION['role']) {
                    case 'doctor':
                        header("Location: Doctor/controllers/DoctorController.php");
                        exit;
                    case 'patient':
                        header("Location: patient/controllers/PatientController.php");
                        exit;
                    case 'receptionist':
                        header("Location: RECEPTIONIST/VIEW/receptionist_dashboard.php");
                        exit;
                    default:
                        $_SESSION['msg'] = "Dashboard is not available for this role";
                        break;
                }
            } else {
                $_SESSION['msg'] = "Invalid login details";
            }
        } else {
            $_SESSION['msg'] = "Invalid login details";
        }

        conn_close($conn);
    } else {
        $_SESSION['msg'] = "Database connection failed";
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            width: 320px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #2980b9;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Hospital Login</h2>

    <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])): ?>
        <div class="<?php echo $_SESSION['msg'] === 'Login Successful' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($_SESSION['msg']); ?>
        </div>
        <?php $_SESSION['msg'] = ''; ?>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="action" value="login">

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
            <option value="receptionist">Receptionist</option>
        </select>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p style="text-align:center; margin:15px 0 0;">
        <a href="RECEPTIONIST/VIEW/registration_rep.php">Register Receptionist</a>
    </p>
</div>

</body>
</html>
