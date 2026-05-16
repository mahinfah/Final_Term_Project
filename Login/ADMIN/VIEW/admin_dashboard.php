<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>

  <style>
    body {
      font-family: Arial;
      background: #f2f4f8;
      margin: 0;
    }

    h1 {
      text-align: center;
      background: #1e293b;
      color: white;
      padding: 15px;
      margin: 0;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      padding: 15px;
      gap: 15px;
      justify-content: center;
    }

    .card {
      background: white;
      width: 250px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .card h2 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    button {
      display: block;
      width: 100%;
      margin: 5px 0;
      padding: 8px;
      border: none;
      background: #2563eb;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background: #1d4ed8;
    }

    .stats {
      text-align: center;
      font-size: 18px;
    }

  </style>
</head>

<body>

<h1>Hospital Admin Dashboard</h1>

<!-- Dashboard Stats -->
<div class="container">

  <div class="card stats">
    <h2>Today's Appointments</h2>
    <p>120</p>
  </div>

  <div class="card stats">
    <h2>Total Patients</h2>
    <p>4500</p>
  </div>

  <div class="card stats">
    <h2>Active Doctors</h2>
    <p>85</p>
  </div>

  <div class="card stats">
    <h2>Pending Bills</h2>
    <p>32</p>
  </div>

</div>

<!-- Features Section -->
<div class="container">

  <div class="card">
    <h2>Doctors</h2>
    <button>Add Doctor</button>
    <button>Approve Doctor</button>
    <button>Edit Doctor</button>
    <button>Deactivate</button>
  </div>

  <div class="card">
    <h2>Specializations</h2>
    <button>Add</button>
    <button>Rename</button>
    <button>Delete</button>
  </div>

  <div class="card">
    <h2>Receptionists</h2>
    <button>Create</button>
    <button>Edit</button>
    <button>Deactivate</button>
  </div>

  <div class="card">
    <h2>Patients</h2>
    <button>Search</button>
    <button>View</button>
    <button>Deactivate</button>
  </div>

  <div class="card">
    <h2>Appointments</h2>
    <button>View All</button>
    <button>Filter</button>
  </div>

  <div class="card">
    <h2>Reports</h2>
    <button>Revenue</button>
    <button>Appointments</button>
    <button>Performance</button>
  </div>

  <div class="card">
    <h2>Billing</h2>
    <button>Paid</button>
    <button>Pending</button>
    <button>Overdue</button>
  </div>

  <div class="card">
    <h2>Complaints</h2>
    <button>View</button>
    <button>Resolve</button>
  </div>

  <div class="card">
    <h2>Announcements</h2>
    <button>Post</button>
  </div>

</div>

</body>
</html>