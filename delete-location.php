<?php

    include('config/constants.php');

    if ($_SESSION['status'] != "guardian")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the guards for this</div>";
        header('location:'.SITEURL.'manage-locations.php');
    }
    else {

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM location WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Location Deleted Successfully</div>";
            header('location:'.SITEURL.'manage-locations.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Location</div>";
            header('location:'.SITEURL.'manage-locations.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'manage-locations.php');
    }
}
?>