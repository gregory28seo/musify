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
$compname = $_GET['compna'];
$User = $_SESSION["Username"];
echo "<H1><CENTER>USER PROFILE PAGE</CENTER></H1>";
echo "<br>";
echo "<div class='row' id = \"User\">";
If($User != $compname)
{
	echo "<div class='col-sm-6' id = \"User_Details\" >";
	$con=mysqli_connect("localhost","root","","music_streaming_service");
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "CALL display_user_data('$compname')";
	$retval1 = mysqli_query($con, $sql);
	if ($retval1->num_rows > 0)
	{
		echo "<LEFT><H2>USER DETAILS</H2></LEFT>";
		while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
			$Name = $row['Name'];
			$City = $row['City'];
			$Email = $row['Email'];
			echo "<LEFT><H4>USERNAME : $compname</H4></LEFT>";
			echo "<LEFT><H4>NAME : $Name</H4></LEFT>";
			echo "<LEFT><H4>CITY : $City</H4></LEFT>";
			echo "<LEFT><H4>EMAIL :$Email</H4></LEFT>";
			echo " <form action = \"UpdateProfile.php\" method = \"post\"><LEFT>
		   		   <input type= \"submit\" value=\"UPDATE\">
		           </LEFT></form>";
        }
    }
    mysqli_free_result($retval1);
			mysqli_close($con);
			echo "</div>";
			echo "<div class='row col-sm-6' id = \"User_Followers\">";
			echo "<div id = \"User_Followers_Count\" >";
    echo "<br>";
			$con=mysqli_connect("localhost","root","","music_streaming_service");
			// Check connection
					if (mysqli_connect_errno())
    {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
				$sql = "CALL no_of_followers('$compname')";
				$retval1 = mysqli_query($con, $sql);
				if ($retval1->num_rows > 0)
				{
				while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
				$count = $row['follower_count'];
				echo "<br>";
				echo "<p>"."<i>"."<b>".$count."FOLLOWERS"."</b>"."</i>"."</p>";
				}
				}
				mysqli_free_result($retval1);
				mysqli_close($con);
				echo "</div>";
    echo "<div class = \"popup\" id = \"User_follower_button_popup\" >";
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
	$sql = "CALL All_followers('$compname')";
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
	echo "</div>";
	echo "<div style=\"margin-left: 6%;\" id = \"User_Following_Count\">";
	echo "<br>";
	$con=mysqli_connect("localhost","root","","music_streaming_service");
	// Check connection
	if (mysqli_connect_errno())
	{
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "CALL count_following('$compname')";
	$retval1 = mysqli_query($con, $sql);
	if ($retval1->num_rows > 0)
	{
	    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
	        $count = $row['count'];
	        echo "<br>";
	        echo "<p>"."<i>"."<b>".$count."FOLLOWING"."</b>"."</i>"."</p>";
	    }
	}
	mysqli_free_result($retval1);
	mysqli_close($con);
	echo "</div>";
	echo "<div class = \"popup\" id = \"User_Following_button_popup\">";
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
	$sql = "CALL all_following('$compname')";
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
	echo "<div id = \"User_follow_button\" style=\" width: 20%;\">";
	echo "<br>";
	echo "<br>";
	$con=mysqli_connect("localhost","root","","music_streaming_service");
	// Check connection
	if (mysqli_connect_errno())
	{
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$User = $_SESSION["Username"];
	$sql = "CALL check_follow('$User','$compname')";
	$retval1 = mysqli_query($con, $sql);
	if ($retval1->num_rows > 0)
	{
	    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
	        $count = $row['count'];
	        if($count == '0')
	        {
	?>
	        <LEFT><input type='button' value='FOLLOW' style='height:30px; width:80px' onclick="Insert('<?php echo $User;?>','<?php echo $compname;?>')"></input></LEFT>
	<?php             
	        }
	        else 
	        {
	?>
	        <LEFT><input type='button' value='UNFOLLOW'style='height:30px; width:90px' onclick="Delete('<?php echo $User;?>','<?php echo $compname;?>')"></input></LEFT>
	<?php        
	        }
	    }
	}
	    mysqli_query($con, $sql);
	    mysqli_close($con);
	echo "</div>";
	echo "</div>";
}
else 
{
    echo "<div class='col-sm-6' id = \"User_Details\" >";
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CALL display_user_data('$compname')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {
        echo "<LEFT><H2>USER DETAILS</H2></LEFT>";
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $Name = $row['Name'];
            $City = $row['City'];
            $Email = $row['Email'];
            echo "<LEFT><H4>USERNAME : $compname</H4></LEFT>";
            echo "<LEFT><H4>NAME : $Name</H4></LEFT>";
            echo "<LEFT><H4>CITY : $City</H4></LEFT>";
            echo "<LEFT><H4>EMAIL :$Email</H4></LEFT>";
            echo " <form action = \"UpdateProfile.php\" method = \"post\"><LEFT>
		   		   <input type= \"submit\" value=\"UPDATE\">
		           </LEFT></form>";		   
        }
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
    echo "</div>";
    echo "<div class='row col-sm-6' id = \"User_Followers\">";
    echo "<div id = \"User_Followers_Count\" >";
    echo "<br>";
    $con=mysqli_connect("localhost","root","","music_streaming_service");
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CALL no_of_followers('$compname')";
    $retval1 = mysqli_query($con, $sql);
    if ($retval1->num_rows > 0)
    {
        while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
            $count = $row['follower_count'];
            echo "<br>";
            echo "<p>"."<i>"."<b>".$count."FOLLOWERS"."</b>"."</i>"."</p>";
        }
    }
    mysqli_free_result($retval1);
    mysqli_close($con);
    echo "</div>";
    echo "<div class = \"popup\" id = \"User_follower_button_popup\" >";
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
$sql = "CALL All_followers('$compname')";
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
echo "</div>";
echo "<div style=\"margin-left: 6%;\" id = \"User_Following_Count\">";
echo "<br>";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL count_following('$compname')";
$retval1 = mysqli_query($con, $sql);
if ($retval1->num_rows > 0)
{
    while($row = mysqli_fetch_array($retval1, MYSQLI_ASSOC)) {
        $count = $row['count'];
        echo "<br>";
        echo "<p>"."<i>"."<b>".$count."FOLLOWING"."</b>"."</i>"."</p>";
    }
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";
echo "<div class = \"popup\" id = \"User_Following_button_popup\">";
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
$sql = "CALL all_following('$compname')";
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
}

echo "</div>";
echo "<br>";
echo "<br>";
echo "<div class='row' id = \"User_Other_Details\">";
echo "<div class='col-sm-6' id = \"User_Playlists\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$User = $_SESSION["Username"];
$sql = "CALL Display_Playlist('$User','$compname')";
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
    echo "<LEFT><H4>NO PLAYLISTS ARE CREATED BY $compname</H4></LEFT>";
}
    mysqli_free_result($retval1);
    mysqli_close($con);
echo "</div>";
echo "<div class='col-sm-6' id = \"User_Liked_Artist\">";
$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL User_liked_Artist('$compname')";
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
    echo "<LEFT><H4>NO ARTIST LIKED BY $compname</H4></LEFT>";
}
mysqli_free_result($retval1);
mysqli_close($con);
echo "</div>";

?>
<script>

 function Insert(User,Following_id) {
	    $.post('insert_follow.php',{postFollowing_id:Following_id,postUsername:User},
	    function(data)
	    {
	        $('#result').html(data);
	    });
	    window.location.reload();
	    return true;
	}

 function Delete(User,Following_id) {
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
