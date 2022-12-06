<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - W.I.T.C.H. ♥</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>

            <br><br>

            <?php
            
                if (isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if (isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }

            ?>
            
            <br>

            <!-- Login Form Starts -->
            <form action="" method="POST" class="text-center">
                Choose your status: <br>
                <select name="status">
                    <option value="ruler">Ruler</option>
                    <option value="adviser">Adviser</option>
                    <option value="guardian">Guardian</option>
                </select>
                <br> <br>

                Username: <br>
                <input type="text" name="username" placeholder="Enter your username"> <br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter your password"> <br><br>

                <input type="submit" name="submit" value="Log in" class="btn-primary">
                <br><br>
            </form>
            <!-- Login Form Ends -->

            <p class="text-center">Created by <a href="https://github.com/efobo">efobo</a>♥<a href="https://github.com/AngelinaDementeva">demapage</a></p>
        </div>
    </body>
</html>

<?php

    if (isset($_POST['submit']))
    {
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        $sql = "SELECT * FROM $status WHERE username='$username' AND password='$password'";
        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $count = mysqli_num_rows($res);

            if ($count == 1)
            {
                
                $_SESSION['user'] = $username;
                $_SESSION['status'] = $status;

                $rows = mysqli_fetch_assoc($res);
                $_SESSION['id'] = $rows['id'];
                $_SESSION['name'] = $rows['name'];
                $_SESSION['id_universe'] = $rows['id_universe'];
                

                header('location:'.SITEURL.'admin/');
            }
            else
            {
                $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
                header('location:'.SITEURL.'admin/login.php');
            }
        }
    }


?>