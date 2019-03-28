<?php 
session_start();
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "music_streaming_service";
		$Playlist_title = $_POST["Playlist_title"];
		$publicv = $_POST["publicv"];
		
		// Create connection
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "CALL new_playlist_creation('".$Playlist_title."', '".$_SESSION["Username"]."','".$publicv."')";
		echo $sql;
		$result = $conn->query($sql);
	 	echo $result;
?>