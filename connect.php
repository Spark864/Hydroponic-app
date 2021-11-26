<?php
$url = parse_url("postgres://nhchgncqtdohmw:44f34a07049a26867f87219d2591a73ba66b665048b3c11b6e9b8e10269c476a@ec2-54-147-93-73.compute-1.amazonaws.com:5432/d29h2tvqmjhdqj");
$url["path"]=ltrim($url["path"],"/");
$MyUsername = $url["user"];  // enter your username for mysql
$MyPassword = $url["pass"];  // enter your password for mysql
$MyHostname = $url["host"];      // this is usually "localhost" unless your database resides on a different server
$MyDatabase = $url["path"];
$MyPort = $url["port"];
$con = pg_connect("host=$MyHostname dbname=$MyDatabase user=$MyUsername password=$MyPassword port=$MyPort");


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