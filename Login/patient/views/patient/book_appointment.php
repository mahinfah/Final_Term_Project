<?php
$doctor_id = $_GET['doctor_id'];
$doctor = $doctorModel->getById($doctor_id);
if(!$doctor) { echo "<p>Invalid doctor</p>"; exit; }
$dependents = $dependentModel->getByPatient($patient_data['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book'])) {
    $dep = $_POST['dependent_id'] ?? null;
    if($dep === '') $dep = null;
    if($appointmentModel->book($patient_data['id'], $doctor_id, $_POST['date'], $_POST['time'], $_POST['reason'], $dep)) {
        echo "<p class='success'>Appointment booked successfully!</p>";
    } else {
        echo "<p class='error'>Booking failed.</p>";
    }
}
?>
<h2>Book appointment with Dr. <?php echo htmlspecialchars($doctor['name']); ?></h2>
<form method="post" id="bookingForm">
    <label>Book for:</label>
    <select name="dependent_id">
        <option value="">Myself</option>
        <?php foreach($dependents as $dep): ?>
            <option value="<?php echo $dep['id']; ?>"><?php echo htmlspecialchars($dep['name']); ?> (<?php echo $dep['relationship']; ?>)</option>
        <?php endforeach; ?>
    </select><br>
    <label>Date:</label>
    <input type="date" name="date" id="appointmentDate" min="<?php echo date('Y-m-d'); ?>" required><br>
    <label>Time:</label>
    <select name="time" id="timeSlot" required><option value="">Select date first</option></select><br>
    <label>Reason:</label>
    <textarea name="reason" required></textarea><br>
    <button type="submit" name="book">Confirm Booking</button>
</form>
<script>
document.getElementById('appointmentDate').addEventListener('change', function(){
    let date = this.value, docId = <?php echo $doctor_id; ?>;
    fetch(`../controllers/AjaxController.php?action=get_available_slots&doctor_id=${docId}&date=${date}`)
        .then(res=>res.json()).then(data=>{
            let timeSelect = document.getElementById('timeSlot');
            timeSelect.innerHTML = '<option value="">Select a time slot</option>';
            if(data.slots && data.slots.length) data.slots.forEach(slot=>{
                let opt = document.createElement('option'); opt.value = slot; opt.textContent = slot; timeSelect.appendChild(opt);
            });
            else timeSelect.innerHTML = '<option value="">No slots available</option>';
        });
});
</script>