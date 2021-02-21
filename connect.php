<?php
/* Connects to MySQL Database */

// Login Credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "P2S";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}