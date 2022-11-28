<?php
    session_start();

    define('SITEURL', 'http://localhost/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD','root');
    define('DB_NAME', 'witch');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));// Database Connection

    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); // Selecting Database
?>