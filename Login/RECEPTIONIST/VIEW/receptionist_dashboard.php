

<?php
session_start(); 
require_once '../CONTROLLER/dashboardLoad.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Receptionist Dashboard</title>

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

  <h2>Search Patient</h2>
 
<a href="search_patient.php">
    <button>Search Patients</button>
</a>
<a href="book_appointment.php">
    <button>Book Appointment</button>
</a>
    

  <div class="box">
    <h2>Register New Patient</h2>

    <input type="text" placeholder="Full Name"><br>
    <input type="text" placeholder="Phone"><br>
    <input type="text" placeholder="Patient ID"><br>
    <button>Register</button>
  </div>

  <!-- Book Appointment -->
  <div class="box">
    <h2>Book Appointment</h2>

    <input type="text" placeholder="Patient Name">

    <select>
      <option>Select Doctor</option>
      <option>Dr. Smith</option>
      <option>Dr. Khan</option>
    </select>

    <input type="time">

    <button>Book</button>
  </div>

  <!-- Check In -->
  <div class="box">
    <h2>Patient Check In</h2>

    <input type="text" placeholder="Appointment ID">
    <button>Check In</button>
  </div>

  <!-- Waiting Queue -->
  <div class="box">
    <h2>Waiting Queue</h2>

    <ul>
      <li>John - Dr. Smith</li>
      <li>Sara - Dr. Khan</li>
    </ul>
  </div>

  <!-- Payment -->
  <div class="box">
    <h2>Process Payment</h2>

    <input type="text" placeholder="Appointment ID">
    <input type="text" placeholder="Amount">

    <select>
      <option>Cash</option>
      <option>Card</option>
    </select>

    <button>Paid</button>
  </div>

  <!-- Receipt -->
  <div class="box">
    <h2>Payment Receipt</h2>

    <p>Patient: John</p>
    <p>Amount: $100</p>
    <p>Method: Cash</p>

    <button onclick="window.print()">Print Receipt</button>
  </div>

  <!-- Doctor Availability -->
  <div class="box">
    <h2>Doctor Availability</h2>

    <table>
      <tr>
        <th>Doctor</th>
        <th>Available Time</th>
      </tr>

      <tr>
        <td>Dr. Smith</td>
        <td>2:00 PM</td>
      </tr>

      <tr>
        <td>Dr. Khan</td>
        <td>3:00 PM</td>
      </tr>
    </table>
  </div>

  <!-- Report -->
  <div class="box">
    <h2>Daily Summary Report</h2>

    <p>Total Appointments: 20</p>
    <p>Checked In: 12</p>
    <p>Completed: 8</p>
    <p>Revenue: $1200</p>
  </div>
    <script src="./script/valid.js"></script>
</body>
</html>