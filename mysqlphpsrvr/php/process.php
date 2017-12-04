<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'MTB_variants' ;


//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn -> connect_error){
	//echo 'FUCKKKKK';
	die('connection failed: ' / $conn->connect_error);
}

$option = isset($_POST['Drug']) ? $_POST['Drug'] : false;
$sql = "SELECT " . $option . " FROM DST";
$result = $conn->query($sql);
#print $sql;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row[$option]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();

?>
