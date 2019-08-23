<!DOCTYPE html>
<html lang="en">


<?php
	session_start();
	$_SESSION['PrevPage'] = "favourite.php?";
    if(!isset($_SESSION['username'])) {
        header("location: index.php");
    }	
	
	if(isset($_GET['page']))
		$actualPage = $_GET['page'];
	else
		$actualPage = 1;
	$_SESSION['PrevPage'] = "favourite.php??user=page=".$actualPage;
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
	<link rel="stylesheet" media="all" href="css/profileStyle.css" />
	<link rel="stylesheet" media="all" href="css/paging.css" />

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


<div class="content">
	<br>
    <h1 class="title text-center">Wish List</h1>
	<br>

	
	<?php

	require "db/mysql_credentials.php";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		
		
		$sql1 = "SELECT book.* FROM book, wishlist 
				WHERE Book=Id and Username ='$user'";
		
		$result1 = mySQLi_query($conn, $sql1) or die("Error query1");
		$bookPublished = $result1->num_rows;
		
		if($bookPublished > 0){
			$bookPerPage = 2;
			
			$maxPage = ceil(($bookPublished)/$bookPerPage);
			//check, if page number >> max --> show last page
			if($actualPage > $maxPage)
				$actualPage = $maxPage;
			else if($actualPage < 1)
				$actualPage = 1;
			
			
			$firstToView = ($actualPage-1)*$bookPerPage;

			$cont = -1;
			
			echo"<div id='BooksPublished'>";
			
			while($row1 = mySQLi_fetch_array($result1)){
				$cont ++;
				//echo "Cont ".$cont;
				if($cont < $firstToView){
					continue;
				}
				else if($cont >= $firstToView + $bookPerPage)
					break;
				else{
					echo"						
						<div class='book-content' onclick='goToPageBook(".$row1['ID'].");'>
							<div class='cover'>
								<img src='data:image/jpeg;base64,".base64_encode($row1['Cover'])."' alt='cover'/>
							</div>
							<div class='description'>
							<h3>".$row1['Author']." - ".$row1['Title']."</h3>
							</div>
							<div class='description'>
							<p>".$row1['Description']."</p>
							</div>
						</div>";
						
						if($cont < $firstToView+$bookPerPage-1){
							echo"<div class='separation-line'></div>";
						}
				}
			}	
			
			if($actualPage-1 < 1)
				$prev="#";
			else
				$prev="favourite.php?page=".($actualPage-1);
			
			if($actualPage+1 > $maxPage)
				$next="#";
			else
				$next="favourite.php?page=".($actualPage+1);
			
			echo"
			<div class='pagination-position'>
				  <ul class='pagination'>
					<li class='page-item'><a class='page-link' href='".$prev."'>Previous</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=1'>1</a></li>";
			//if there are less than 6 pages -> show them
			if($maxPage < 6)
				for ($i = 2; $i <= $maxPage; $i++)
				echo"<li class='page-item'><a class='page-link' href='favourite.php?page=".$i."'>".$i."</a></li>";
			//otherwise if there are more than 5 pages --> ...
			else if($maxPage > 5)
			{
				if($actualPage == 1)
					echo"<li class='page-item'><a class='page-link'
							href='favourite.php?page=2'>2</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						<li class='page-item'><a class='page-link'href='favourite.php?page=".($maxPage-1)."'>".($maxPage-1)."</a></li>";
				else if($actualPage == 2)
					echo"<li class='page-item'><a class='page-link' href='favourite.php?page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=3'>3</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == 3)
					echo"<li class='page-item'><a class='page-link' href='favourite.php?page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=3'>3</a></li><li class='page-item'><a class='page-link' href='favourite.php?page=4'>4</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage-2)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=".($maxPage-3)."''>".($maxPage-3)."</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else if($actualPage == $maxPage-1)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='favourite.php?page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else 
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						  <li class='page-item'><a class='page-link' href='favourite.php?page=".($actualPage-1)."'>".($actualPage-1)."</a></li>
						  <li class='page-item'><a class='page-link' href='favourite.php?page=".$actualPage."'>".$actualPage."</a></li>
						  <li class='page-item'><a class='page-link' href='favourite.php?page=".($actualPage+1)."'>".($actualPage+1)."</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				//page max
				echo"<li class='page-item'><a class='page-link' href='favourite.php?page=".$maxPage."''>".$maxPage."</a></li>";
			}
			echo"<li class='page-item'><a class='page-link' href='".$next."'>Next</a></li>
				  </ul>
			</div>
			</div>";
				
		}
		else
			echo"<br><br><br><br><br><br><br><br><br><br><br><br><br>
				<div class='alert alert-warning' role='alert'>
					<h2><center>Your list is empty !!</center></h2> 
				</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}

	else
		header("location: index.php");
	
?>
	

</div>


  <?php
  	require "footer.php";
  ?>

 
</body>
</html>
