function valid(){
	let f = true;
	const msg = document.getElementById("msg");
	msg.innerHTML = "";

	const username = (document.getElementById("username") || {}).value || "";
	const email = (document.getElementById("email") || {}).value || "";
	const password = (document.getElementById("password") || {}).value || "";
	const confirm = (document.getElementById("confirm_password") || {}).value || "";

	if(!username || !email || !password || !confirm) {
		f = false;
		msgEl.innerHTML = "All fields are required.";
		return f;
	}

	// basic email check
	const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if(!emailRe.test(email)){
		f = false;
		msg.innerHTML = "Enter a valid email address.";
		return f;
	}

	if(password.length < 6){
		f = false;
		msg.innerHTML = "Password must be at least 6 characters.";
		return f;
	}

	if(password !== confirm){
		f = false;
		msg.innerHTML = "Passwords do not match.";
		return f;
	}

	return f;
}

reload_table();

function reload_table(){

    let table = document.getElementById("table");

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function(){

        let data = JSON.parse(this.responseText);

        let tableData = "";

        tableData +=
        "<table border='1'>" +
        "<tr>" +
        "<th>ID</th>" +
        "<th>Patient ID</th>" +
        "<th>Doctor ID</th>" +
        "<th>Date</th>" +
        "<th>Time</th>" +
        "<th>Reason</th>" +
        "<th>Status</th>" +
        "<th>Booked By</th>" +
        "</tr>";

        for(let i = 0; i < data.length; i++){

            tableData += "<tr><td>"
            + data[i].id + "</td><td>"
            + data[i].patient_id + "</td><td>"
            + data[i].doctor_id + "</td><td>"
            + data[i].appointment_date + "</td><td>"
            + data[i].appointment_time + "</td><td>"
            + data[i].reason + "</td><td>"
            + data[i].status + "</td><td>"
            + data[i].booked_by + "</td></tr>";
        }

        tableData += "</table>";

        table.innerHTML = tableData;
    }

    
    xmlhttp.open("GET", "../CONTROLLER/dataLoad.php", true);

    xmlhttp.send();
}