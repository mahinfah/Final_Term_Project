<?php
session_start();



if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}


require_once '../CONTROLLER/receptionistLoad.php';

$msgType = '';
$msgText = '';
if (!empty($message)) {
    $parts   = explode(':', $message, 2);
    $msgType = $parts[0];
    $msgText = $parts[1];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Receptionists</title>
</head>
<body>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>Manage Receptionists</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($msgText)): ?>
        <p style="color: <?php echo $msgType === 'success' ? 'green' : 'red'; ?>">
            <?php echo $msgText; ?>
        </p>
    <?php endif; ?>

    <!-- Create Form -->
    <h2>Create New Receptionist</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="create">

        <p>
            <label>Full Name:</label><br>
            <input type="text" name="name" placeholder="Enter full name">
        </p>

        <p>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="Enter email">
        </p>

        <p>
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="Enter password">
        </p>

        <p>
            <label>Phone:</label><br>
            <input type="text" name="phone" placeholder="Enter phone number">
        </p>

        <p>
            <button type="submit">Create Receptionist</button>
        </p>
    </form>

    <hr>

    <!-- Edit Form -->
    <?php if ($editData): ?>
        <h2>Edit Receptionist</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">

            <p>
                <label>Full Name:</label><br>
                <input type="text" name="name" value="<?php echo $editData['name']; ?>">
            </p>

            <p>
                <label>Email:</label><br>
                <input type="email" name="email" value="<?php echo $editData['email']; ?>">
            </p>

            <p>
                <label>Phone:</label><br>
                <input type="text" name="phone" value="<?php echo $editData['phone']; ?>">
            </p>

            <p>
                <button type="submit">Update Receptionist</button>
                <a href="manage_receptionist.php">Cancel</a>
            </p>
        </form>
        <hr>
    <?php endif; ?>

    <!-- Receptionists Table -->
    <h2>All Receptionists</h2>

    <?php if (empty($receptionists)): ?>
        <p>No receptionists found.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($receptionists as $r): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo $r['name']; ?></td>
                    <td><?php echo $r['email']; ?></td>
                    <td><?php echo $r['phone']; ?></td>
                    <td>
                        <?php if ($r['is_active'] == 1): ?>
                            <span style="color: green;">Active</span>
                        <?php else: ?>
                            <span style="color: red;">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Edit -->
                        <a href="?edit_id=<?php echo $r['id']; ?>">Edit</a>
                        &nbsp;

                        <!-- Activate / Deactivate -->
                        <?php if ($r['is_active'] == 1): ?>
                            <a href="?deactivate_id=<?php echo $r['id']; ?>"
                               onclick="return confirm('Deactivate this receptionist?')">
                               Deactivate
                            </a>
                        <?php else: ?>
                            <a href="?activate_id=<?php echo $r['id']; ?>"
                               onclick="return confirm('Activate this receptionist?')">
                               Activate
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>