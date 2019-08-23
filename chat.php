<!DOCTYPE html>
<html lang="en">


<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("location: index.php");
    }
    $_SESSION['PrevPage'] = "index.php";
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

    <link rel="stylesheet" media="all" href="css/footer.css" />
	<link rel="stylesheet" media="all" href="css/common.css" />
	<link rel="stylesheet" media="all" href="css/chat.css" />

	<script src="js/common.js"></script>
	<script src="js/all_chat.js"></script>

</head>



<body>


<?php
	require "navbar.php";
?>

<br><br><br>
<h1><i class="fa fa-comments"></i>Chat</h1>
<br><br><br><br>
<div class="container snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div id="all_chats" class="table-responsive">
                        <table class="table user-list">
                            <thead>
                            <tr>
                                <th><span>User</span></th>
                                <th><span>Last Message</span></th>
                                <th class="text-center"><span>Status</span></th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php

                            require "db/mysql_credentials.php";
                            $user = $_SESSION['username'];
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT distinct User_from, User_to, MAX(Datetime) as max_date 
                            		FROM chat 
                            		WHERE User_from = '".$user."' or User_to = '".$user."' 
                            		GROUP BY User_from, User_to ORDER BY max_date desc";

                            $result = mySQLi_query($conn, $sql) or die("Error query1");
                            $list_users = array();

                            while($row = mySQLi_fetch_array($result)){
                                if(strcmp($_SESSION['username'], $row['User_from']) == 0)
                                    $other = $row['User_to'];
                                else
                                    $other = $row['User_from'];

                                $key = array_search($other, $list_users);
                                if($key !== false)
                                {
                                    continue;
                                }
                                array_push($list_users, $other);

                                $sql2 = "SELECT COUNT(*) as count 
                                		FROM chat 
                                		WHERE Is_read = false and User_from = '".$other."' and User_to = '".$user."'";
                                		
                                $result2 = mySQLi_query($conn, $sql2) or die("Error query");
                                $row2 = mySQLi_fetch_array($result2);
                                $unread_count = $row2['count'];
                                echo'
                                        <td>
                                            <img class="mini-image" src="https://forums.opera.com/assets/uploads/profile/1559-profileavatar.png" alt="">
                                            <a class="name" href="view_chat.php?user_to='.$other.'">'.$other.'</a>
                                        </td>
                                        <td>'.$row['max_date'].'</td>
                                        <td id="status'.$other.'" class="text-center">';
                                            if($unread_count == 0)
                                                echo '<span class="label label-success">No Unread</span>';
                                            else
                                                echo '<span class="label label-warning">Unread ('.$unread_count.')</span>';
                                        echo '</td>
                                    </tr>
                                    ';
                            }//END while

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>




<?php
	require "footer.php";
?>


</body>
</html>