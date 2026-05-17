<!DOCTYPE html>
<html>
<head>
    <title>Manage Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Doctor Profile</h2>
    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Bio:</label>
        <textarea name="bio"><?= htmlspecialchars($doctor['bio'] ?? '') ?></textarea>
        <label>Specialization:</label>
        <select name="specialization_id">
            <?php foreach($specializations as $spec): ?>
                <option value="<?= $spec['id'] ?>" <?= ($spec['id'] == ($doctor['specialization_id'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($spec['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Consultation Fee:</label>
        <input type="number" step="0.01" name="consultation_fee" value="<?= $doctor['consultation_fee'] ?? 500 ?>">
        <label>Years of Experience:</label>
        <input type="number" name="experience_years" value="<?= $doctor['experience_years'] ?? 0 ?>">
        <label>License Number:</label>
        <input type="text" name="license_number" value="<?= htmlspecialchars($doctor['license_number'] ?? '') ?>">
        <label>Profile Photo:</label>
        <input type="file" name="photo">
        <?php if($doctor['photo_path']): ?>
            <img src="<?= $doctor['photo_path'] ?>" width="100">
        <?php endif; ?>
        <button type="submit">Update Profile</button>
    </form>
    <a href="index.php?action=dashboard">Back</a>
</div>
</body>
</html>