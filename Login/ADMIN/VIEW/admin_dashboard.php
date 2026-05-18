<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/total_app.php';
require_once '../CONTROLLER/dashboardLoad.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>

<style>
    .stats {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .stat-box {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px 40px;
        box-shadow: 0 2px 8px rgba(1, 167, 167, 0.89);
        text-align: center;
        border-top: 8px solid #3498db;
    }

    .stat-box p {
        font-size: 15px;
        color: #201d1d;
    }

    .stat-box span {
        font-size: 36px;
        font-weight: bold;
        color: #2c3e50;
    }

    .appointment-list {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(16, 125, 125, 0.89);
    }

    h2 {
        color: #12c1e9d8;
    }

    .container {
        margin-top: 20px;
        background-color: #b6eafa;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(16, 125, 125, 0.89);
    }

    .B {
        padding: 10px 40px;
        background-color: #2a99f4;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .wrapper {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 20px;
    }
</style>

<body>

    <!-- Logout -->
    <div style="text-align: right; padding: 10px;">
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <h1>Hospital Admin Dashboard</h1>

    <!-- ✅ All 4 Stats side by side -->
    <div class="stats">

        <div class="stat-box">
            <p>Total Appointments</p>
            <span><?php echo $totalAppointments; ?></span>
        </div>

        <div class="stat-box">
            <p>Total Patients</p>
            <span><?php echo $totalPatients; ?></span>
        </div>

        <div class="stat-box">
            <p>Active Doctors</p>
            <span><?php echo $totalActiveDoctors; ?></span>
        </div>

        <div class="stat-box">
            <p>Pending Billing</p>
            <span><?php echo $totalPendingBilling; ?></span>
        </div>

    </div>

    <!-- Appointment List -->
    <div class="appointment-list">
        <h2>Appointment List</h2>
        <span id="table"></span>
    </div>

    <!-- Buttons -->
    <div class="wrapper">

        <div class="container">
            <a href="add_doctor.php">
                <button class="B">Add Doctor</button>
            </a>
        </div>

        <div class="container">
            <a href="manage_receptionist.php">
                <button class="B">Manage Receptionists</button>
            </a>
        </div>

        <div class="container">
            <a href="manage_specialization.php">
                <button class="B">Manage Specializations</button>
            </a>
        </div>

        <div class="container">
            <a href="total_revenue.php">
                <button class="B">Total Revenue</button>
            </a>
        </div>

    </div>

    <!-- JS file -->
    <script src="./script/formvalidation.js"></script>

</body>
</html>