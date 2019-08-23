<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

session_start();
if(!isset($_SESSION['username'])) {
    header("location: index.php");
}

$id = $_GET['Id'];
//Delete from DB (just in Book -> cascade, it will be deleted from the other tables
$sql = "DELETE FROM book WHERE ID = '".$id."'";

$result = mySQLi_query($conn, $sql) or die("Error query");

header("location: ../my_publications.php?page=1");
?>
