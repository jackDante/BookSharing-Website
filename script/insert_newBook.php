<?php

require "../db/mysql_credentials.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";



$author = $conn->real_escape_string($_POST['author']);
$author = filter_var($author, FILTER_SANITIZE_SPECIAL_CHARS);

$title = $conn->real_escape_string($_POST['title']);
$title = filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS);

$description = $conn->real_escape_string($_POST['description']);
$description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);

$pages = (int)$_POST['pages'];
$pages = filter_var($pages, FILTER_SANITIZE_NUMBER_INT);

$ed = (int)$_POST['edition'];
$ed = filter_var($ed, FILTER_SANITIZE_NUMBER_INT);

$isbn = $conn->real_escape_string($_POST['isbn']);
$isbn = filter_var($isbn, FILTER_SANITIZE_SPECIAL_CHARS);


//Get the content of the image and then add slashes to it
$imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));

$n_categories = $_POST['number_of_categories'];

$date_of_pubblication = date('Y/m/d', time());

$place = $conn->real_escape_string($_POST['place']);
$place = filter_var($place, FILTER_SANITIZE_SPECIAL_CHARS);

$price = $_POST['price'];
$price = filter_var($price, FILTER_VALIDATE_FLOAT);



session_start();

if(!isset($_SESSION['username'])) {
    header("location: index.php");
}
$user = $_SESSION['username'];




#Insert Book Information
$sql = "INSERT INTO book (ID, Author, Title, Description, PageNum, Edition, ISBN, Cover) 
        VALUES (NULL, '".$author."', '".$title."', '".$description."', '".$pages."', '".$ed."', '".$isbn."', '".$imgData."');";

$id = 0;

if (mysqli_query($conn, $sql)) {
    $id = mysqli_insert_id($conn);
    echo "New record created successfully. Last inserted ID is: " . $id;
} else {
    echo "Error: ". mysqli_error($conn);
}

/* Prepare an SQL statement for execution  
$stmt = $conn->prepare('INSERT INTO book (ID, Author, Title, Description, PageNum, Edition, ISBN, Cover) 
                        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)
                        ');
$stmt->bind_param('sssiisb', $author,$title,$description,$pages,$ed,$isbn,$imgData);

$id = 0;

#Insert Book Information
if ($stmt->execute()) {
    $id = mysqli_insert_id($conn);
    echo "New record created successfully. Last inserted ID is: " . $id;
} else {
    echo "Error: ". mysqli_error($conn);
}
*/



#Insert in Concern
for($i = 1; $i <= $n_categories; $i++)
{
    $CatPostName = "cat".$i;
    if(isset($_POST[$CatPostName])) {
        $category = $_POST[$CatPostName];

        $sql = "SELECT distinct ID FROM category where name = '" . $category . "'";
        $result_cat = $conn->query($sql);

        $id_cat = 0;

        while ($row_cat = $result_cat->fetch_assoc()) {
            $id_cat = $row_cat['ID'];
        }
        $sql2 = "INSERT INTO concern (Book, Category)
      VALUES ('" . $id . "', '" . $id_cat . "')";

        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully concern !";
        } else {
            die("Error: " . $sql2 . "<br>" . $conn->error);
        }

    }
}


#Insert in Insertion
/*
$sql3 = "INSERT INTO insertion (ID, User_offerer, Material_offered, Date_of_pubblication, Place, Price) 
        VALUES (NULL, '".$user."', '".$id."', '".$date_of_pubblication."', '".$place."', '".$price."');";

if ($conn->query($sql3) === TRUE) {
    echo "New record created successfully insertion";
} else {
    die("Error: " . $sql3 . "<br>" . $conn->error);
}

header("location: ../pageBook.php?Id=".$id."");
*/

/* Prepare an SQL statement for execution */
$stmt = $conn->prepare('INSERT INTO insertion (ID, User_offerer, Material_offered, Date_of_pubblication, Place, Price) 
                        VALUES (NULL, ?,?,?,?,?)
                        ');
$stmt->bind_param('sissd', $user,$id,$date_of_pubblication,$place,$price);


if ($stmt->execute()) {
    echo "New record created successfully insertion !!!";
} else {
    die("Error: " . $stmt . "<br>" . $conn->error);
}

header("location: ../PageBook.php?Id=".$id."");


?>
