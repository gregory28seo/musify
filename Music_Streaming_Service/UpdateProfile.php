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
<script src="scripts\jquery-3.2.1.min.js"></script>
</head>
<body>
<div id="menu"></div><script type="text/javascript">$("#menu").load( "Navbar.php" );</script>
<?php
$User = $_SESSION["Username"];
echo "<H1><CENTER>USER PROFILE PAGE</CENTER></H1>";
echo "<br>";
echo "<div id = \"User\" style=\"float: left; width: 100%;\">";
echo "<div id = \"User_Details\" style=\"float: left; width: 30%;\">";
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CALL display_user_data('$User')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {
        echo "<LEFT><H2>USER DETAILS</H2></LEFT>";
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $Name = $row['Name'];
            $City = $row['City'];
            $Email = $row['Email'];
            echo "<LEFT><H4>USERNAME : $User</H4></LEFT>";
            echo " <form method = \"post\"><LEFT>
                   <B>NAME :</B> &nbsp;<input type=\"text\" id = \"name\" name=\"name\" required autofocus>
                   <br><br>
                   <B>CITY :</B>&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id = \"city\" name=\"city\" required>
                   <br><br>
                   <B>EMAIL :</B> <input type=\"email\" name=\"email\" id = \"email\" required>
		   		   <br><br>
    		       <B>PASSWORD :</B> <input type=\"password\" name=\"password\" id = \"password\">
    		       <br><br>
                   <input name = \"Save\" type= \"submit\" value=\"SAVE\">
		           </LEFT></form>";		   
        }
    }
?>  
<SCRIPT>
document.getElementById("name").value = "<?php echo $Name; ?>";
document.getElementById("city").value = "<?php echo $City; ?>";
document.getElementById("email").value = "<?php echo $Email; ?>";
</SCRIPT>
<?php
    mysqli_free_result($retval1);
    mysqli_close($con);
    if (isset($_POST['Save'])) {
        $Name1 = $_POST['name'];
        $City1 = $_POST['city'];
        $Email1 = $_POST['email'];
        $password = $_POST['password']; 
        $con=mysqli_connect("localhost","root","","music_streaming_service");
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "CALL update_user('$User','$Name1','$City1','$Email1','$password')";
    mysqli_query($con, $sql);
    mysqli_close($con);
?>
<script>
   window.location.href = 'http://localhost/music_streaming_service/User.php?compna=<?php echo $_SESSION["Username"];?>';
</script>
<?php   
    }
    echo "</div>";
    echo "<div id = \"User_Followers\" style=\"float: left; width: 70%;\">";
    echo "<div id = \"User_Followers_Count\" style=\"float: left; width: 15%;\">";
    echo "<br>";
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CALL no_of_followers('$User')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $count = $row['follower_count'];
            echo "<br>";
            echo "<p ALIGN = 'right'>"."<i>"."<b>".$count."FOLLOWERS"."</b>"."</i>"."</p>";
        }
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
    echo "</div>";
    echo "<div class = \"popup\" id = \"User_follower_button_popup\" style=\"float: left; width: 10%;\">";
    echo "<br>";
    echo "<br>";
    ?>
