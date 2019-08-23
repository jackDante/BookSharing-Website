<!DOCTYPE html>
<html lang="en">


<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("location: index.php");
    }
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

      <link rel="stylesheet" media="all" href="css/common.css" />
      <link rel="stylesheet" media="all" href="css/login.css" />

      <script src="js/common.js"></script>
      <script src="js/login.js"></script>

</head>


<!-- NAVBAR ----------------------------------------->
<?php
    require "navbar.php";
?>



<!-- center container ----------------------------------------->
<div class="container">
<!-- logIn ----------------------------------------------------------------------------------- -->
<div class="body" id="logIn">
    <form action="script/login_user.php" method="POST" name="login" class="sky-form">
        <header>Please sign in.</header>

        <fieldset>
            <section>
                <label class="input" >
                    <p class='errorLogin' id = "errorLoginBox"><br></p>
                </label>
            </section>

            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-user"></span>
                    Username
                </label>
                <label class="input">
                    <input type="text" onclick="removeError()" onkeyup="removeError()" placeholder="Username" id="usernameLog" name="usernameLog">
                </label>
            </section>

            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-lock"></span>
                    Password
                </label>
                <label class="input">
                    <input type="password" onclick="removeError()" onkeyup="removeError()" placeholder="Password" id="pswLog" name="pswLog">
                    <input type="hidden" id="pswEncryptLog" name="pswEncryptLog">
                </label>
            </section>

        </fieldset>

        <footer>
            <button type="button" onClick="ajaxcheckPassword()" class="button">Submit</button>
        </footer>

        <fieldset>
            <section>
                <p>Not registered? Sign up <a href="#" onClick="show('signUpForm');hide('logIn');">here</a></p>
            </section>
        </fieldset>

    </form>
</div><!-- end sign-in -->











<!-- signUp ----------------------------------------------------------------------------------- -->
<div class="body" id="signUpForm">
    <form action="script/signup.php" method="POST" name="signupform" class="sky-form" enctype="multipart/form-data">
        <header>Registration form</header>

        <fieldset>
            <section>
                <label class="input" >
                    <p class='errorLogin' id="errorSignupBox"><br></p>
                </label>
            </section>
            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-user"></span>
                    Username
                </label>
                <label class="input">
                    <input type="text" placeholder="Username" id="userSign" name="userSign" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    <b class="tooltip tooltip-bottom-right">Only characters and numbers</b>
                </label>
            </section>

            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-envelope"></span>
                    Email
                </label>
                <label class="input">
                    <input type="text" placeholder="Email address" id="emailSign" name="emailSign" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    <b class="tooltip tooltip-bottom-right">Needed to verify your account</b>
                </label>
            </section>

            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-lock"></span>                   
                    Password
                </label>
                <label class="input">
                    <input type="password" placeholder="Password" id="pswSign" name="pswSign" oninput="check_pwd5()" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    <progress class="w3-green" id="score" value="0" max="4"  style="width: 100%; height: 10px;"></progress>
                </label>
            </section>
            <input type="hidden" id="pswEncryptSign" name="pswEncryptSign">

            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-lock"></span>
                    Password Confirm
                </label>
                <label class="input">
                    <input type="password" placeholder="Confirm password" id="pswConfirmSign" name="pswConfirmSign" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>
            </section>
        </fieldset>


        <fieldset>
            <section>
                <label class="input">
                    <span class="glyphicon glyphicon-calendar"></span>
                    Date of Birth
                </label>
                    <input onclick="removeErrorSignup()" type="date" id="dateSign" name="dateSign">
                </label>
            </section>
        </fieldset>


        <fieldset>
            <div class="row">
                <section class="col col-6">
                    <label class="input">
                        <span class="glyphicon glyphicon-pencil"></span>
                        Name
                    </label>
                    <label class="input">
                        <input type="text" placeholder="First name" id="nameSign" name="nameSign" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input">
                        <span class="glyphicon glyphicon-pencil"></span>
                        Surname
                    </label>
                    <label class="input">
                        <input type="text" placeholder="Last name" id="surnameSign" name="surnameSign" onclick="removeErrorSignup()" onkeyup="removeErrorSignup()">
                    </label>
                </section>
            </div>

            <section>
                <label class="input">
                    Gender
                </label>
                <label class="select">
                    <select  onchange="removeErrorSignup()" name="gender" id="gender">
                        <option value="not-selected" selected disabled>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <i></i>
                </label>
            </section>


            <section>
                <label class="input">
                    City of Birth
                </label>
                <label class="select">
                    <select onclick="removeErrorSignup()" name="citySign" id="citySign">
                        <option value="not-selected" selected disabled>City</option>
						<?php

                        require "db/mysql_credentials.php";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT ID, Name 
                                FROM city";
                        $result = $conn->query($sql);

                        while($row = $result->fetch_assoc()) {
                            $city = $row['Name'];
                            $id = $row['ID'];
                            if(strlen($city) != 0) {
                                echo "<option value='" . $city . "'>" . $city . "</option>";
                            }
                        }

                        $conn->close();

                        ?>
                    </select>
                    <i></i>
                </label>
            </section>


            <section>
                <label class="input">
                    Profile Picture (optional)
                </label>
                <label class="input">
                    <input type="file" accept="image/*" id="image" name="image" onclick="removeErrorSignup()">
                </label>
            </section>
   
        </fieldset>            

			
			
            <section>
                <label class=""><input onclick="removeErrorSignup()"  type="checkbox" name="checkbox" id="checkboxSign" checked><i></i>     I agree to the Terms of Service</label>
            </section>
        </fieldset>


        <footer>
            <button type="button" onclick="checkSignUp()" class="button">Submit</button>
        </footer>


        <fieldset>
            <section>
                <p>Already registered? Log in <a href="#" onClick="show('logIn');hide('signUpForm');">here</a></p>
            </section>
        </fieldset>
    
    </form>
    
</div><!-- END signUp -->

</div><!-- racchiude tutto -->

 
</body>
</html>