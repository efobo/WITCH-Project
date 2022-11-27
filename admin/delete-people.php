<?php

    include('../config/constants.php');

    if ($_SESSION['status'] != "adviser")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the advisers for this</div>";
        header('location:'.SITEURL.'admin/manage-people.php');
    }
    else {

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM people WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Person Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-people.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Person</div>";
            header('location:'.SITEURL.'admin/manage-people.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-people.php');
    }
}
?>