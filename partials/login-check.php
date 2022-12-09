<?php

    if (!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Log In to access Main Page</div>";
        header('location:'.SITEURL.'login.php');
    }

?>