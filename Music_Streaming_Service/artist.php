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
/* Popup container - can be anything you want */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 160px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}
</style>
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
    background-color: #5cb85c;
    color: white;
    height: 148px;
}

.modal-body {padding: 2px 16px;height: 83px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
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
$compname = $_GET['compna'];
echo "<H1><CENTER>ARTIST</CENTER></H1>";
echo "<br>";
echo "<div id = \"Artist\" style=\"float: left; width: 100%;\">";
echo "<div id = \"Artist_Details\" style=\"float: left; width: 60%;\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL display_artist_data('$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{        
    echo "<LEFT><H2>ARTIST DETAILS :</H2></LEFT>";
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $aname = $row['aname'];
        $adesc = $row['adesc'];
        echo "<LEFT><H4>ARTIST NAME : $aname</H4></LEFT>";
        echo "<LEFT><H4>ARTIST DESCRIPTION : $adesc</H4></LEFT>";
    }
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "<div id = \"Artist_Likes\" style=\"float: left; width: 40%;\">";
echo "<div id = \"Artist_Likes_Count\" style=\"float: left; width: 10%;\">";
echo "<br>";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL Artists_Like_count('$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $count = $row['like_count'];
        echo "<br>";
        echo "<p ALIGN = 'right'>"."<i>"."<b>".$count."LIKES"."</b>"."</i>"."</p>";
    }
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "<div class = \"popup\" id = \"Artist_Likes_button_popup\" style=\"float: left; width: 10%;\">";
echo "<br>";
echo "<br>";
?>
&nbsp;&nbsp;&nbsp;<RIGHT><input type='button' value='+' style='height:30px; width:40px' <?php if ($count == '0'){ ?> disabled <?php   } ?> onclick="myPopUp()"></input></RIGHT>
<?php
echo "<div class= \"popuptext\" id =\"myPopup\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL Artists_Like('$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $Username1 = $row['Username'];
        echo "<a href=User.php?compna=",urlencode($Username1),">".$Username1 ."</a>";
        echo "<br>";
      
}
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "</div>";
echo "<div id = \"Artist_Likes_button\" style=\"float: left; width: 20%;\">";
echo "<br>";
echo "<br>";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$User = $_SESSION["Username"];
$sql = "CALL check_like('$User','$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $count = $row['count'];
        if($count == '0')
        {
?>
        <LEFT><input type='button' value='LIKE' style='height:30px; width:80px' onclick="Insert('<?php echo $User;?>','<?php echo $compname;?>')"></input></LEFT>
<?php             
        }
        else 
        {
?>
        <LEFT><input type='button' value='UNLIKE'style='height:30px; width:80px' onclick="Delete('<?php echo $User;?>','<?php echo $compname;?>')"></input></LEFT>
<?php        
        }
    }
}
    mysqli_query($con, $sql);
    mysqli_close($con);
echo "</div>";
echo "</div>";
echo "</div>";
echo "<br>";
echo "<br>";
echo "<div id = \"Artist_Tracks\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL tracks_by_artist('$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    echo "<CENTER><H2>ARTIST TRACKS :</H2></CENTER>";
    echo "<br>";
    echo "<table class='table table-striped' align = 'Center' border='1'>
   <tr>
   <th ALIGN = 'Center'>TRACK TITLE</th>
   <th ALIGN = 'Center'>TRACK DURATION</th>
   <th ALIGN = 'Center'>NUMBER OF TIMES TRACK PLAYED</th>
   <th ALIGN = 'Center'>AVERAGE RATING</th>
   <th ALIGN = 'Center'>Rate</th>
   <th ALIGN = 'Center'>LISTEN</th>
   </tr>";
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $Track_ID = $row['Track_ID'];
        $Track_title = $row['Track_title'];
        $rate = $row['Rating'];
        if ($rate == '')
        {
            $rate = "NOT RATED";
        }
        echo "<tr>";
        echo "<td ALIGN = 'Center'>" . $row['Track_title'] . "</td>";
        echo "<td ALIGN = 'Center'>" . $row['Track_duration'] . "</td>";
        echo "<td ALIGN = 'Center'>" . $row['Played_Number'] . "</td>";
        echo "<td ALIGN = 'Center'>" . $rate . "</td>";
        echo "<td><input type='submit' value ='Rate now' data-target='#ModalRate' onclick='Rate(\"".$row['Track_ID']."\")'></td>";
        ?>
            <td ALIGN ='Center'><input type='button' value='Play' onclick="Spotfiy('<?php echo $Track_ID;?>','<?php echo $Track_title;?>')"></input></td>
<?php  
            echo "</tr>";        
    }
    echo "</table>";
}
else
{
    echo "<center><H2>ARTIST TRACKS :</H2></center>";
    echo "<center><H4>NO TRACKS ARE RECORDED BY $compname</H4></center>";
}
    mysqli_free_result($retval1);
    mysqli_close($con);
echo "</div>";
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

 function Insert(User,artist_name) {
	    $.post('insert_like.php',{postartist_name:artist_name,postUsername:User},
	    function(data)
	    {
	        $('#result').html(data);
	    });
	    window.location.reload();
	    return true;
	}

 function Delete(User,artist_name) {
	    $.post('delete_like.php',{postartist_name:artist_name,postUsername:User},
	    function(data)
	    {
	        $('#result').html(data);
	    });
	    window.location.reload();
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

function myPopUp() {
    var popup = document.getElementById("myPopup");
        
    	popup.classList.toggle("show");            
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
