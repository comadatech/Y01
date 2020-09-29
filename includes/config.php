<?php
$dbservername = "localhost";
$dbusername = "internalsql";
$dbpassword = "blackjack123!";
$dbname = "Y01";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  exit();
}
//echo "Connected successfully";
?>