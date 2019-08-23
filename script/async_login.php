<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("location: ../index.php");
}

$user = $conn->real_escape_string($_GET['username']);
$user = filter_var($user, FILTER_SANITIZE_SPECIAL_CHARS);

$pwd = $conn->real_escape_string($_GET['password']);

$login = false;

$sql = "SELECT username, password FROM user where username ='".$user."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["password"] == $pwd)
        {
            $login = true;
        }
    }
}

$conn->close();

if($login){
    echo "ok";
}
else{
    echo "non ok";
}

?>
