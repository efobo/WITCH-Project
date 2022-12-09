<?php

    include('config/constants.php');

    if ($_SESSION['status'] != "ruler")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the rulers for this</div>";
        header('location:'.SITEURL.'manage-ruler.php');
    }
    else {

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM adviser WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Adviser Deleted Successfully</div>";
            header('location:'.SITEURL.'manage-advisers.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Adviser</div>";
            header('location:'.SITEURL.'manage-advisers.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'manage-advisers.php');
    }
}
?>