<?php
$User = $_POST['postUsername'];
$Track_ID = $_POST['postTrack_ID'];

$con=mysqli_connect("localhost","root","","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (isset($_POST['Source'])) {
	$Source = $_POST['Source'];
	$Source_id = $_POST['Source_id'];
	$sql = "CALL track_played('$User','$Track_ID','$Source','$Source_id')";
} else {
	$sql = "CALL track_played('$User','$Track_ID','','')";
}

mysqli_query($con, $sql);
?>