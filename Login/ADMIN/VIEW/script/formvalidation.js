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