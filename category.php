<!DOCTYPE html>
<html lang="en">


<?php
	session_start();
	$_SESSION['PrevPage'] = "category.php";
?>


<head>
  <title>STARTSAW</title>
  <meta charset="utf-8">
  <!-- icon webpage ----------------------------------------->
  <link rel="icon" href="favicon.ico" type="image" sizes="16x16">

  <meta name="viewport" content="width=device-width, initial-scale=1">
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



<body>

	<?php
		require "navbar.php";
	?>



<!-- Genova -->

<img src="img/header_category.jpg" alt="Header" width="100%" height="320px">


<br><br><br><br><br>
<!-- category list-link -->
<div class="text-center">
      <div class="row">

            <?php

              require "db/mysql_credentials.php";

              // Create connection
              $conn = new mysqli($servername, $username, $password, $dbname);

              // Check connection
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              $sql = "SELECT * FROM faculty";
              $result = mySQLi_query($conn, $sql) or die("Error query");

              while($row = mySQLi_fetch_array($result)){
                  echo
                  "
                  <div class='category col-lg-4 col-md-3 col-sm-4 col-ssm-8 col-xs-10'>
                          <a href='search.php?cat=".$row['Name']."&page=1'>
                            <h2>".$row['Name']."</h2>
                          </a>
                   </div>
                  ";
              }

            ?>

      </div>


</div><!-- END text-center-->
<br><br><br><br><br><br><br><br>

  <?php
      require "footer.php";
  ?>
 

</body>
</html>