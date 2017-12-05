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

<?php
/*  //2. Perform database query
  //Assemble query
  $query = "SELECT * ";
  $query .= "FROM DST;";
  $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
  if (!$result) {
    die("Database  query failed.");
  }
*/
?>

<!DOCTYPE html PUBLIC >

<html lang="en">
  <head>
    <title>Databases</title>
  </head>
  <body>
    <b>Search for isolates resistant/susceptible to a particular drug: </b>
    <br><i>Input drug name abbreviation in the box below: </i></br>
    <form name="form" action="" method="post">
    <input type= "checkbox" name="phenotype" value="1"/>susceptible only<br/>
    <input type= "checkbox" name="phenotype" value="2"/>mono <br/>
    <input type="text" name="drug_abrv" id="drug_abrv" value="">
    <button type="submit" name="submit">SUBMIT</button>
    </form>
    
    <?php

if (isset($_POST['drug_abrv']))
{
  if ($_POST['phenotype'] == "2")
     {
      $query = "SELECT isolate, R_S ";
      $query .= "FROM resistance_profile R ";
      $query .= "WHERE R.drug_id NOT IN (SELECT drug_id ";
      $query .= "FROM DST ";
      $query .= "WHERE DST.drug_abrv<>\"";
      $query .= $_POST['drug_abrv'];
      $query .= "\") GROUP BY R_S, isolate;";
      }
  elseif ($_POST['phenotype'] == "1")
     {
      $query = "SELECT isolate, R_S ";
      $query .= "FROM resistance_profile R ";
      $query .= "WHERE R.R_S = \"S\" "; 
      $query .= "AND R.drug_id IN (SELECT drug_id ";
      $query .= "FROM DST ";
      $query .= "WHERE DST.drug_abrv=\"";
      $query .= $_POST['drug_abrv'];
      $query .= "\") GROUP BY R_S, isolate;";
      }
   elseif (!(isset($_POST['phenotype'])))
     {
      $query = "SELECT isolate, R_S ";
      $query .= "FROM resistance_profile R ";
      $query .= "WHERE R.drug_id IN (SELECT drug_id ";
      $query .= "FROM DST ";
      $query .= "WHERE DST.drug_abrv=\"";
      $query .= $_POST['drug_abrv'];
      $query .= "\") GROUP BY R_S, isolate;";
      }
}

      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      if (!$result) {
        die("Database  query failed.");
      }
?>
    <!--Create an unordered list in html -->
<ul>
<?php      
      //3. Use returned data (if any) with while loop over any rows returned
      while($variant = mysqli_fetch_assoc($result)) { //Get first row from $result and ASSIGN value to $variant array --> when NULL is assigned to $variant, loop ends; increments row pointer to next set; access elements of $row array by field name
        //Output data from each row
//	var_dump($variant); //dumps variant info to screen
    ?>
      <!--Creates list items in html as bullet points in browser-->
      <li><?php echo $variant["isolate"];  
                echo ", ";
                echo $variant["R_S"]; ?></li>
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
