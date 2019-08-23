<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("location: ../index.php");
}
echo "Connected successfully";

session_start();
if(!isset($_SESSION['username'])) {
    header("location: index.php");
}

$user = $_SESSION['username'];
$new = $conn->real_escape_string($_POST['pswEncryptChange']);

$sql = "UPDATE user SET Password = '".$new."' WHERE Username = '".$user."'";

$result = mySQLi_query($conn, $sql) or die("Error query");

header("location: ../setting.php");

?>
