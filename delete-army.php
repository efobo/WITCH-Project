<?php

    include('config/constants.php');

    if ($_SESSION['status'] != "adviser")
    {
        $_SESSION['delete'] = "<div class='error'>Sorry, you don't have access to change this data. Ask one of the advisers for this</div>";
        header('location:'.SITEURL.'manage-army.php');
    }
    else {

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM army WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res)
        {
            $_SESSION['delete'] = "<div class='success'>Soldier Deleted Successfully</div>";
            header('location:'.SITEURL.'manage-army.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Soldier</div>";
            header('location:'.SITEURL.'manage-army.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'manage-army.php');
    }
}
?>