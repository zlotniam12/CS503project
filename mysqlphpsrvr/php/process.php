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

$sql = "Select R.isolate, R.R_S, I.Lineage, I.Metadata, D.full_name, D.drug_abrv from resistance_profile R inner join isolates I inner join DST D on R.isolate = I.isolate and R.drug_id = D.drug_id where R.R_S = '" . $option . "'";
//echo $sql;

$result = $conn->query($sql);
#print $sql;

?>


<html lang="en">
	<head></head>
		<body background='tb.jpg' height="150px" width="150px" border="1px" alt=""/ align="center">
			<h1><font color = 'red'>Isolates and their mutations which have the corresponding phenotype</font></h1>
			<div class="section">
				<table border="1">
				<!--tr=A row in the table-->
					<tr>
						<th bgcolor="orange"><font color="green">Isolate</font></th>
						<th bgcolor="yellow"><font color="blue">Resistant/Susceptible</font></th>
						<th bgcolor="purple"><font color="yellow">Lineage</font></th>
						<th bgcolor="blue"><font color="white">Metadata</font></th>
						<th bgcolor="red"><font color="black">Full Name</font></th>
						<th bgcolor="pink"><font color="grey">Drug Abbreviation</font></th>
					</tr>


<?php
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

?>
			<tr>
				<td bgcolor="orange"><font color="green"><?php echo $row["isolate"];?></td>
				<td bgcolor="yellow"><font color="blue"><?php echo $row["R_S"];?></td>
				<td bgcolor="purple"><font color="yellow"><?php echo $row["Lineage"];?></td>
				<td bgcolor="blue"><font color="white"><?php echo $row["Metadata"];?></td>
				<td bgcolor="red"><font color="black"><?php echo $row["full_name"]; ?></td>
				<td bgcolor="pink"><font color="grey"><?php echo $row["drug_abrv"];?></td>
			</tr>
<?php
        //echo $row['isolate']. "\t". $row['R_S']. "\t" . $row['Lineage'] ."\t" .$row['Metadata'] ."\t" .$row['full_name'] ."\t". $row['drug_abrv'] ."<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
//select R.isolate, R.drug_id, R.R_S, I.Lineage, I.Metadata, D.full_name, D.drug_abrv from resistance_profile R inner join isolates I inner join DST D where R.isolate = I.isolate AND R.drug_id = D.drug_id and R.R_S = 'R';
?>

</html>