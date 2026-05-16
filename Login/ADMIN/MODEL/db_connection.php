<?php
	function conn_open(){
		$conn = mysqli_connect("localhost","root","","hospital_db");

		if(!$conn) die("error".mysqli_connect_error());
		return $conn;
	}
?>