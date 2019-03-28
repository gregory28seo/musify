<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Welcome</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  
</head>
<body>
<div id="menu">
	<link rel="stylesheet" type="text/css" href="styles/flatty.css">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Musify</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


</nav>
<script type="text/javascript">
var href = 'http://localhost/Music_Streaming_Service/user.php?compna=';
href = href + '<?php echo $_SESSION["Username"];  ?>';
document.getElementById('prf').setAttribute('href', href);


function logOut () {
	 $.post('Logout.php',{},
			    function(data)
			    {
			    console.log(data);
			    location.href = "http://localhost/Music_Streaming_Service/login.php";
			    });
}
</script>
</div>
<!-- login -->
<h1>Login here</h1>
<form method="POST" action="login.php">
<table >
 
   <tr>
    <td>Username:</td>
    <td><input required="true" type="text" name="LogUsername"></td>
  </tr>
   <tr>
    <td>Password:</td>
    <td><input required="true" type="password" name="Logpassword"></td>
  </tr>
  <br>
  
</table>
<p><input type="submit" value="Log in">
</form>

<!-- registration form -->
<h1>New User? Sign in here</h1>
<form method="POST" action="login.php">
<table>
  <tr>
    <td>Full name:</td>
    <td><input required="true" type="text" name="Name"></td>
  </tr>
   <tr>
    <td>Username:</td>
    <td><input required="true" type="text" name="Username"></td>
  </tr>
   <tr>
    <td>Password:</td>
    <td><input required="true" type="password" name="password"></td>
  </tr>
  <br>
   <tr>
    <td>email id:</td>
    <td><input required="true" type="email" name="email"></td>
  </tr>
   <tr>
    <td>city:</td>
    <td><input required="true" type="text" name="city"></td>
  </tr>
  
</table>
<p><input type="submit" value="Register">
</form>
</body>

<?php 
if(isset($_POST["Username"])  && !empty($_POST["Username"])){
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "music_streaming_service";
	
	$Name = $_POST["Name"];
	$Username = $_POST["Username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$city = $_POST["city"];
	
	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$query  = $conn->query("CALL new_user_signup('".$Username."', '".$email."', '".$city."', '".$Name."', '".$password."', @output);");

	$results = $conn->query('select @output') or die("Error in the consult.." . mysqli_error($conn));
	
	$row = $results->fetch_assoc();
		
	$title = $row['@output'];
		
	if ($title == "Success") {
		echo "Successfully registereed, pls log in to continue";
	} else {
		echo "Username not available, change the username and try again";
	}
	
	
	
	$conn->close();
}




//log in
if(isset($_POST["LogUsername"])  && !empty($_POST["LogUsername"])){
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "music_streaming_service";
	
	
	$LogUsername = $_POST["LogUsername"];
	$Logpassword = $_POST["Logpassword"];
	
	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$query  = $conn->query("CALL LOGIN('".$LogUsername."', '".$Logpassword."', @output);");
	
	$results = $conn->query('select @output') or die("Error in the consult.." . mysqli_error($conn));
	
	$row = $results->fetch_assoc();
	
	$title = $row['@output'];
	
	if ($title == "Success") {
	session_start();
	$_SESSION["Username"] = $LogUsername;
	$_SESSION["logged"] = "true";
	?>
	
	<script type="text/javascript">
	window.location.href = "http://localhost/Music_Streaming_Service/homepage.php";
	</script>
		
	<?php 
	} else {
		echo "username and password did not match";
	}
	
	
	
	$conn->close();
}
?>
<script>
	
</script>
</html>
