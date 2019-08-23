<!DOCTYPE html>
<html lang="en">


<?php
	session_start();
	
	if(isset($_GET['page']))
		$actualPage = $_GET['page'];
	else
		$actualPage = 1;
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

	<link rel="stylesheet" media="all" href="css/paging.css" />
	<script src="js/common.js"></script>

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
		
	<?php

    require "db/mysql_credentials.php";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	


	if(isset($_GET['find'])){
		$find = $_GET['find'];
		$_SESSION['PrevPage']="search.php?find=".$find."&page=".$actualPage;
	
		echo"
			<div class='typeHome'>
				<h1>Results for: ".$find."</h1>
			</div>";
		
	//----- START PAGING PART -----//
		$sql1= "SELECT * FROM book WHERE Author 
				LIKE '%".$find."%' OR Title LIKE '%".$find."%' OR Description LIKE '%".$find."%'";
		
		$result1 = mySQLi_query($conn, $sql1) or die("Error query2");
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
			
			echo"<div class='container'>
					<div id='BooksPublished'>";
			
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
						</div>
						";
						
						if($cont < $firstToView+$bookPerPage-1){
							echo"<div class='separation-line'></div>";
						}
				}
			}//END while
			
			if($actualPage-1 < 1)
				$prev="#";
			else
				$prev="search.php?find=".$find."&page=".($actualPage-1);
			
			if($actualPage+1 > $maxPage)
				$next="#";
			else
				$next="search.php?find=".$find."&page=".($actualPage+1);
			
			
			//----- START pagination -----//
			echo" 
			<br>
			<div class='pagination-position'>
				  <ul class='pagination'>
					<li class='page-item'><a class='page-link' href='".$prev."'>Previous</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=1'>1</a></li>";
			//if there are less than 6 pages -> show them
			if($maxPage < 6)
				for ($i = 2; $i <= $maxPage; $i++)
				echo"<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".$i."'>".$i."</a></li>";
			//otherwise if there are more than 5 pages --> ...
			else if($maxPage > 5)
			{
				if($actualPage == 1)
					echo"<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=2'>2</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						<li class='page-item'><a class='page-link'href='search.php?find=".$find."&page=".($maxPage-1)."'>".($maxPage-1)."</a></li>";
				else if($actualPage == 2)
					echo"<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=3'>3</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == 3)
					echo"<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=3'>3</a></li><li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=4'>4</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage-2)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($maxPage-3)."''>".($maxPage-3)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else if($actualPage == $maxPage-1)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else 
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						  <li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($actualPage-1)."'>".($actualPage-1)."</a></li>
						  <li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".$actualPage."'>".$actualPage."</a></li>
						  <li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".($actualPage+1)."'>".($actualPage+1)."</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				//page max
				echo "<li class='page-item'><a class='page-link' href='search.php?find=".$find."&page=".$maxPage."''>".$maxPage."</a></li>";
			}//END else if($maxPage > 5)

			echo "<li class='page-item'><a class='page-link' href='".$next."'>Next</a></li>
				  </ul>
			</div></div>";//END BooksPublished and container
		
		
		}//END if($bookPublished > 0)
		//----- SEARCH: No results found -----//
		else
			echo "<br><br><br><br><br><br><br><br><br>
				<div class='alert alert-warning' role='alert'>
					<h2><center>No results found. <br>
					Make sure that all words are spelled correctly.
				</center></h2> 
				</div><br><br><br><br><br><br><br><br><br>";
	}




	//----- CATEGORY ---------------//
	else if(isset($_GET['cat'])){	
		$cat = $_GET['cat'];
		$_SESSION['PrevPage']="search.php?cat=".$cat."&page=1";
		echo"
			<div class='typeHome'>
				<h1>".$cat."</h1>
			</div>";
		
		//START PAGING PART	
		$sql1= "SELECT book.* FROM book,concern,category,faculty 
			WHERE book.ID = concern.Book and concern.Category = category.ID and category.Faculty = faculty.ID and faculty.Name = '".$cat."'";
		
		$result1 = mySQLi_query($conn, $sql1) or die("Error query2");
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
			
			echo"<div class='container'>
					<div id='BooksPublished'>";
			
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
				$prev="search.php?cat=".$cat."&page=".($actualPage-1);
			
			if($actualPage+1 > $maxPage)
				$next="#";
			else
				$next="search.php?cat=".$cat."&page=".($actualPage+1);
			
			echo"
			<br>
			<div class='pagination-position'>
				  <ul class='pagination'>
					<li class='page-item'><a class='page-link' href='".$prev."'>Previous</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=1'>1</a></li>";
			//if there are less than 6 pages -> show them
			if($maxPage < 6)
				for ($i = 2; $i <= $maxPage; $i++)
				echo"<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".$i."'>".$i."</a></li>";
			//otherwise if there are more than 5 pages --> ...
			else if($maxPage > 5)
			{
				if($actualPage == 1)
					echo"<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=2'>2</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						<li class='page-item'><a class='page-link'href='search.php?cat=".$cat."&page=".($maxPage-1)."'>".($maxPage-1)."</a></li>";
				else if($actualPage == 2)
					echo"<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=3'>3</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == 3)
					echo"<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=3'>3</a></li><li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=4'>4</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage-2)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($maxPage-3)."''>".($maxPage-3)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else if($actualPage == $maxPage-1)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else 
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						  <li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($actualPage-1)."'>".($actualPage-1)."</a></li>
						  <li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".$actualPage."'>".$actualPage."</a></li>
						  <li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".($actualPage+1)."'>".($actualPage+1)."</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				//page max
				echo"<li class='page-item'><a class='page-link' href='search.php?cat=".$cat."&page=".$maxPage."''>".$maxPage."</a></li>";
			}
			echo"<li class='page-item'><a class='page-link' href='".$next."'>Next</a></li>
				  </ul>

			</div></div>";//END BooksPublished and container
		
		
		}
		//----- SEARCH: No books in this category -----//
		else
			echo "<br><br><br><br><br><br><br><br><br>
				<div class='alert alert-warning' role='alert'>
					<h2><center>No books in this category</center></h2> 
				</div><br><br><br><br><br><br><br><br><br>";
	
	}
	?>
	
</div>

<br><br><br>

<?php
	require "footer.php";
?>

 
</body>
</html>
