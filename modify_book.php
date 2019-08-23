<!DOCTYPE html>
<html lang="en">


<?php
	session_start();

	if(!isset($_SESSION['username'])) {
	    header('location: index.php');
	}
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

    <link rel="stylesheet" media="all" href="css/common.css" />
    <link rel="stylesheet" media="all" href="css/insert.css" >

    <script src="js/common.js"></script>
    <script src="js/insert.js"></script>
    

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


<div class="backimginsert">
    <br><br>

    <div id="form-div">
	 <?php

		require "db/mysql_credentials.php";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$id = 0;
		if(isset($_GET['Id']))
			$id = $_GET['Id'];
		else
			echo"THERE IS AN ERROR";
			
		$sql = "SELECT book.*, Price, Place FROM book,insertion 
				WHERE book.ID = Material_offered AND book.ID = '".$id."';";
		$result = $conn->query($sql);

		while($row = $result->fetch_assoc()) {
			echo"
			<form class='montform' action='script/commit_modify_book.php' method='POST' id='reused_form' enctype='multipart/form-data'>
				<input name='id' type='hidden' value='".$id."' id='id' />
				<p class='title'>Book Information</p>
				<p class='author'>
					<input name='author' type='text' class='feedback-input' value='".$row['Author']."' required placeholder='Author' id='author' />
				</p>
				<p class='title'>
					<input name='title' type='text' required class='feedback-input' value='".$row['Title']."' id='title' placeholder='Title' />
				</p>
				<p class='text'>
					<textarea name='description' class='feedback-input' id='description' placeholder='Description'>".$row['Description']."</textarea>
				</p>
				<p class='pages'>
					<input name='pages' type='number' required class='feedback-input' value='".$row['PageNum']."' id='pages' placeholder='Number of Pages'/>
				</p>
				<p class='edition'>
					<input name='edition' type='text' required class='feedback-input' value='".$row['Edition']."' id='edition' placeholder='Edition'/>
				</p>
				<p class='isbn'>
					<input name='isbn' type='text' required class='feedback-input' value='".$row['ISBN']."' id='isbn' placeholder='ISBN'/>
				</p>
				<p class='title'>Cover</p>
				<div id='BookCover'>
					<img src='data:image/jpeg;base64,".base64_encode($row['Cover'])."' alt='cover'/>
				</div>
				<p class='file'>
					<input name='image' type='file' id='image' class='feedback-input'/>
				</p>			
				<p class='title'>Book Categories</p>
			";
			
			
			$sql1 = "SELECT category.Name as Category, faculty.Name as Faculty 
					FROM concern, category, faculty 
					WHERE concern.Category = category.ID AND category.Faculty = faculty.ID AND concern.Book = '".$id."';
					";
			
			$result1 = $conn->query($sql1);

			if (!$result1) {
    			printf("Error: %s\n", mysqli_error($conn));
    			exit();
			}

			echo"	
				<div class='categories' id='categories'>
					<input name='number_of_categories' type='hidden' value='1' id='number_of_categories'>";
				

				while($row1 = mySQLi_fetch_array($result1)) {
					echo"
					<section class='col col-6'>
					<input type='text' name='fac0' id='fac0' class='feedback-input' readonly value='".$row1['Faculty']."'>
					</section>
					<section class='col col-6'>					
					<input type='text' name='cat0' id='cat0' class='feedback-input' readonly value='".$row1['Category']."'>
					</section>";
					
				}
				
				echo"
				<section class='col col-6'>
					<select name='fac1' id='fac1' class='feedback-input' required onchange='selectCategory(1)'>
						<option value='not-selected' selected disabled>Faculty</option>";
					   
						$sql2 = "SELECT distinct Name FROM faculty";
						$result2 = $conn->query($sql2);

						while($row2 = mySQLi_fetch_array($result2)) {
							$fac = $row2['Name'];
							if(strlen($fac) != 0) {
								echo "<option value='" . $fac . "'>" . $fac . "</option>";
							}
						}

						$conn->close();

				echo"   
				</select>
				</section>

				<section class='col col-6'>
					<select name='cat1' class='feedback-input' required  id='cat1' >
						<option value='not-selected' selected disabled>Category</option>
					</select>
				</section>

				</div>
				<br>

				<p class='categories'>
					<button type='button' class='button-plus' onclick='addNewCategory()'>Add New Category</button>
					<br><br>
				</p>

				<p class='title'>Selling Information</p>
				<p class='price'>
					<input name='price' type='number' required class='feedback-input' value='".$row['Price']."' id='price' placeholder='Price'/>
				</p>

				<p class='place'>
					<input name='place' type='text' required class='feedback-input' value='".$row['Place']."' id='place' placeholder='Place'/>
				</p>



				<div class='submit'>
					<button type='submit' class='button-blue'>Submit</button>
					<div class='ease'></div>	
				<div class='submit'>
				</form>
				
				<form action='script/delete_publication.php' method='GET'>
					<input type='hidden' id='Id' name='Id' value='".$id."'/>
					<button type='submit' class='button-red'>Delete book</button>
					<div class='ease'></div>
				</div>
				
				</form>";
			}
         ?>
        <br><br><br><br><br><br>
    </div>
</div>







</body>
</html>