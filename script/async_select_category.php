<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$faculty = $conn->real_escape_string($_GET['faculty']);

$sql = "SELECT distinct ID FROM faculty where name = '".$faculty."'";
$result = $conn->query($sql);

$id = 0;

while($row = $result->fetch_assoc()) {
    $id = $row['ID'];
}


$sql = "SELECT distinct name FROM category where Faculty = '".$id."'";
$result = $conn->query($sql);

$categories_to_return = "<option value='' selected disabled>Category</option>";

while($row = $result->fetch_assoc()) {
    $cat = $row['name'];
    if(strlen($cat) != 0) {
    $categories_to_return = $categories_to_return."<option value='" . $cat . "'>" . $cat . "</option>";
    }
}

echo $categories_to_return;


$conn->close();

?>
