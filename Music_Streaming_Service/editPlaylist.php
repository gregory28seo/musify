<?php 
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "music_streaming_service";
	
	$Playlist_id = $_POST["Playlist_id"];

	
	
	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	
	
	$sql = "CALL Display_contents_of_playlist('".$Playlist_id."')";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		echo "<table class='table table-striped' border='1'>";
		echo "<tr><td>"."Track title"."</td><td>"."rating"."</td><td>"."Number of times track played"."</td></tr>";
		while($row = $result->fetch_assoc()) {
			$Track_title   = $row['Track_title'];
			$average_rating = $row['average_rating'];
			$No_of_times_played = $row['No_of_times_played'];
			$track_id_para = $row['Track_ID'];
			echo "<tr><td>".$Track_title."</td><td>".$average_rating."</td><td>".$No_of_times_played."</td><td><input type='submit' value ='Delete now'  onclick='Delete(\"".$track_id_para."\",".$Playlist_id.")'></td></tr>";
		}
		echo "</table>";
	} else {
		echo "0 results";
	}
	
	$conn->close();
	
	
?>
