<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../../index.php");
    exit;
}

require_once '../CONTROLLER/searchPatientLoad.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #2c3e50;
            border-left: 5px solid #3498db;
            padding-left: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .back-btn:hover { background: #2980b9; }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-bar button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .search-bar button:hover { background: #2980b9; }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 10px 15px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            color: #555;
        }

        tr:hover { background: #f0f8ff; }

        .view-btn {
            padding: 5px 12px;
            background: #27ae60;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
        }

        .view-btn:hover { background: #219150; }

        .profile-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .profile-info div {
            flex: 1;
            min-width: 150px;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .profile-info strong {
            color: #2c3e50;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-pending     { background: #fff3cd; color: #856404; }
        .badge-checked_in  { background: #d1ecf1; color: #0c5460; }
        .badge-completed   { background: #d4edda; color: #155724; }
        .badge-cancelled   { background: #f8d7da; color: #721c24; }
        .badge-paid        { background: #d4edda; color: #155724; }
        .badge-unpaid      { background: #f8d7da; color: #721c24; }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>
<body>

    <a href="receptionist_dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h1>Search Patients</h1>

    <!-- Search Bar -->
    <form method="GET" action="">
        <div class="search-bar">
            <input type="text"
                   name="search"
                   placeholder="Search by name, phone or patient ID..."
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </div>
    </form>

    <!-- Search Results -->
    <?php if (!empty($patients)): ?>
        <div class="card">
            <h2>Search Results</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo $patient['id']; ?></td>
                        <td><?php echo htmlspecialchars($patient['name']); ?></td>
                        <td><?php echo htmlspecialchars($patient['email']); ?></td>
                        <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                        <td>
                            <a href="?search=<?php echo urlencode($search); ?>&patient_id=<?php echo $patient['id']; ?>"
                               class="view-btn">View Profile</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    <?php elseif (!empty($search)): ?>
        <div class="card">
            <p class="no-data">No patients found for "<?php echo htmlspecialchars($search); ?>"</p>
        </div>

    <?php endif; ?>

    <!-- Patient Profile -->
    <?php if ($selectedPatient): ?>

        <div class="card">
            <h2>Patient Profile</h2>
            <div class="profile-info">

                <!-- ✅ Column 1 - Basic info from users table -->
                <div>
                    <p><strong>Patient ID:</strong> <?php echo $selectedPatient['id']; ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($selectedPatient['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($selectedPatient['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($selectedPatient['phone']); ?></p>
                </div>

                <!-- ✅ Column 2 - Info from patients table -->
                <div>
                    <p><strong>Date of Birth:</strong> <?php echo $selectedPatient['date_of_birth'] ?? 'N/A'; ?></p>
                    <p><strong>Blood Group:</strong> <?php echo $selectedPatient['blood_group'] ?? 'N/A'; ?></p>
                    <p><strong>Gender:</strong> <?php echo $selectedPatient['gender'] ?? 'N/A'; ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($selectedPatient['address'] ?? 'N/A'); ?></p>
                </div>

                <!-- ✅ Column 3 - Emergency info from patients table -->
                <div>
                    <p><strong>Emergency Contact:</strong> <?php echo htmlspecialchars($selectedPatient['emergency_contact_name'] ?? 'N/A'); ?></p>
                    <p><strong>Emergency Phone:</strong> <?php echo htmlspecialchars($selectedPatient['emergency_contact_phone'] ?? 'N/A'); ?></p>
                    <p><strong>Medical History:</strong> <?php echo htmlspecialchars($selectedPatient['medical_history_notes'] ?? 'N/A'); ?></p>
                </div>

            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="card">
            <h3>Upcoming Appointments</h3>
            <?php if (empty($upcomingAppts)): ?>
                <p class="no-data">No upcoming appointments.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($upcomingAppts as $appt): ?>
                        <tr>
                            <td><?php echo $appt['appointment_date']; ?></td>
                            <td><?php echo date('h:i A', strtotime($appt['appointment_time'])); ?></td>
                            <td>Dr. <?php echo htmlspecialchars($appt['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($appt['reason']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $appt['status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $appt['status'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <!-- Billing Status -->
        <div class="card">
            <h3>Billing Status</h3>
            <?php if (empty($bills)): ?>
                <p class="no-data">No billing records found.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Bill ID</th>
                        <th>Appointment ID</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                    <?php foreach ($bills as $bill): ?>
                        <tr>
                            <td><?php echo $bill['id']; ?></td>
                            <td><?php echo $bill['appointment_id']; ?></td>
                            <td>$<?php echo number_format($bill['amount'], 2); ?></td>
                            <td><?php echo $bill['payment_method'] ?? 'N/A'; ?></td>
                            <td>
                                <span class="badge badge-<?php echo $bill['payment_status']; ?>">
                                    <?php echo ucfirst($bill['payment_status']); ?>
                                </span>
                            </td>
                            <td><?php echo $bill['paid_at'] ?? 'Not Paid Yet'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</body>
</html>