<?php

    include('config/constants.php');

    if ($_SESSION['status'] != "guardian")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the guards for this</div>";
        header('location:'.SITEURL.'manage-portals.php');
    }
    else {
    

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM portal WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Portal Deleted Successfully</div>";
            header('location:'.SITEURL.'manage-portals.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Portal</div>";
            header('location:'.SITEURL.'manage-portals.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'manage-portals.php');
    }
}
?>