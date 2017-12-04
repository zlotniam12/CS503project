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
      $query = "SELECT isolate ";
      $query .= "FROM resistance_profile R";
      $query .= "WHERE R.drug_id = \"";
      $query .= $_GET['drug_abrv'];
      $query .= "\";";// IN (SELECT drug_id";
     // $query .= "FROM DST";
     // $query .= "WHERE DST.drug_abrv=";
     // $query .= "\"fq\");";
      $result = mysqli_query($connection, $query); //Create mysql resource result set -a collection of database rows - to catch output of query
  //Test if there was a query error
      if (!$result) {
        die("Database  query failed.");
      }
?>