<input type='button' value='+' style='height:30px; width:50px' <?php if ($count == '0'){ ?> disabled <?php   } ?> onclick="myPopUp()"></input>
<?php
echo "<div class= \"popuptext\" id =\"myPopup\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL All_followers('$User')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $Username1 = $row['username'];
        echo "<tr>";
        echo "<a href=User.php?compna=",urlencode($Username1),">".$Username1 ."</a>";
        echo "<br>";
        echo "</tr>";
}
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "<div id = \"User_Following_Count\" style=\"float: left; width: 15%;\">";
echo "<br>";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL count_following('$User')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $count = $row['count'];
        echo "<br>";
        echo "<p ALIGN = 'right'>"."<i>"."<b>".$count."FOLLOWING"."</b>"."</i>"."</p>";
    }
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "<div class = \"popup\" id = \"User_Following_button_popup\" style=\"float: left; width: 10%;\">";
echo "<br>";
echo "<br>";
?>
<input type='button' value='+' style='height:30px; width:50px' <?php if ($count == '0'){ ?> disabled <?php   } ?> onclick="myPopUp1()"></input>
<?php
echo "<div class= \"popuptext\" id =\"myPopup1\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL all_following('$User')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $Username1 = $row['Following_id'];
        echo "<tr>";
        echo "<td ALIGN = 'Center'>" ."<a href=User.php?compna=",urlencode($Username1),">".$Username1 ."</a>". "</td>";
        echo "<br>";
        echo "</tr>";
}
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "<br>";
echo "<br>";
echo "<div id = \"User_Other_Details\">";
echo "<div id = \"User_Playlists\" style=\"float: left; width: 50%;\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$User = $_SESSION["Username"];
$sql = "CALL Display_Playlist('$User','$User')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    echo "<CENTER><H2>USER PLAYLISTS :</H2></CENTER>";
    echo "<br>";
    echo "<table class='table table-striped' align = 'Center' border='1'>
   <tr>
   <th ALIGN = 'Center'>PLAYLIST TITLE</th>
   <th ALIGN = 'Center'>PLAYLIST CREATION DATE</th>
   </tr>";
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $Playlist_title = $row['Playlist_title'];
        $Playlist_date = $row['Playlist_date'];
        echo "<tr>";
        echo "<td ALIGN = 'Center'>" ."<a href=artist.php?compna=",urlencode($Playlist_title),">". $Playlist_title . "</td>";
        echo "<td ALIGN = 'Center'>" . $Playlist_date . "</td>";  
        echo "</tr>";        
    }
    echo "</table>";
}
else
{
    echo "<LEFT><H2>USER PLAYLISTS :</H2></LEFT>";
    echo "<LEFT><H4>NO PLAYLISTS ARE CREATED BY $User</H4></LEFT>";
}
    mysqli_free_result($retval1);
    mysqli_close($con);
echo "</div>";
echo "<div id = \"User_Liked_Artist\" style=\"float: left; width: 50%;\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL User_liked_Artist('$User')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    echo "<CENTER><H2>LIKED ARTISTS :</H2></CENTER>";
    echo "<br>";
    echo "<table class='table table-striped' align = 'Center' border='1'>
   <tr>
   <th ALIGN = 'Center'>ARTIST NAME</th>
   <th ALIGN = 'Center'>ARTIST DESCRIPTION</th>
   </tr>";
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $aname = $row['aname'];
        $adesc = $row['adesc'];
        echo "<tr>";
        echo "<td ALIGN = 'Center'>" ."<a href=artist.php?compna=",urlencode($aname),">". $aname . "</td>";
        echo "<td ALIGN = 'Center'>" . $adesc . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else
{
    echo "<LEFT><H2>LIKED ARTISTS :</H2></LEFT>";
    echo "<LEFT><H4>NO ARTIST LIKED BY $User</H4></LEFT>";
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "</div>";
?>
<script>

 function Insert(User,Following_id) {
	    var User = User;
	    var Following_id = Following_id;
	    $.post('insert_follow.php',{postFollowing_id:Following_id,postUsername:User},
	    function(data)
	    {
	        $('#result').html(data);
	    });
	    window.location.reload();
	    return true;
	}

 function Delete(User,Following_id) {
	    var User = User;
	    var Following_id = Following_id;
	    $.post('delete_follow.php',{postFollowing_id:Following_id,postUsername:User},
	    function(data)
	    {
	        $('#result').html(data);
	    });
	    window.location.reload();
	    return true;
	}
 
function myPopUp() {
    var popup = document.getElementById("myPopup");
        
    	popup.classList.toggle("show");            
}

function myPopUp1() {
    var popup1 = document.getElementById("myPopup1");
        
    	popup1.classList.toggle("show");            
}

</script>
</body>
</html>

