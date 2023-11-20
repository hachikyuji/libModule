<?php

$servername = "localhost";
$username = "root";
$password = "password";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection Error: ". $conn->connect_error);
}
 echo "Connected Successfully";
?>