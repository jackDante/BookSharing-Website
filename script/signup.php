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


$user = $conn->real_escape_string($_POST['userSign']);
$user = filter_var($user, FILTER_SANITIZE_SPECIAL_CHARS);

$email = $conn->real_escape_string($_POST['emailSign']);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

$pwd = $conn->real_escape_string($_POST['pswEncryptSign']);

$name = $conn->real_escape_string($_POST['nameSign']);
$name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);

$surname = $conn->real_escape_string($_POST['surnameSign']);
$surname = filter_var($surname, FILTER_SANITIZE_SPECIAL_CHARS);


$gender = $conn->real_escape_string($_POST['gender']);
$date_birth = $conn->real_escape_string($_POST['dateSign']);
$city = $conn->real_escape_string($_POST['citySign']);

$imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));



$sql2 = "SELECT ID from city where NAME = '".$city."'";

$result2 = mySQLi_query($conn, $sql2) or die("Error query2");

while($row2 = mySQLi_fetch_array($result2)){
    $city = $row2['ID'];
}



/* Prepare an SQL statement for execution */

$stmt = $conn->prepare('INSERT INTO user (Username, Email, Password, Name, Surname, Gender, Date_of_birth, City)
                        VALUES (?,?,?,?,?,?,?,?)
                        ');

$stmt->bind_param('ssssssss', $user,$email,$pwd,$name,$surname,$gender,$date_birth,$city);


if ($stmt->execute()) {
    echo "New record created successfully";

    if($imgData != null){
        $sql = "UPDATE user 
                SET Img = '".$imgData."' 
                WHERE Username = '".$user."'";

        $result = mySQLi_query($conn, $sql) or die("Error query update Immagine");

    }

    $stmt->close();
    $conn->close();

    session_start();
    $_SESSION['username'] = $user;

    if(isset($_SESSION['PrevPage']))
        header("location: ../".$_SESSION['PrevPage']);
    else
        header("location: ../index.php");
} else {
	
	$stmt->close();
    $conn->close();
    header("location: ../index.php");
}




?>
