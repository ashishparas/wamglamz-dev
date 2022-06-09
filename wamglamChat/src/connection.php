<?php 
@session_start();
@date_default_timezone_set("UTC");
$host = "localhost";
$user = "wamglamz_user";
$pass = "H5OW4bHU*[2*";
$database = "wamglamz_DB";

date_default_timezone_set('UTC');
$con = mysqli_connect($host, $user, $pass, $database);
mysqli_set_charset($con,"utf8mb4");
if(!$con)
{
  die('Could not connect: ' . mysqli_error());
}

?>
