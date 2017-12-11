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
    <title>Insert Variant</title>
  </head>
<body>
<a href="CS503_page.html" target="_blank">Click here to return to the database mainpage.</a><br>
<br/><b>Input a new variant into the database: </b>
    <br><i>Fill out the following fields: </i></br>
    

    <form name="form" action="" method="post">
      <br><i> Chromosome:</i></br>
      <input type="text" name="var1" id="var1" value="1">
      <br><i>Position: </i></br>
      <input type="text" name="var2" id="var2" value="1">
	  <br><i> Reference Base:</i></br>
      <input type="text" name="var3" id="var3" value="A">
      <br><i>Alternate Base: </i></br>
      <input type="text" name="var4" id="var4" value="G">
      <br><i> Mutation Consequence:</i></br>
      <input type="text" name="var5" id="var5" value="Frame Shift">
      <br><i>Gene: </i></br>
      <input type="text" name="var6" id="var6" value="gyrA">
      <br><i>Mutation: </i></br>
      <input type="text" name="var7" id="var7" value="S325L">
      <button type="submit" name="submit">SUBMIT</button>

    </form>
    
<?php
// echo "a";
if (isset($_POST['var1']) && isset($_POST['var2']))
{
	// echo 'b';
      $query = "INSERT INTO variants";
      $query .= "(variant_id,chromosome,position,ref,alt,consq,gene,mutation)";
      $query .= " VALUES(FLOOR(1 + (RAND() * 9999)), \"";
      $query .= $_POST['var1'];
      $query .= "\", \"";
      $query .= $_POST['var2'];
      $query .= "\", \"";
      $query .= $_POST['var3'];
      $query .= "\", \"";
      $query .= $_POST['var4'];
      $query .= "\", \"";
      $query .= $_POST['var5'];
      $query .= "\", \"";
      $query .= $_POST['var6'];
      $query .= "\", \"";
      $query .= $_POST['var7'];
      $query .= "\");";
	  
}

      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      //if (!$result) {
       // die("Database  query failed.");
     // }

      $query = "SELECT * ";
      $query .= "FROM variants ";
      $query .= "WHERE variants.position=";
      $query .= $_POST['var2'];
      $query .= " AND variants.mutation=\"";
      $query .= $_POST['var7'];
      $query .= "\";";
      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
     // if (!$result) {
      //  die("Database  query failed.");
      //}
?>
    <b>Successful variant insertion will display below:</b>
<ul>
<?php      
      //3. Use returned data (if any) with while loop over any rows returned
      while($variant = mysqli_fetch_assoc($result)) { //Get first row from $result and ASSIGN value to $variant array --> when NULL is assigned to $variant, loop ends; increments row pointer to next set; access elements of $row array by field name
        //Output data from each row
//	var_dump($variant); //dumps variant info to screen
    ?>
      <!--Creates list items in html as bullet points in browser-->
      <li><?php
                echo $variant["variant_id"];  
                echo ", "; 
                echo $variant["chromosome"];  
                echo ", ";
                echo $variant["position"];  
                echo ", ";
                echo $variant["ref"];
                echo ", ";
                echo $variant["alt"];  
                echo ", ";
                echo $variant["consq"];  
                echo ", ";
                echo $variant["gene"];  
                echo ", ";
                echo $variant["mutation"]; ?></li>
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
