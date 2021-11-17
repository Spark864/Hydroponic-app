<?php
$MyUsername = "root";  // enter your username for mysql
$MyPassword = "uoit";  // enter your password for mysql
$MyHostname = "localhost";      // this is usually "localhost" unless your database resides on a different server
$MyDatabase = "greenhouse";
$con = mysqli_connect($MyHostname , $MyUsername, $MyPassword, $MyDatabase);


//$selected = mysqli_select_db($con, "greenhouse"); //Enter your database name here 

if (!$con)
  {
  //die('Could not connect: ' . mysqli_error($con));
  echo 'Failed to connect to MySQL';
  }
else{
    echo 'Connection sucessful! ';
}

?>