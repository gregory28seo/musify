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
<html>
<head>
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
<script src="scripts\jquery-3.2.1.min.js"></script>
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
		        <input  id ="star-rating" type="number" max="5" min="0"></input>
		        You gave a rating of <span id="count-existing"></span> star(s)
		    </div>
		</div>
          <!-- star end -->
          
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" id ="RateButton" data-dismiss="modal">Rate</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>





<form id = "MyForm" method = "post">
<div ALIGN = "Center">
<input type="text" name="Search" placeholder = "Search" required>
<select name="Search_Type">
  <option value="Track">TRACK</option>
  <option value="Album">ALBUM</option>
  <option value="Playlist">PLAYLIST</option>
</select>
<input name ="Search_Submit" type="submit" value="SEARCH">
</div>
</form>
<br>
<?php
if (isset($_POST['Search_Submit'])) {
echo "<div id = \"Search\">";
    $Search_Value = $_POST['Search'];
    $Search_Type = $_POST['Search_Type'];
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CALL keyword_search('$Search_Value','$Search_Type')";
    $retval = mysqli_query($con, $sql);
    if ($retval->num_rows > 0)
    {
    if ($Search_Type == 'Track')
    {   
        echo "<center>SEARCH RESULTS</center>";
        echo "<br>";
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
        while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
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
            echo "<td ALIGN = 'Center'>" . $row['Played_Number'] . "</td>";
            echo "<td ALIGN = 'Center'>" . $rate . "</td>";
            echo "<td><input type='submit' value ='Rate now' data-target='#ModalRate' onclick='Rate(\"".$row['Track_ID']."\")'></td>";
    ?> 
            <td ALIGN = 'Center'><input type='button' value='Play' onclick="Spotfiy('<?php echo $Track_ID;?>','<?php echo $Track_title;?>')"></input></td>
    <?php  
            echo "</tr>";
        }
        echo "</table>";
    }
    else if ($Search_Type == 'Album')
    {
        echo "<center>SEARCH RESULTS</center>";
        echo "<br>";
        echo "<table class='table table-striped' align = 'center' border='1'>
   <tr>
   <th ALIGN = 'Center'>ALBUM NAME</th>
   </tr>";
        while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "<td ALIGN = 'Center'>" ."<a href='#' onclick='openAlbum(\"".$row['Album_id']."\",\"".$row['Album_title']."\")'>".$row['Album_title'] . "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "<center>SEARCH RESULTS</center>";
        echo "<br>";
        echo "<table class='table table-striped' align = 'center' border='1'>
   <tr>
   <th ALIGN = 'Center'>PLAYLIST NAME</th>
   <th ALIGN = 'Center'>PLAYLIST OWNER</th>
   </tr>";
        while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $Username1 = $row['Playlist_owner'];
            echo "<tr>";
            
            echo "<td>" ."<a href='#' onclick='openPlaylist(".$row['Playlist_id'].")'>". $row['Playlist_title'] . "</td>";
            echo "<td ALIGN = 'Center'>" ."<a href=User.php?compna=",urlencode($Username1),">".$Username1 ."</a>". "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }    
    }
    else
    {
        echo "<h3><center>NO RESULTS FOUND</h3></center>";
    }
    mysqli_free_result($retval);
    mysqli_close($con);
echo "</div>";
}
else
{
echo "<div id = \"Last_Played\">";
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $user = $_SESSION["Username"];
    $sql = "CALL Last_Played_by_the_user('".$user."')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {
        echo "<CENTER>LISTEN AGAIN</CENTER>";
        echo "<br>";
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
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
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
            echo "<td ALIGN = 'Center'>" . $row['Played_Number'] . "</td>";
            echo "<td ALIGN = 'Center'>" . $rate . "</td>";
            echo "<td><input type='submit' value ='Rate now' data-target='#myModal' onclick='Rate(\"".$row['Track_ID']."\")'></td>";
            ?>
            <td ALIGN = 'Center'><input type='button' value='Play' onclick="Spotfiy('<?php echo $Track_ID;?>','<?php echo $Track_title;?>')"></input></td>
<?php  
            echo "</tr>";        
    }
    echo "</table>";
    }
    mysqli_free_result($retval1);
    mysqli_close($con);        
