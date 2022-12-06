<?php

    include('../config/constants.php');

    if ($_SESSION['status'] != "adviser")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the advisers for this</div>";
        header('location:'.SITEURL.'admin/manage-rioters.php');
    }
    else {

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM rioter WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Rioter Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-rioters.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Rioter</div>";
            header('location:'.SITEURL.'admin/manage-rioters.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-rioters.php');
    }
}
?>