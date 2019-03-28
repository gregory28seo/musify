<?php
session_start();
if ($_SESSION["logged"] != "true") {
	?>
		<script type="text/javascript">
		window.location.href = "http://localhost/Music_Streaming_Service/login.php";
		</script>		
	<?php 
}
?>

<html>
<head>
  <title>List of tracks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="scripts/star.js"></script>
</head>
<div id="menu"></div><script type="text/javascript">$("#menu").load( "Navbar.php" );</script>
<script>
var editPlaylistId;
function openPlaylist (Playlist_id) {
	method = "post"; 
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "playlistOpen.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "Playlist_id");
    hiddenField.setAttribute("value", Playlist_id);

    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();
}
 function EditPLaylist(Playlist_id_para, title, publicpara) {
	 editPlaylistId = Playlist_id_para;
	 $.post('editPlaylist.php',{Playlist_id :Playlist_id_para},
			   function(data)
			   {
		 			$('#result').html(data);  
		 			document.getElementById('createNew').style.visibility = 'unset';
		 			document.getElementById('search').style.visibility = 'unset';
		 			document.getElementById('playlistName').value = title;
		 			if (publicpara) {
		 				document.getElementsByName('gender')[1].checked = true;
		 			}
			   });
	   
 }

 function Delete (Track_id_para, Playlist_id_para) {
	 $.post('deletePlaylist.php',{Track_id: Track_id_para,Playlist_id :Playlist_id_para},
			   function(data)
			   {
		 			console.log(data);
		 			location.reload(); 
			   });
 }
 function Done() {
		var playlistName = document.getElementById('playlistName').value;
		var publicvar;
		if (document.getElementsByName('gender')[0].checked) {
			 publicvar = 0;
		} else {
			 publicvar = 1;
		}
		if (editPlaylistId){
			$.post('update_playlist.php',{Playlist_title :playlistName, publicv: publicvar,Playlist_id : editPlaylistId},
				   function(data)
				   {	
			   			console.log(data);	
			   			if (newPlalistTracks.length == 0) {
			   				location.reload();
			   			}
				   });

			for(i in newPlalistTracks) {
				$.post('update_playlist_Track.php',{Track :newPlalistTracks[i], Playlist_id : editPlaylistId},
						   function(data)
						   {	
					   			console.log(data);	
					   			location.reload();
						   });
			}
			} else {
				$.post('create_playlist.php',{Playlist_title :playlistName, publicv: publicvar},
						   function(data)
						   {	
					   			console.log(data);	
					   			if (newPlalistTracks.length == 0) {
					   				location.reload();
					   			}
						   });

				for(i in newPlalistTracks) {
					$.post('create_playlist_Track.php',{Track :newPlalistTracks[i]},
							   function(data)
							   {	
						   			console.log(data);	
						   			location.reload();
							   });
				}
				}
		
		
	}
</script>

<div class="row" style="    margin-left: 5%;">
<div class="col-sm-4">

<button class="btn btn-success" onclick="CreateNew()">Create new playlist</button>
<br>
<div style="    margin-top: 22px;" id="createNew">
Playlist Name:
	<input id="playlistName" type=text>
	<br>
 <input style="    margin-top: 3%;" type="radio" name="gender" value="private" checked> private<br>
  <input type="radio" name="gender" value="public"> public<br>
  
 <table class='table table-striped' border="1" id="current">
 </table>
 
 <div >
 <button class="btn btn-success" style="  margin-top: 2%;    margin-bottom: 9%;" onclick="Done()">Done</button>
 </div>
</div>
 <?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "music_streaming_service";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "CALL Display_Playlist('".$_SESSION["Username"]."', '".$_SESSION["Username"]."')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	echo "<table class='table table-striped' border='1' style='    margin-left: 5%;' >";
	echo "<tr><td>"."PLay list title"."</td><td>"."created on"."</td><td>"."Edit"."</td></tr>";
	while($row = $result->fetch_assoc()) {
		$Playlist_title   = $row['Playlist_title'];
		$Playlist_date = $row['Playlist_date'];	
		echo "<td>" ."<a href='#' onclick='openPlaylist(".$row['Playlist_id'].")'>". $row['Playlist_title'] . "</td>";
		echo "<td>".$Playlist_date."</td>
			<td><input type='submit' class='btn btn-success' value ='Edit' onclick='EditPLaylist(\"".$row['Playlist_id']."\", \"".$Playlist_title."\", ".$row['public'].")'></td></tr>";
	}
	echo "</table>";
} else {
	echo "0 results";
}

$conn->close();

?>
</div>

<div class="col-sm-8" id="search">
		<div id="result">
		</div>
		<div ALIGN = "Center">
			<input type="text" id="SearchText" placeholder = "Search">
			<input name ="Search_Submit" onclick= "Search()" type="submit" value="SEARCH">
		</div>
	<div ALIGN = "Center" id="searchResult">
		
	</div>
</div>
  




</div>

<script>
var newPlalistTracks =[];
	$(document).ready(function() { 
		document.getElementById('createNew').style.visibility = 'hidden';
		document.getElementById('search').style.visibility = 'hidden';
		 });
	
	function CreateNew() {
		Playlist_id_para = null;
		document.getElementById('createNew').style.visibility = 'unset';
		document.getElementById('search').style.visibility = 'unset';
		editPlaylistId = null;
		newPlalistTracks =[];
	}
	function Search() {
		$.post('search_playlist.php',{Search :document.getElementById('SearchText').value},
				   function(data)
				   {	
			   			console.log(data);
			 			$('#searchResult').html(data);  
				   });
	}
	function Insert(track_id, track_title, duration,aname) {
		newPlalistTracks.push(track_id);
		var table = document.getElementById("current");
	    var row = table.insertRow(0);
	    var cell1 = row.insertCell(0);
	    var cell2 = row.insertCell(1);
	    var cell3 = row.insertCell(2);
	    cell1.innerHTML = track_title;
	    cell2.innerHTML = duration;
	    cell3.innerHTML = aname;
	}
	
</script>








</html>

