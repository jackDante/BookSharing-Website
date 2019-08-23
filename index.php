<!DOCTYPE html>
<html lang="en">

<?php
	session_start();
	$_SESSION['PrevPage'] = "index.php";
?>


<head>
	<title>STARTSAW</title>
	<meta charset="utf-8">
	<!-- icon webpage ----------------------------------------->
	<link rel="icon" href="favicon.ico" type="image" sizes="16x16">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/bootstrap.css"> <!-- aggiunto -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<link rel="stylesheet" media="all" href="css/footer.css" />
	<link rel="stylesheet" media="all" href="css/common.css" />
	<link rel="stylesheet" media="all" href="css/home.css" />
	<script src="js/common.js"></script>


	<!-- new message? sse utente è loggato-->
      <?php
	      if(isset($_SESSION['username'])) {
	          echo '<script src="js/message_updates.js"></script>';
	      }
      ?>
</head>




<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<!-- NAVBAR ----------------------------------------->
	<?php
	    require "navbar.php";
	?>


<img src="img/hero.jpg" class="img-fluid" alt="Responsive image" id="hero">


<!-- Container (INTRO Section) ----------------------------------------->
<div class="container">
	<h1 class="title text-center"><span style="color: #0052cc">Bookshare </span>makes reading easier.</h1>
               
    <h3 class="text-center">How is that possible? By sharing your books that you don't use with other people you save money!</h3>
</div>



<!-- Container (GUIDE STEP-BY-STEP Section) ----------------------------------------->
<div class="row">

  <a href="login.php" title="Click here to register" style="text-decoration:none">
  <div class="col-sm-4" style="background-color: #49cc93;">
    <h2>1. Register</h2>
    <p>Find more of what you're looking for.</p>
  </div>
  </a>
  <div class="col-sm-4" style="background-color: #0095cc;">
    <h2>2. Chat or SHARE</h2>
    <p>Connect with the world around you on STARTSAW.</p>
  </div>
  <div class="col-sm-4" style="background-color: #E74C3C;">
    <h2>3. Save your money</h2>
    <p>This is a simple way to save money.</p>
  </div>

</div>


<!-- Container (ABOUT Section) ----------------------------------------->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About STARTSAW</h2><h3>"the best bookstores where you can find great deals on used books"</h3><br>
      <h4>We've spent quite a bit of time on our search engine and really hope it will help you search for, refine, and find the title you want. 
	  We give sellers the platform, solutions, and support they need to grow their businesses and thrive. We measure our success by our customers' success.
	  </h4>
    </div>
    <div class="col-sm-4">
    	<!-- immagine laterale libri -->
    	<img src="img/bstack.jpg" alt="Header" width="100%" height="100%">
    </div>
  </div>
</div>



<!-- Container (Last ad Added insertion Section) ----------------------------------------->
<div class="content">
	

	<div class='advertisement'>
		<h1 class="title" align="center">Last book added</h1>
	</div>
	<br>
		

	<?php
    require "db/mysql_credentials.php";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//$conn = new mysqli("localhost", "root", "", "university_sharing");

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT * FROM book ORDER BY Id desc LIMIT 4 ";
	$result = mySQLi_query($conn, $sql) or die("Error query");

	while($row = mySQLi_fetch_array($result)){
		echo
		"
		<div class='book-content' onclick='goToPageBook(".$row['ID'].");'>
			<div class='cover'>
				<img src='data:image/jpeg;base64,".base64_encode($row['Cover'])."' alt='cover'/>
			</div>
			<div class='description'>
				<h3>".$row['Author']." - ".$row['Title']."</h3>
			</div>
			<div class='description'>
				<p>".$row['Description']."</p>
			</div>
		</div>
		<div class='separation-line'></div>
		";
	}
	?>
	

</div>



<!-- FOOTER ----------------------------------------->
<?php
    require "footer.php";
?>


</body>
</html>
