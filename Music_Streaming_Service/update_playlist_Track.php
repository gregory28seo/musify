<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Track = $_POST["Track"];
		$Playlist_id = $_POST["Playlist_id"];
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL new_playlist_track_updation('".$Playlist_id."','".$Track."')";
		echo $sql;
		$result = $conn->query($sql);
	 	echo $result;
?>