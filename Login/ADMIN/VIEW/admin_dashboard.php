
<?php


require_once '../CONTROLLER/total_app.php';


?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>


<style>
    .appointment-list {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(16, 125, 125, 0.89);
    }
    .container
    {
        margin-top: 20px;
        background-color: #b6eafa;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(16, 125, 125, 0.89);
    }
    .stats {
        display: flex;
        margin-top: 10px;
    }
    h2{
        color: #12c1e9d8;
    }

    .stat-box {
        background-color: #fff;
        border-radius: 8px;
        padding: 10px 530px;
        box-shadow: 0 2px 8px rgba(1, 167, 167, 0.89);
        text-align: center;
        border-top: 22px solid #3498db;
    }

    .stat-box p {
        font-size: 22px;
        color: #201d1d;
    }
    .B{
        padding: 10px 580px;
        background-color: #2a99f4;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .stat-box span {
        font-size: 36px;
        font-weight: bold;
        color: #2c3e50;
    }
</style>
<body>

    <h1>Hospital Admin Dashboard</h1>


<div class="stats">
        <div class="stat-box">

           <p>Total Appointments :</p>
            <span><?php echo $totalAppointments; ?></span>
        
        </div>
    </div>


    <!-- Appointment List FIRST -->
     <div class="appointment-list">
    <h2 >Appointment List</h2>
  <span id="table">
			
		</span>
   
    </div>

    <div>   
<div type="container" class="container">
    <a href="add_doctor.php">
    <button class="B">Add Doctor</button>
</a>

</div>


    </div>

    
    <!-- JS file -->
    <script src="./script/formvalidation.js"></script>
</body>

</html>