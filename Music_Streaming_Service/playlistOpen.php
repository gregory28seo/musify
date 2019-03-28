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

<!DOCTYPE html>
<html lang="en">
<head>
  <title>List of tracks</title>
  
  <style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    -webkit-animation-name: fadeIn; /* Fade in the background */
    -webkit-animation-duration: 0.4s;
    animation-name: fadeIn;
    animation-duration: 0.4s
}

/* Modal Content */
.modal-content {
    position: fixed;
    bottom: 0;
    background-color: #fefefe;
    width: 100%;
    -webkit-animation-name: slideIn;
    -webkit-animation-duration: 0.4s;
    animation-name: slideIn;
    animation-duration: 0.4s
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #20c997;
    color: white;
    height: fit-content!important;
}
.modal-dialog {    margin-top: 17% !important;}
.modal-body {padding: 2px 16px;height: fit-content!important;}

.modal-footer {
    padding: 2px 16px;
       background-color: #20c997;
    color: white;
}

/* Add Animation */
@-webkit-keyframes slideIn {
    from {bottom: -300px; opacity: 0} 
    to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
    from {bottom: -300px; opacity: 0}
    to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}

@keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}
</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="scripts/star.js"></script>
</head>
<body>
<div id="menu"></div><script type="text/javascript">$("#menu").load( "Navbar.php" );</script>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="ModalRate" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          
          
          <!-- star start -->
        <div class="container">
		    <div class="row lead">
		        <p>Rate this track</p>
		        <!-- <div id="stars-existing" class="starrr"></div> -->
		        <input id ="star-rating" type="number" min="0" max="5"></input>
		        You gave a rating of <span id="count-existing"></span> star(s)
		    </div>
		</div>
          <!-- star end -->
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id ="RateButton" data-dismiss="modal">Rate</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
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

$sql1 = "Call Playlist_details ('".$Playlist_id."')";
$result1 = $conn->query($sql1);
while($row = $result1->fetch_assoc()) {
	$Playlist_title   = $row['Playlist_title'];
	$Playlist_date = $row['Playlist_date'];
	$Playlist_owner = $row['Playlist_owner'];
}

?>
		<html>
		<div>
		<?php echo  $Playlist_title?>
		<br>created on
		<?php echo $Playlist_date?>
		<br>
		created by
		<?php echo $Playlist_owner?>
		</div>
		</html>
		
		
		<?php 
	
	
	$conn->close();
	
	
	
?>


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
		echo "<table class='table table-striped' align = 'center' border='1'>
   <tr>
   <th ALIGN = 'Center'>TRACK TITLE</th>
   <th ALIGN = 'Center'>TRACK DURATION</th>
   <th ALIGN = 'Center'>ARTIST NAME</th>
   <th ALIGN = 'Center'>NUMBER OF TIMES TRACK PLAYED</th>
   <th ALIGN = 'Center'>AVERAGE RATING</th>
		<th ALIGN = 'Center'>Rate it</th>
   <th ALIGN = 'Center'>LISTEN</th>

   </tr>";
		while($row = $result->fetch_assoc()) {
			$Track_ID = $row['Track_ID'];
		$Track_title = $row['Track_title'];
		$rate = $row['Rating'];
		$aname = $row['Track_aname'];
		if ($rate == '')
		{
			$rate = "NOT RATED";
		}
		echo "<tr>";
		echo "<td ALIGN = 'Center'>" . $row['Track_title'] . "</td>";
		echo "<td ALIGN = 'Center'>" . $row['Track_duration'] . "</td>";
		echo "<td ALIGN = 'Center'>" ."<a href=artist.php?compna=",urlencode($aname),">". $aname . "</td>";
		echo "<td ALIGN = 'Center'>" . $row['No_of_times_played'] . "</td>";
		echo "<td ALIGN = 'Center'>" . $rate . "</td>";
		echo "<td><input type='submit' value ='Rate now' data-target='#ModalRate' onclick='Rate(\"".$row['Track_ID']."\")'></td>";
		?>
		            <td ALIGN = 'Center'><input type='button' value='Play' onclick="Spotfiy('<?php echo $Track_ID;?>','<?php echo $Track_title;?>')"></input></td>
		    <?php  
		            echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "No Tracks added in the playlist";
	}
	
	$conn->close();
	
	
?>
<div id="myModal" class="modal" style="top: 79%">
    <div class="modal-content">
        <div class="modal-header" style="justify-content: unset;">    
        <div id ="trackTitle">Modal Footer</div>
            <span class="close">&times;</span>   
        </div>
        <div id = "Spotify">
            </div>
    </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[1];

// When the user clicks the button, open the modal 
/* btn.onclick = function() {
    modal.style.display = "block";
} */
function Spotfiy(Track_ID,Track_title) {     
    document.getElementById("trackTitle").innerHTML = Track_title;
    document.getElementById("Spotify").innerHTML = '<iframe id="miFrame" width="100%" src="https://open.spotify.com/embed?uri=spotify:track:'+Track_ID+'"frameborder="0" allowtransparency="true"></iframe>';
    modal.style.display = "block";
    var User = '<?php echo $_SESSION["Username"];?>';
    var Track_ID1 = Track_ID;
    $.post('insert_into_play.php',{postTrack_ID:Track_ID1,postUsername:User, Source: 'Playlist', Source_id: <?php echo $Playlist_id?>},
    function(data)
    {
    $('#result').html(data);    
    });
return true;
} 

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
	function Rate (Track_id_para) {

		
	   $.post('previous_rating.php',{Track_id :Track_id_para	},
			   function(data)
			   {
		   		var currentRating = data;  
		   		document.getElementById('star-rating').value = currentRating;
				document.getElementById('count-existing').innerHtml = currentRating;
				$('#ModalRate').modal('toggle');
				
				 $('#count-existing').html(currentRating);
				
				 $('#count').html(currentRating);
			   });
		
	   document.getElementById("RateButton").addEventListener("click", function(){
		   if (document.getElementById('star-rating').value >= 0 && document.getElementById('star-rating').value <=5) {
			   $.post('insert_rating.php',{Track_id :Track_id_para, Rate:document.getElementById('star-rating').value},
					   function(data)
					   {
				   		console.log(data);
				   		location.reload(); 
					   });
			   } else {
				   alert ("Please enter rate in range");
			   }
		});
		
		
	}
</script>
		
		</body>
</html>