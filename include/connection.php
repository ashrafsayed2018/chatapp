<?php
ob_start();
session_start();
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "chatapp";

// Create connection
$conn = mysqli_connect($servername, $user, $password,$dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Kuwait');
$date = date('m/d/Y h:i:s', time());
?>