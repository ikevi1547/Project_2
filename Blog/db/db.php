<?php

$servername = "localhost";
$username = "id6909662_kevin";
$password = "ktvtNNrrWEOFq765";
$dbname = "blog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} ?>