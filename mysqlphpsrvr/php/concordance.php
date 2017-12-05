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

?>

<html lang="en">
  <head>
    <title>Databases</title>
  </head>
<body>
<?php
      $query = "SELECT drug_abrv, full_name ";
      $query .= "FROM DST ";
      $query .= "GROUP BY drug_abrv, full_name;";
      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      if (!$result) {
        die("Database  query failed.");
      }
?>
    <b>Concordance of TB drug names and abbreviations currently available in our database: </b>
<ul>
<?php      
      //3. Use returned data (if any) with while loop over any rows returned
      while($variant = mysqli_fetch_assoc($result)) { //Get first row from $result and ASSIGN value to $variant array --> when NULL is assigned to $variant, loop ends; increments row pointer to next set; access elements of $row array by field name
        //Output data from each row
//	var_dump($variant); //dumps variant info to screen
    ?>
      <!--Creates list items in html as bullet points in browser-->
      <li><?php echo $variant["drug_abrv"];  
                echo ": ";
                echo $variant["full_name"]; ?></li>
    <?php
      }
    ?>
    </ul> <!--Close the unordered list -->

    <?php 
      //4. Release returned data/resources
      mysqli_free_result($result);
    ?>

  </body>
</html>

<?php
  //5. Close database connection
  mysqli_close($connection); 
  //Releases the handle on the DB connection --> making handle explicit, but can be empty since implicit
?>
