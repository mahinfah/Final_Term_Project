<h2>Doctor Dashboard</h2>
<p>Welcome, Dr. <?php echo htmlspecialchars($user_data['name']); ?>.</p>
<div class="dashboard-cards">
    <div class="card">
        <a href="?page=today_schedule">📅 Today's Schedule</a>
    </div>
    <div class="card">
        <a href="?page=pending_requests">⏳ Pending Requests</a>
    </div>
    <div class="card">
        <a href="?page=weekly_calendar">🗓️ Weekly Calendar</a>
    </div>
    <div class="card">
        <a href="?page=earnings">💰 Earnings</a>
    </div>
</div>
<style>
.dashboard-cards { display: flex; gap: 20px; margin-top: 20px; }
.card { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; flex:1; }
.card a { text-decoration: none; font-size: 18px; color: #007bff; }
</style>