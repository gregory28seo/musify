<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Track_id_para = $_POST["Track_id"];
		$Playlist_id = $_POST["Playlist_id"];
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL Delete_Playlist('".$Track_id_para."', '".$Playlist_id."')";
		echo $sql;
		$result = $conn->query($sql);
	 	echo $result;
?>