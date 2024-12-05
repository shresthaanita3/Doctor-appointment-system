<?php
// Database connection credentials (replace with your own secure values)
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "doctor_appointment_system";

$con = mysqli_connect($hostname, $username, $password, $databaseName);


// Create the user table with proper data types, security considerations, and error handling
$create = "CREATE TABLE IF NOT EXISTS user (
    sn INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL
);";
mysqli_query($con,$create);
?>