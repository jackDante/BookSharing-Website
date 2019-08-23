<!DOCTYPE html>
<html lang="en">

<?php

    require "db/mysql_credentials.php";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    session_start();
    if(!isset($_SESSION['username'])) {
        header("location: login.php");
    }

    $user = $_SESSION['username'];
    $other = $conn->real_escape_string($_GET['user_to']);

    $_SESSION['PrevPage'] = "view_chat.php?user_to=".$other;

    if(strcmp($user, $other) == 0){
        header("location: index.php");
    }

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        header("location: login.php");
    }

    $sql = "UPDATE chat 
            SET Is_read = 1 
            WHERE User_from = '".$other."' and User_to = '".$user."'";

    if (!($conn->query($sql) === TRUE)) {
        die("Error: " . $sql . "<br>" . $conn->error);
        header("location: login.php");
    }

?>


<head>

    <title>STARTSAW</title>
    <meta charset="utf-8">
    <!-- icon webpage ----------------------------------------->
    <link rel="icon" href="favicon.ico" type="image" sizes="16x16">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.css"> <!-- aggiunto -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <link rel="stylesheet" media="all" href="css/common.css" />
	<link rel="stylesheet" media="all" href="css/live_chat.css" />
 <!--   <link rel="stylesheet" media="all" href="css/bootstrap-category.css" />  -->
    <script src="js/common.js"></script>
    <script src="js/chat.js"></script>

</head>

<body>

<?php
    require "navbar.php";
?>



<div class="container" id="chatbox">

        <?php
            echo'
                
                    <div class="container-fluid top-bar">
                        <div class="col-md-9 col-xs-11">
                            <h3 class="panel-title">
                            <i class="fa fa-comment my-comment"></i>
                            <chat_with>Chat with</chat_with><strong> '.$other.'</strong></h3>
                        </div>
                    </div>

                <div class="chatlogs" id="chatlogs">

                	<div id="message-panel-body" class="container-fluid">
                
                ';

            $sql = "SELECT distinct * 
                    FROM chat 
                    WHERE (User_from = '".$user."' and User_to = '".$other."') 
                        or (User_from = '".$other."' and User_to = '".$user."')";

            $result = mySQLi_query($conn, $sql) or die("Error query");
            $list_users = array();

            while($row = mySQLi_fetch_array($result)) {
                if (strcmp($user, $row['User_from']) == 0) {
                    echo '
                        <div class="msg_container base_sent">
                            <div class="col-md-8 col-sm-9 col-xs-11" >

                                <div class="messages msg_sent" id="verdeinvio">
                                    <p class="message-body">'.$row['Message'].'</p>
                                    <time>'.$row['Datetime'].'</time>
                                </div>

                            </div>

                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="https://cdn1.iconfinder.com/data/icons/system-black-circles/512/linux_tox-512.png" class="img-profile img-responsive ">
                            </div>
                        </div>
                        ';
                } 
                else if (strcmp($user, $row['User_to']) == 0) {
                    echo '
                        <div class="msg_container base_receive">
                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="https://forums.opera.com/assets/uploads/profile/1559-profileavatar.png" class="img-profile img-responsive ">
                            </div>

                            <div class="col-md-8 col-sm-9 col-xs-11">
                                <div class="messages msg_receive">
                                    <p class="message-body">'.$row['Message'].'</p>
                                    <time>'.$row['Datetime'].'</time>
                                </div>
                            </div>
                        </div>';
                }
            }//END while

            echo'
                </div>
				
				</div>
                
                <div class="chat-form" >

                        <input type="hidden" id="user_to" value="'.$other.'">

                        <textarea id="input-message" class="form-control"></textarea>
                        
                        
                        <button class="btn btn-primary btn-sm" id="btn-chat" onclick="async_send_message()">
                        Send 
                        <i class="fa fa-angle-right" style="color: black;"></i></button>
                        
                    

                </div>
            
            ';
        ?>
    
</div>

</body>
</html>