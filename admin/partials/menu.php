<?php 
    include('../config/constants.php'); 
    include('login-check.php');
?>


<html>
    <head>
        <title> W.I.T.C.H. ♥ - Home page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="icon" href="../img/ico.ico">
    </head>

    <body>
        <!-- Menu Section Starts -->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-world.php">World</a></li>
                    <li><a href="manage-government.php">Government</a></li>
                    <li><a href="manage-nations.php">Nations</a></li>
                    <li><a href="manage-politics.php">Politics</a></li>
                    <li><a href="manage-wars.php">War</a></li>
                    <!-- Подавить мятеж, война с другим миром -->
                    <li><a href="logout.php">Log out</a></li>
                </ul>
            </div>
           
        </div>
        <!-- Menu Section Ends -->