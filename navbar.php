<!-- Navbar (sit on top) -->
<nav class="navbar navbar-default navbar-expand-lg navbar-top">
  <div class="navbar-inner">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" data-disabled="true">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">STARTSAW - BookSharingUniGe<i class="glyphicon glyphicon-home"></i></a>
      <a class="navbar-brand" href="category.php">Categories<i class="glyphicon glyphicon-list"></i></a>
    </div>


    <form class="navbar-form navbar-left" action="search.php?" method="get" id="bar">
      <div class="input-group">

        <input type="text" class="form-control" placeholder="Search..." name="find" required>
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit" id="SearchButton"><i class="glyphicon glyphicon-search"></i>
          </button>
          <input type="hidden" name="page" value="1" id="page">
        </div>
        
      </div>
    </form>


    <div class="collapse navbar-collapse" id="myNavbar" data-disabled="true">
      <ul class="nav navbar-nav navbar-right">
       

          <!-- END   LOGIN OR dropdown operazioni user------------------------------------- -->
        <?php
            if(isset($_SESSION['username'])){
              //DROPDOWN con le operazioni che può fare l'utente loggato nel sistema

            //recupero immagine del profilo (se presente), altrimenti assegno default
    	       require "db/mysql_credentials.php";
      			// Create connection
      			$conn = new mysqli($servername, $username, $password, $dbname);
      			// Check connection
      			if ($conn->connect_error) {
      			   die("Connection failed: " . $conn->connect_error);
      			}

            $user = $_SESSION['username'];
                  $sql2 = "SELECT COUNT(*) as count FROM chat WHERE Is_read = false and User_to = '".$user."'";
                  $result2 = mySQLi_query($conn, $sql2) or die("Error query");
                  $row2 = mySQLi_fetch_array($result2);
                  $unread_count = $row2['count'];
                  if($unread_count == 0)
                      echo '
                            <li id="all_messages">
                              <a href="chat.php"><i class="glyphicon glyphicon-comment"></i> CHAT </a>
                            </li>';
                  else//NOTIFICA NUOVI MEX NON LETTI!
                      echo '
                            <li id="all_messages">
                              <a href="chat.php"><i class="glyphicon glyphicon-comment"></i> ('.$unread_count.') Messagges 
                              </a>
                            </li>';


			       $Profile = $_SESSION['username'];/* usato anche in showprofile attenzione!*/

      			$sql = "SELECT Img
      					FROM user 
      					WHERE Username = '$Profile'";

      			$result = mySQLi_query($conn, $sql) or die("Error query");

	        while($row = mySQLi_fetch_array($result)) {
	              
	              echo'
				<li class="dropdown">
	                  <a data-toggle="dropdown" class="dropdown-toggle" > ';

	            if ($row['Img'] != null)
	                echo "<img class='profile-img' src='data:image/jpeg;base64,".base64_encode($row['Img'])."' 
	            		alt='cover'> $user <b class='caret'></b></a>";
	            else
	                echo "<img class='profile-img' src='https://bootdey.com/img/Content/user_1.jpg'>
	            	$user <b class='caret'></b></a>";

	              echo '
	                  <ul class="dropdown-menu">
	                      <li><a href="show_profile.php?user='.$user.'&page=1"><i class="glyphicon glyphicon-user"></i>Dashboard</a></li>
	                      <li class="divider"></li>

	                      <li><a href="insert_new.php"><i class="glyphicon glyphicon-edit"></i>Add book</a></li>
	                      <li class="divider"></li>

	                      <li><a href="favourite.php?page=1"><i class="glyphicon glyphicon-star"></i> Wish List</a></li>
	                      <li class="divider"></li>

	                      <li><a href="my_publications.php?page=1"><i class="glyphicon glyphicon-folder-open"></i> My Publications</a></li>
	                      <li class="divider"></li>

	                      <li><a href="setting.php"><i class="glyphicon glyphicon-wrench"></i> Settings</a></li>
	                      <li class="divider"></li>

	                      <li><a href="script/logout.php"><i class="glyphicon glyphicon-log-out"></i>Logout</a></li>
	                  </ul>
	              </li>
	              </ul>';
	              }

	             }
	                else //LOGIN
	                {
	                    echo "
	                            <li><a href='login.php'><i class='glyphicon glyphicon-log-in'></i>LOGIN</a></li>
	                          ";

	                }

          ?>
          <!-- END   LOGIN OR dropdown operazioni user------------------------------------- -->
		
		</ul>
    </div>

  </div><!-- END container -->
</nav>

