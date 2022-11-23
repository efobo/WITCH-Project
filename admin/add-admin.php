<?php include('partials/menu.php'); ?>


<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            if (isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your username">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-danger">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>

<?php
    // Process the value from form and save it in database
    // Check if the button is pressed
    if (isset($_POST['submit']))
    {
        // echo "Button Clicked";
        
        // Get the Data from form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        // SQL Query to save the Data into Database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        
        // Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // Check whether the (Query is Executed) Data is inserted or not
        // and display appropriate message
        if ($res) 
        {
            $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else
        {
            $_SESSION['add'] = "<div class='error'>Faild to Add Admin</div>";
            header("location:".SITEURL."admin/add-admin.php");
        }
    }
    
?>