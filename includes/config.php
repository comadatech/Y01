<?php
$servername = "localhost";
$username = "internalsql";
$password = "blackjack123!";
$dbname = "Y01";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  exit();
}
//echo "Connected successfully";
?>