echo "</div>";
echo "<br>";
echo "<div id =\"Recommended\">";
echo "<div id =\"Tracks\">"; 
$con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql = "CALL new_tracks_liked_artist('".$_SESSION["Username"]."')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {   
        echo "<CENTER>RECOMMENDED TRACKS</CENTER>";
        echo "<br>";
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
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
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
            echo "<td ALIGN = 'Center'>" . $row['Played_Number'] . "</td>";
            echo "<td ALIGN = 'Center'>" . $rate . "</td>";
            echo "<td><input type='submit' value ='Rate now' data-target='#myModal' onclick='Rate(\"".$row['Track_ID']."\")'></td>";
            ?> 
            <td ALIGN = 'Center'><input type='button' value='Play' onclick="Spotfiy('<?php echo $Track_ID;?>','<?php echo $Track_title;?>')"></input></td>
<?php  
            echo "</tr>";        
    }
    echo "</table>";
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
echo "</div>";
echo "<br>";
echo "<div id =\"Playlist\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql = "CALL new_playlist_followed_User('".$_SESSION["Username"]."')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {   
        echo "<CENTER>RECOMMENDED PLAYLISTS</CENTER>";
        echo "<br>";
        echo "<table class='table table-striped' align = 'center' border='1'>
   <tr>
   <th ALIGN = 'Center'>PLAYLIST TITLE</th>
   <th ALIGN = 'Center'>PLAYLIST OWNER</th> 
   </tr>";
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $Username1 = $row['Playlist_owner'];
            echo "<tr>";
            echo "<td>" ."<a href='#' onclick='openPlaylist(".$row['Playlist_id'].")'>". $row['Playlist_title'] . "</td>";
            echo "<td ALIGN = 'Center'>" ."<a href=User.php?compna=",urlencode($Username1),">".$Username1 ."</a>". "</td>";
            echo "</tr>";        
    }
    echo "</table>";
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
echo "</div>";
echo "</div>";
echo "<br>";
echo "<div id =\"You_May_Also_Like\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql = "CALL Related_Artist('".$_SESSION["Username"]."')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {   
        echo "<CENTER>YOU MAY ALSO LIKE THESE ARTISTS</CENTER>";
        echo "<br>";
        echo "<table class='table table-striped' align = 'center' border='1'>
   <tr>
   <th ALIGN = 'Center'>ARTIST NAME</th>
   </tr>";
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $aname = $row['aname21'];
            echo "<tr>";
            echo "<td ALIGN = 'Center'>" ."<a href=artist.php?compna=",urlencode($aname),">".$aname . "</td>";  
            echo "</tr>";        
    }
    echo "</table>";
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
        
echo "</div>";
}
?>


<!-- play list logic --> 
<script type="text/javascript">
	function openPlaylist (Playlist_id) {
		method = "post"; // Set method to post by default if not specified.

	    // The rest of this code assumes you are not using a library.
	    // It can be made less wordy if you use one.
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

	function openAlbum (Album_id, album_title) {
		method = "post"; // Set method to post by default if not specified.
	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", "AlbumOpen.php");

	    var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "Album_id");
        hiddenField.setAttribute("value", Album_id);

        var hiddenField1 = document.createElement("input");
        hiddenField1.setAttribute("type", "hidden");
        hiddenField1.setAttribute("name", "album_title");
        hiddenField1.setAttribute("value", album_title);

        form.appendChild(hiddenField);
        form.appendChild(hiddenField1);

	    document.body.appendChild(form);
	    form.submit();
	}
</script>



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
var span = document.getElementsByClassName("close")[0];

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
    $.post('insert_into_play.php',{postTrack_ID:Track_ID1,postUsername:User},
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