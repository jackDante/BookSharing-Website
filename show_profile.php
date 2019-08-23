<!DOCTYPE html>
<html lang="en">


<?php
	session_start();
	$userProfile = $_GET['user'];
	
	if(!isset($_GET['user'])) {
        if(!isset($_SESSION['username'])) {
            header("location: index.php");
        }
        $userProfile = $_SESSION['username'];
    }
	
	if(isset($_GET['page']))
		$actualPage = $_GET['page'];
	else
		$actualPage = 1;
	$_SESSION['PrevPage'] = "show_profile.php?user=".$userProfile."&page=".$actualPage;
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
	<link rel="stylesheet" media="all" href="css/profileStyle.css" />  
 	<link rel="stylesheet" media="all" href="css/paging.css" />  

	<script src="js/common.js"></script>
    <script src="js/login.js"></script>


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



    <?php

        require "db/mysql_credentials.php";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT user.*, city.Name as C
				FROM user, city 
				WHERE city.ID = City AND Username = '$userProfile'";

		$result = mySQLi_query($conn, $sql) or die("Error query");



        $sql1 = "SELECT *, book.ID as BookID 
        		FROM book, insertion 
        		WHERE User_offerer = '$userProfile' AND Material_offered = book.ID 
        		ORDER BY book.ID DESC";

        $result1 = mySQLi_query($conn, $sql1) or die("Error query1");
        $bookPublished = $result1->num_rows;

        while($row = mySQLi_fetch_array($result)) {

            $date = new DateTime($row['Date_of_birth']);
            $date_of_birth = $date->format('d-m-Y');
            echo '
                <div class="row UserInfo">

                        <div class="well profile" id="profiloUtente">
                                                        
                                    <div class="col-sm-4"">

                                    <figure>'; 
                if ($row['Img'] != null)
                    echo "<img class='profile-image' src='data:image/jpeg;base64,".base64_encode($row['Img'])."' alt='cover'>";
                else
                    echo "<img class='profile-image' src='https://bootdey.com/img/Content/user_1.jpg'>";
            

                echo '
                                    </figure>

                                </div>
                                <div class="col-sm-8 text-center">
                                    <h2><center>' . $row["Username"] . '</center></h2>
                                    <br>
                                    <p><strong>Name: </strong>' . $row['Name'] . ' ' . $row['Surname'] . '</p>
                                    <p><strong>Born on: </strong>' . $date_of_birth . '</p>
                                    <p><strong>Gender: </strong>' . $row['Gender'] . '</p>
                                    <p><strong>Email: </strong>' . $row['Email'] . '</p>
                                    <p><strong>City: </strong>' . $row['C'] . '</p>
            						<br>
                                </div>
                                
                            </div>

                            	<div class="col-xs-12 divider text-center">
                                    <h2><strong> 	'.$bookPublished.'</strong></h2>
                                    <p><small> 	Books Published</small></p>
                                    <p><a href="view_chat.php?user_to='.$userProfile.'">
                                    <button class="btn mybtn btn-info"><span class="fa fa-user">
                                    	</span> 	Contact Now! 
                                    </button></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }


		if($bookPublished > 0){

		    echo "<br><br><div class='advertisement'>
		    				<h1 class='title' align='center'>Last book added</h1>
		    				</div>";
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
				$prev="show_profile.php?user=".$userProfile."&page=".($actualPage-1);
			
			if($actualPage+1 > $maxPage)
				$next="#";
			else
				$next="show_profile.php?user=".$userProfile."&page=".($actualPage+1);
			
			echo"
			<div class='pagination-position'>
				  <ul class='pagination'>
					<li class='page-item'><a class='page-link' href='".$prev."'>Previous</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=1'>1</a></li>";
			//if there are less than 6 pages -> show them
			if($maxPage < 6)
				for ($i = 2; $i <= $maxPage; $i++)
				echo"<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".$i."'>".$i."</a></li>";
			//otherwise if there are more than 5 pages --> ...
			else if($maxPage > 5)
			{
				if($actualPage == 1)
					echo"<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=2'>2</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						<li class='page-item'><a class='page-link'href='show_profile.php?user=".$userProfile."&page=".($maxPage-1)."'>".($maxPage-1)."</a></li>";
				else if($actualPage == 2)
					echo"<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=3'>3</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == 3)
					echo"<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=2'>2</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=3'>3</a></li><li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=4'>4</a></li>
					<li class='page-item'><p class='page-link'>...</p></li>";
				else if($actualPage == $maxPage-2)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($maxPage-3)."''>".($maxPage-3)."</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else if($actualPage == $maxPage-1)
					echo"<li class='page-item'><p class='page-link'>...</p></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($maxPage-2)."''>".($maxPage-2)."</a></li>
					<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($maxPage-1)."''>".($maxPage-1)."</a></li>";
				else 
					echo"<li class='page-item'><p class='page-link'>...</p></li>
						  <li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($actualPage-1)."'>".($actualPage-1)."</a></li>
						  <li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".$actualPage."'>".$actualPage."</a></li>
						  <li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".($actualPage+1)."'>".($actualPage+1)."</a></li>
						<li class='page-item'><p class='page-link'>...</p></li>";
				//page max
				echo"<li class='page-item'><a class='page-link' href='show_profile.php?user=".$userProfile."&page=".$maxPage."''>".$maxPage."</a></li>";
			}
			echo"<li class='page-item'><a class='page-link' href='".$next."'>Next</a></li>
				  </ul>
			</div><br><br>
			
			</div>
			";
		}
		
		else
			echo"<br><br><br>
				<div class='alert alert-warning' role='alert'>
					<h2><center>No books published</center></h2> 
				</div><br><br><br><br><br><br>";
	
	?>
  



	<?php
	require "footer.php";
	?>



</body>
</html>