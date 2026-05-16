<?php
// ✅ Require the controller to get the variable
require_once '../CONTROLLER/total_app.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>


<style>
    .stats {
        display: flex;
        margin-top: 10px;
    }

    .stat-box {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px 30px;
        box-shadow: 0 2px 8px rgba(229, 62, 62, 0.84);
        text-align: center;
        border-top: 4px solid #3498db;
    }

    .stat-box p {
        font-size: 13px;
        color: #777;
    }

    .stat-box span {
        font-size: 36px;
        font-weight: bold;
        color: #2c3e50;
    }
</style>
<body>

    <h1>Hospital Admin Dashboard</h1>

    <!-- Appointment List FIRST -->
    <h2>Appointment List</h2>
  <span id="table">
			
		</span>
   
    

    <!-- Dashboard -->
    <h2>Dashboard</h2>

  <div class="stats">
        <div class="stat-box">

           <p>Total Appointments :</p>
            <span><?php echo $totalAppointments; ?></span>
        
        </div>
    </div>

    <p>Total Patients: 4500</p>
    <p>Active Doctors: 85</p>
    <p>Pending Bills: 32</p>

    <hr>

    <h2>Manage Doctors</h2>
    <button>Add Doctor</button>
    <button>Approve Doctor</button>
    <button>Edit Doctor</button>

    <hr>

    <h2>Patients</h2>
    <button>View Patients</button>
    <button>Search Patients</button>

    <hr>

    <h2>Appointments</h2>
    <button>View Appointments</button>

    <hr>

    <h2>Reports</h2>
    <button>Revenue Report</button>
    <button>Performance Report</button>

    <hr>

    <h2>Billing</h2>
    <button>Pending Bills</button>

    <hr>

    <h2>Complaints</h2>
    <button>View Complaints</button>

    <hr>

    <h2>Announcement</h2>
    <textarea rows="4" cols="30"></textarea>
    <br><br>
    <button>Post</button>

    <!-- JS file -->
    <script src="./script/formvalidation.js"></script>
</body>

</html>