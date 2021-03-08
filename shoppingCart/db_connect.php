<?php
# I create a PHP Data Object to work with our DB
# Using a PDO allows the same PHP code to work with
# multiple types of DBs.
# Make the userid and password constants
DEFINE ('DB_USER', 'student');
DEFINE ('DB_PASSWORD', 'sam465235');
 
# Defines the data source name which is MySQL, local
# and the DB to use
$dsn = 'mysql:host=localhost;dbname=cart';
 
# Try to connect and if we get an error display it
# and call for an error page to load
try{
  $db = new PDO($dsn, DB_USER, DB_PASSWORD);
} catch (PDOException $e){
  $err_msg = $e->getMessage();
  include('db_error.php');
  exit();
}
 ?>