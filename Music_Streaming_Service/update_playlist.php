<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Playlist_title = $_POST["Playlist_title"];
		$publicv = $_POST["publicv"];
		$Playlist_id = $_POST["Playlist_id"];
		
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL update_playlist_creation('".$Playlist_id."','".$Playlist_title."','".$publicv."')";
		echo $sql;
		$result = $conn->query($sql);
	 	echo $result;
?>