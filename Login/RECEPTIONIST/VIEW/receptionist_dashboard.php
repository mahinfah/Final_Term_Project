

<?php
session_start(); 
require_once '../CONTROLLER/dashboardLoad.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Receptionist Dashboard</title>

<div style="text-align: right; padding: 10px;">
    <a href="logout.php">
        <button>Logout</button>
    </a>
</div>

  <style>
    body{
      font-family: Arial;
      background:#f2f2f2;
      margin:20px;
    }

    .box{
      background:white;
      padding:15px;
      margin-bottom:20px;
      border-radius:5px;
    }

    h2{
      color:pink;
    }

    table{
      width:100%;
      border-collapse:collapse;
    }

    table, th, td{
      border:1px solid gray;
    }

    th, td{
      padding:10px;
      text-align:left;
    }

    input, select{
      padding:8px;
      margin:5px;
      width:200px;
    }

    button{
      padding:8px 15px;
      background:green;
      color:white;
      border:none;
      cursor:pointer;
    }

    .status{
      color:green;
      font-weight:bold;
    }
  </style>
</head>

<body>

  <h1>Hospital Receptionist Dashboard</h1>

  <!-- Login/Profile -->
 <div class="box">
    <h2>Receptionist Profile</h2>
  
    <p>Name: <?php echo $profile['name']; ?></p>
    <p>Email: <?php echo $profile['email']; ?></p>
</div>


 <h2>Appointment List</h2>
  <span id="table">
			
		</span> 
    <style>
    .wrapper {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .container {
        border: 1px solid #fafafa;
        padding: 60px;
        background-color: #a07a6f;
        width: 200px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 2px 2px 5px #f5e9e9;
    }
    h2 {
        color: #110c0c;
        margin-bottom: 20px;
    }
</style>

<div class="wrapper">

    <div class="container">
        <h2>Book Appointment</h2>
        <a href="book_appointment.php">
            <button>Book Appointment</button>
        </a>
    </div>

    <div class="container">
        <h2>Search Patients</h2>
        <a href="search_patient.php">
            <button>Search Patients</button>
        </a>
    </div>

    <div class="container">
        <h2>Make Payment</h2>
        <a href="process_payment.php">
            <button>Process Payment</button>
        </a>
    </div>
    <div class="container">
    <h2>Register Patient</h2>
    <a href="register_patient.php">
        <button>Register Patient</button>
    </a>
</div>

</div>
    
    <script src="./script/valid.js"></script>
</body>
</html>