<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("location: ../index.php");
}


$user = $conn->real_escape_string($_POST['usernameLog']);
$user = filter_var($user, FILTER_SANITIZE_SPECIAL_CHARS);

$pwd = $conn->real_escape_string($_POST['pswEncryptLog']);

$login = false;


/* Prepare an SQL statement for execution */
if ($stmt = $conn->prepare('SELECT Username, Password FROM user where Username =? ')) {

$stmt->bind_param('s', $user);

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["Password"];
        if($row["Password"] == $pwd)
        {
            $login = true;
        }
    }
}
else
    echo $sql;


} /* END Prepare an SQL statement for execution */



$conn->close();


if($login){
    session_start();
    $_SESSION['username'] = $user;
	
	if(isset($_SESSION['PrevPage']))
		header("location: ../".$_SESSION['PrevPage']);
	else
		header("location: ../index.php");
}
else{
    header("location: ../index.php");
}



?>
