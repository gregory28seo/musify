<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Track_id_para = $_POST["Track_id"];
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL Fetch_previous_rating('".$Track_id_para."','".$_SESSION["Username"]."')";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			
			while($row = $result->fetch_assoc()) {
				echo $row['Rating'];
			}
		} else {
			echo "0";
		}
	
?>