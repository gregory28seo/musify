<?php 
session_start();
?>
<html>
	<link rel="stylesheet" type="text/css" href="styles/flatty.css">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Musify</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="http://localhost/Music_Streaming_Service/homepage.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/Music_Streaming_Service/MyPlaylist.php">My Playlists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="margin-left: 1200%;" id="prf">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="margin-left: 1200%;" onclick="logOut()" href="#">Logout</a>
      </li>
    </ul>
  </div>
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
</html>