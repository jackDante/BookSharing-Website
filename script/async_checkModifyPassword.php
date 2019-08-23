<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$old_pass = $conn->real_escape_string($_GET['old']);

session_start();
if(!isset($_SESSION['username'])) {
    die("Error");
}
$user = $_SESSION['username'];

$sql = "SELECT Password FROM user where Password ='$old_pass' AND Username ='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "ok";
}
else
	echo $sql;

$conn->close();
?>
