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
<?php 
if (true) {
	echo "<div id = \"Search\">";
	$Search_Value = $_POST['Search'];
	$Search_Type = 'Track';
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
   <th>TRACK TITLE</th>
   <th>TRACK DURATION</th>
   <th>ARTIST NAME</th>
   <th>LISTEN</th>
   </tr>";
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
				$Track_ID = $row['Track_ID'];
				$Track_title = $row['Track_title'];
				echo "<tr>";
				echo "<td>" . $row['Track_title'] . "</td>";
				echo "<td>" . $row['Track_duration'] . "</td>";
				echo "<td>" . $row['Track_aname'] . "</td>";
				?>
            <td><input type='button' class="btn btn-success" value='insert' onclick='Insert("<?php echo $Track_ID;?>","<?php echo $Track_title;?>","<?php echo $row['Track_duration'] ;?>","<?php echo $row['Track_aname'];?>")'></input></td>
    <?php  
            echo "</tr>";
        }
        echo "</table>";
		}
	} else {
	echo "no results";
	}
}
?>
