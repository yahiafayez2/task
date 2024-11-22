<?php
$servername = "localhost";
$username = "supenmdw_kokou"; 
$password = "}%q@WuN+ikgo";   
$dbname = "supenmdw_koko"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>