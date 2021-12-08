<?php
require("db_creds.php");

// Create database connection
mysqli_connect($servername,$username,$password,$database);

// Check connection
if(mysqli_connect_error())
{
 echo "Connection establishing failed!";
}
else
{
 echo "Connection established successfully.";
}
?>