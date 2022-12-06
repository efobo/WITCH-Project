<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Army</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "adviser")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the adviser for this</div>";
            }
            else
            { 
        
                if (isset($_SESSION['msg']))
                {
                    echo $_SESSION['msg'];
                    echo '<br><br>';
                    unset($_SESSION['msg']);
                }

                if (isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    echo '<br><br>';
                    unset($_SESSION['add']);
                }

                if (isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    echo '<br><br>';
                    unset($_SESSION['upload']);
                }
        ?>


        <!-- Add Army Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Choose Person:</td>
                    <td>
                        <select name="id_person">
                        <?php
                            
                            $sql = "SELECT * FROM people";

                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0)
                            {
                                while ($row = mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $id_universe = $row['id_universe'];

                                    $sql2 = "SELECT * FROM universe WHERE id=$id_universe";
                                    $res2 = mysqli_query($conn, $sql2);
                                    $count2 = mysqli_num_rows($res2);
                                    if ($count2 == 1)
                                    {
                                        $row2 = mysqli_fetch_assoc($res2);
                                        $universe = $row2['name'];
                                    }
                                    else
                                    {
                                        $universe = "Unknown Universe";
                                    }

                                    ?>

                                    <option value="<?php echo $id; ?>">
                                        <?php echo $name.'('.$universe.')'; ?>
                                    </option>

                                    <?php
                                }
                            
                            }
                            else 
                            {
                            ?>

                            <option value="0">No People Found</option>
                            
                            <?php
                            
                        }
                    ?>

                        </select>
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Soldier" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Army Form Ends -->


        <?php
        
            if (isset($_POST['submit']))
            {
                $id_person = $_POST['id_person'];

                //Взять id universe из табл people, добавить в army, удалить из people
                $sql3 = "SELECT * FROM people WHERE id=$id_person";
                $res3 = mysqli_query($conn, $sql3);
                $count3 = mysqli_num_rows($res3);

                if ($count3 == 1)
                {
                    $row3 = mysqli_fetch_assoc($res3);
                    $id_universe = $row3['id_universe'];
                    $name = $row3['name'];

                    $sql4 = "INSERT INTO army SET
                    name='$name',
                    id_universe=$id_universe";

                    $res4 = mysqli_query($conn, $sql4);

                    if ($res4)
                    {
                        $sql5 = "DELETE FROM people WHERE id=$id_person";
                        $res5 = mysqli_query($conn, $sql5);

                        if ($res5)
                        {
                            $_SESSION['add'] = "<div class='success'>Soldier Added Successfully</div>";
                            header('location:'.SITEURL.'admin/manage-army.php');
                        }
                        else
                        {
                            $_SESSION['add'] = "<div class='error'>Failed to delete Person from Population</div>";
                            header('location:'.SITEURL.'admin/manage-army.php');
                        }
                        
                    }
                    else 
                    {
                        $_SESSION['add'] = "<div class='error'>Failed to add Soldier</div>";
                        header('location:'.SITEURL.'admin/add-army-specific.php');
                    }
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to find id of Universe</div>";
                    header('location:'.SITEURL.'admin/add-army-specific.php');
                }
                
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>