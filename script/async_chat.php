<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if(isset($_SESSION['username'])) {

    $user = $_SESSION['username'];

    $other = $conn->real_escape_string($_GET['user_to']);

    $sql = "SELECT distinct * 
            FROM chat 
            WHERE Is_read = 0 and User_from = '".$other."' and User_to = '".$user."'";

    $result = mySQLi_query($conn, $sql) or die("Error query");
    $list_users = array();

    $returned_obj = "";

    while($row = mySQLi_fetch_array($result)) {
        $returned_obj = $returned_obj.'
                        <div class="msg_container base_receive">
                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="https://forums.opera.com/assets/uploads/profile/1559-profileavatar.png" class="img-profile img-responsive ">
                            </div>
                            <div class="col-md-10 col-sm-11 col-xs-11">
                                <div class="messages msg_receive">
                                    <p class="message-body">' . $row['Message'] . '</p>
                                    <time>' . $row['Datetime'] . '</time>
                                </div>
                            </div>
                        </div>';
    }

    $sql = "UPDATE chat 
            SET Is_read = 1 
            WHERE User_from = '".$other."' and User_to = '".$user."'";

    if (!($conn->query($sql) === TRUE)) {
        die("Error: " . $sql . "<br>" . $conn->error);
    }


    echo $returned_obj;

}

$conn->close();


?>
