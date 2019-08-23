<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $conn->real_escape_string($_GET['email']);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

$username = $conn->real_escape_string($_GET['username']);
$username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);


$login = false;

$sql = "SELECT email 
		FROM user 
		where email ='".$email."'";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    echo "email";
}
else{
    $sql = "SELECT username FROM user where username ='".$username."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "username";
    }
    else
        echo "ok";
}



$conn->close();
?>
