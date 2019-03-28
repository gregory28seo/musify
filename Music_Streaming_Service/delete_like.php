<?php
$User = $_POST['postUsername'];
$Artist_name = $_POST['postartist_name'];
$con=mysqli_connect("localhost","root","R@hulg002","music_streaming_service");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "CALL DELETE_ARTIST_LIKE('$User','$Artist_name')";
mysqli_query($con, $sql);
?>