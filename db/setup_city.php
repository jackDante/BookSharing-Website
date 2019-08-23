<?php

require "mysql_credentials.php";

// Create new connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//$handle = fopen("comuni.csv", "r");


$row = 1;
if (($handle = fopen("comuni.CSV", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data[0]);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $city = mysqli_real_escape_string($conn, trim($data[$c]));
                    $sql = "INSERT INTO city (ID, Name) 
                                VALUES (NULL, '".$city."');";

                    if (mysqli_query($conn, $sql)) {
                        echo "EXECUTED\n";
                    } else {
                        echo "<br>".$sql."<br>";
                        echo "Error: ". mysqli_error($conn);
                    }
                }
  }
  fclose($handle);
}

/*
while(($filesop = fgetcsv($handle, 1000, ",")) !== false){

        $city = mysqli_real_escape_string($conn, trim($filesop[0]));

        $sql = "INSERT INTO city (ID, Name) 
                VALUES (NULL, '".$city."');";

        if (mysqli_query($conn, $sql)) {
            echo "EXECUTED";
        } else {
            echo "<br>".$sql."<br>";
            echo "Error: ". mysqli_error($conn);
        }
}

    fclose($handle);
*/
$conn->close();
?>