<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../CONTROLLER/specializationLoad.php';

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
    <title>Manage Specializations</title>
</head>
<body>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>Manage Specializations</h1>
    <hr>

    <!-- Message -->
    <?php if (!empty($msgText)): ?>
        <p style="color: <?php echo $msgType === 'success' ? 'green' : 'red'; ?>">
            <?php echo $msgText; ?>
        </p>
    <?php endif; ?>

    <!-- Add Form -->
    <h2>Add New Specialization</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">

        <p>
            <label>Name:</label><br>
            <input type="text" name="name" placeholder="Enter specialization name">
        </p>

        <p>
            <label>Description:</label><br>
            <textarea name="description" rows="3" cols="30" placeholder="Enter description"></textarea>
        </p>

        <p>
            <button type="submit">Add Specialization</button>
        </p>
    </form>

    <hr>

    <!-- Edit Form -->
    <?php if ($editData): ?>
        <h2>Edit Specialization</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="rename">
            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">

            <p>
                <label>Name:</label><br>
                <input type="text" name="name" value="<?php echo $editData['name']; ?>">
            </p>

            <p>
                <label>Description:</label><br>
                <textarea name="description" rows="3" cols="30"><?php echo $editData['description']; ?></textarea>
            </p>

            <p>
                <button type="submit">Update Specialization</button>
                &nbsp;
                <a href="manage_specialization.php">Cancel</a>
            </p>
        </form>
        <hr>
    <?php endif; ?>

    <!-- Specializations Table -->
    <h2>All Specializations</h2>

    <?php if (empty($specializations)): ?>
        <p>No specializations found.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php foreach ($specializations as $spec): ?>
                <tr>
                    <td><?php echo $spec['id']; ?></td>
                    <td><?php echo $spec['name']; ?></td>
                    <td><?php echo $spec['description']; ?></td>
                    <td>
                        <a href="?edit_id=<?php echo $spec['id']; ?>">Edit</a>
                        &nbsp;
                        <a href="?delete_id=<?php echo $spec['id']; ?>"
                           onclick="return confirm('Delete this specialization?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>