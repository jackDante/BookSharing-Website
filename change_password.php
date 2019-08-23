<!DOCTYPE html>
<html lang="en">


<?php
    session_start();
    $_SESSION['PrevPage'] ="setting.php";
?>


<head>
    <title>STARTSAW</title>
    <meta charset="utf-8">
    <!-- icon webpage ----------------------------------------->
    <link rel="icon" href="favicon.ico" type="image" sizes="16x16">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" media="all" href="css/footer.css" />
    <link rel="stylesheet" media="all" href="css/common.css" />
    <link rel="stylesheet" media="all" href="css/login.css" />

    <script src="js/common.js"></script>
    <script src="js/changePassword.js"></script>

    
    <!-- new message? sse utente è loggato-->
    <?php
        if(isset($_SESSION['username'])) {
            echo '<script src="js/message_updates.js"></script>';
        }
    ?>

</head>


<body>

    <?php
        require "navbar.php";
    ?>

<?php

if(isset($_SESSION['username'])){

    echo'
    <div class="backimg">
        <div class="body" id="settings">
            <form action="script/changePassword.php" method="POST" name="changePasswordForm" class="sky-form" enctype="multipart/form-data">
                <header>Change Password</header>';

    echo '
    <fieldset>
        <section>
            <label class="input" >
                <p class="errorLogin" id="errorSettingsBox"><br></p>
            </label>
        </section>
        <section>
            <label class="input">
                Old Password
            </label>
            <label class="input">
                <input type="password" id="oldPassChange" name="oldPassChange" onclick="removeErrorChange()" onkeyup="removeErrorChange()" value="">
            </label>
        </section>

        
        <section>
            <label class="input">
                New Password
            </label>
            <label class="input">
                <input type="password" id="newPassChange" name="newPassChange" onclick="removeErrorChange()" onkeyup="removeErrorChange()" value="">
                <input type="hidden" id="pswEncryptChange" name="pswEncryptChange" value="">
            </label>
        </section>
        

        <section>
            <label class="input">
                Repeat New Password
            </label>
            <label class="input">
                <input type="password" id="repeatNewPassChange" name="repeatNewPassChange" onclick="removeErrorChange()" onkeyup="removeErrorChange()" value="">
            </label>
        </section>

    </fieldset>

    <footer>
        <button type="button" onclick="checkPassword()" class="button">UPDATE</button>
    </footer>

</form>
<br><br>
</div>
</div>';
}
else
    header("location: index.php");
	
?>


    <?php
        require "footer.php";
    ?>


</body>
</html>
