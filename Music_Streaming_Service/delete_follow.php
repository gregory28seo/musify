<?php
$User = $_POST['postUsername'];
$Following_id = $_POST['postFollowing_id'];
$con=mysqli_connect("localhost","root","R@hulg002","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL unfollow('$User','$Following_id')";
mysqli_query($con, $sql);
?>