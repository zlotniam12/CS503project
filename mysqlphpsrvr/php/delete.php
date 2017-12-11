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
    <title>Variant Deletion</title>
  </head>
<body>
  <a href="CS503_page.html" target="_blank">Click here to return to the database mainpage.</a><br>
  <br/><b>Delete a variant from the database: </b>
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
  if (isset($_POST['var1']) && isset($_POST['var2']))
  {
        $query = "delete from variants ";
        $query .= "WHERE variants.position=";
        $query .= $_POST['var2'];
        $query .= " AND variants.mutation=\"";
        $query .= $_POST['var7'];
        $query .= "\";";  
        //echo $query;
  }
     $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query

  ?>
  <?php 
      //4. Release returned data/resources
    mysqli_free_result($result);
  ?>
  <b>Successfully deleted the variant</b>
  </body>
</html>

<?php
  //5. Close database connection
  mysqli_close($connection); 
  //Releases the handle on the DB connection --> making handle explicit, but can be empty since implicit
?>
