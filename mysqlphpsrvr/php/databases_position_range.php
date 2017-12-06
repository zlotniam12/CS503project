<?php 
  //1. Create a database connection (Note: had to already create DB from MySQL)
  $dbhost = "localhost"; //Can be IP address, domain
  $dbuser = "root"; //User we are logging in as, you need to configure this in MySQL prior
  $dbpass = ""; //Configure in MySQL prior
  $dbname = "MTB_variants"; //
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname); //Handle for connection to DB
  // Test DB connection:
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() .
         " (" . mysqli_connect_error() . ")"
       ); //Quit all php code and die/break with this message
      //Note: mysqli_connect_error return either an empty string if no error or error string 
      //mysqli_connect_errno() --> if there is an error in the last transaction, function returns error number

  }

  //2. Perform database query
  //Assemble query, parse user input and assign value to input_position with ternary operator
  $start_position = isset($_POST['start_range']) ? $_POST['start_range'] : false;
  $end_position = isset($_POST['end_range']) ? $_POST['end_range'] : false;
  $query = "SELECT * ";
  $query .= "FROM variants ";
  $query .= "WHERE ";
  $query .= "position>=";
  $query .= $start_position;
  $query .= " AND position<=";
  $query .= $end_position;
  $query .= ";";
  
  echo $query;
  $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  
  //Test if there was a query error
  if (!$result) {
    die("Database  query failed.");
  }
?>

  <!DOCTYPE html PUBLIC >
  <html lang="en">
	<head></head>
	<body>
		<h1><font color="blue">Variant entries between positions: <?php echo $start_position?> and <?php echo $end_position?></font></h1>
		
		<div>
			<font size="5">Highlight by variant classification:</font>
			<form method="POST" onsubmit"this.submit(); this.reset(); return false;">
				<input type="checkbox" onclick="var my_x=5; selectifOther();"/><font size="4">SNVs</font>
				<input type="checkbox"/><font size="4">deletions</font>
				<input type="checkbox"/><font size="4">insertions</font>
				<input type="submit" value="SUBMIT"/>
			</form>
		</div>
		
		<!--Create an html table object with the output-->
		<div class="section">
			<table border="1">
				<!--tr=A row in the table-->
				<tr>
					<th bgcolor="green"><font color="red">Variant_id:</font></th>
					<th bgcolor="yellow"><font color="blue">Position:</font></th>
					<th bgcolor="purple"><font color="pink">Reference Allele:</font></th>
					<th bgcolor="blue"><font color="yellow">Alternate Allele:</font></th>
					<th bgcolor="red"><font color="green">Consequence:</font></th>
					<th bgcolor="pink"><font color="purple">Impact:</font></th>
					<th bgcolor="white">Gene:</th>
					<th bgcolor="grey"><font color="white">Variant class:</font></th>
				</tr>
		<?php
			//3. Use returned data (if any) with while loop over any rows returned
			while($variant = mysqli_fetch_assoc($result)) { //Get first row from $result and ASSIGN value to $variant array --> when NULL is assigned to $variant, loop ends; increments row pointer to next set; access elements of $row array by field name	
		?>	
			<!--tr=Create a row in html-->
			<tr>
				<td><?php echo $variant["variant_id"];?></td>
				<td><?php echo $variant["position"];?></td>
				<td><?php echo $variant["ref"];?></td>
				<td><?php echo $variant["alt"];?></td>
				<td><?php echo $variant["consequence"]; ?></td>
				<td><?php echo $variant["impact"];?></td>
				<td><?php echo $variant["gene"]?></td>
				<td><?php echo $variant["variant_class"]?></td>
			</tr>	
		<?php
			}
			
		?>
			</table>
		</div>
	</body>
  </html>
  
  <script>
	function checkifOther(){
		if(my_x == 5) {
				echo 'Success'
		}
		
		else {
				echo 'fail'
		}
	}
  </script>
  
<?php
  //4. Release returned data/resources
  mysqli_free_result($result);

  //5. Close database connection
  mysqli_close($connection); 
  //Releases the handle on the DB connection --> making handle explicit, but can be empty since implicit
?>
