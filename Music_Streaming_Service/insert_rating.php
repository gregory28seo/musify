<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Track_id_para = $_POST["Track_id"];
		$Rate = $_POST["Rate"];
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL rating('".$_SESSION["Username"]."' , '".$Track_id_para."', '".$Rate."')";
		echo $sql;
		$result = $conn->query($sql);
	 	echo $result;
?>