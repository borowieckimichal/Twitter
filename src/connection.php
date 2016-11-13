<?php

$servername = 'localhost';
$username = 'root';
$password = 'CodersLab';
$basename = 'Twitter';

$conn = new mysqli($servername, $username, $password, $basename);
if ($conn->connect_error) {
    die("Connection failed: $conn->connect_error");
} 

