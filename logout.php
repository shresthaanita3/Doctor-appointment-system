<?php
session_start();
if (session_destroy()) {
    header('location: index.php');
    exit(); // Make sure to exit after redirection
}
?>
