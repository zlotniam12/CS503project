<?php
//Author: Alyssa Zlotnicki
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
    <title>Drug Input</title>
  </head>
<body>
<a href="CS503_page.html" target="_blank">Click here to return to the database mainpage.</a><br>
<br/><b>Input a new drug and its abbreviation into the database: </b>
    <br><i>Input drug name abbreviation in the box below: </i></br>
    <form name="form" action="" method="post">
    <input type="text" name="drug_abrv" id="drug_abrv" value="">
    <br><i>Input full name of drug in the box below: </i></br>
    <input type="text" name="full_name" id="full_name" value="">
    <button type="submit" name="submit">SUBMIT</button>
    </form>
    
<?php

if (isset($_POST['drug_abrv']) && isset($_POST['full_name']))
{
      $query = "INSERT INTO DST ";
      $query .= "(drug_id, full_name, drug_abrv)";
      $query .= " VALUES(FLOOR(1 + (RAND() * 9999)), \"";
      $query .= $_POST['full_name'];
      $query .= "\", \"";
      $query .= $_POST['drug_abrv'];
      $query .= "\");";
}

      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      if (!$result) {
        die("Database  query failed.");
      }

      $query = "SELECT * ";
      $query .= "FROM DST ";
      $query .= "WHERE DST.full_name=\"";
      $query .= $_POST['full_name'];
      $query .= "\" AND DST.drug_abrv=\"";
      $query .= $_POST['drug_abrv'];
      $query .= "\";";

      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      if (!$result) {
        die("Database  query failed.");
      }
?>
    <b>Successful DST insertion will display below:</b>
<ul>
<?php      
      //3. Use returned data (if any) with while loop over any rows returned
      while($variant = mysqli_fetch_assoc($result)) { //Get first row from $result and ASSIGN value to $variant array --> when NULL is assigned to $variant, loop ends; increments row pointer to next set; access elements of $row array by field name
        //Output data from each row
//	var_dump($variant); //dumps variant info to screen
    ?>
      <!--Creates list items in html as bullet points in browser-->
      <li><?php 
                echo $variant["drug_id"];  
                echo ", ";
                echo $variant["full_name"];  
                echo ", ";
                echo $variant["drug_abrv"]; ?></li>
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
