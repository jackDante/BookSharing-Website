<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$book = $conn->real_escape_string($_GET['Book']);

session_start();
if(!isset($_SESSION['username'])) {
    header("location: index.php");
}
$user = $_SESSION['username'];

#Check if already Exists
$sql = "SELECT COUNT(*) as IsThere FROM wishlist WHERE Book='$book' and Username='$user';";

$result = mySQLi_query($conn, $sql) or die("Error query");
		
while($row = mySQLi_fetch_array($result)){
	#If there is not ---> Add !
	if($row['IsThere'] == 0){
		$sql = "INSERT INTO wishlist (Username, Book) VALUES ('$user', '$book');";


		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully.";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	else{ #Otherwise -> delete it from the list
		$sql = "DELETE FROM wishlist WHERE Book='$book' and Username='$user';";

		if (mysqli_query($conn, $sql)) {
			echo "Record deleted successfully.";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}	
	}
}
header("location: ../PageBook.php?Id=".$book."");

?>
