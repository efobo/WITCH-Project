<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Location</h1>

        <br><br>

        <?php 
            if ($_SESSION['status'] != "adviser")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the advisers for this</div>";
            }
            else {
        
            if (isset($_GET['id']))
            {
                $id = $_GET['id'];
                
                $sql = "SELECT * FROM location WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if ($count == 1)
                {
                    $row = mysqli_fetch_assoc($res);

                    $name = $row['name'];
                    $id_universe = $row['id_universe'];
                    $x_cords = $row['x_cords'];
                    $y_cords = $row['y_cords'];
                }
                else
                {
                    $_SESSION['no-location-found'] = "<div class='error'>Location Not Found</div>";
                    header('location:'.SITEURL.'manage-locations.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'manage-locations.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Universe: </td>
                    <td>
                    <select name="id_universe">
                        <?php
                            
                            $sql2 = "SELECT * FROM universe";

                            $res2 = mysqli_query($conn, $sql2);

                            $count2 = mysqli_num_rows($res2);

                            if ($count2 > 0)
                            {
                                while ($row2 = mysqli_fetch_assoc($res2))
                                {
                                    $id_univ = $row2['id'];
                                    $title = $row2['name'];

                                    ?>

                                    <option <?php if ($id_univ == $id_universe) echo "selected='selected' "; ?> value="<?php echo $id_univ; ?>">
                                        <?php echo $title; ?>
                                    </option>

                                    <?php
                                }
                            }
                            else 
                            {
                                ?>

                                <option value="0">No Universe Found</option>
                                
                                <?php
                                
                            }
                        ?>

                        </select>
                    </td>

                </tr>

                <tr>
                    <td>X Coordinate: </td>
                    <td>
                        <input type="number" name="x_cords" value="<?php echo $x_cords; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Y Coordinate: </td>
                    <td>
                        <input type="number" name="y_cords" value="<?php echo $y_cords; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Location" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>


        <?php 

            if (isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $x_cords = $_POST['x_cords'];
                $y_cords = $_POST['y_cords'];
                $id_universe = $_POST['id_universe'];
                


                $sql3 = "UPDATE location SET
                name='$name',
                x_cords=$x_cords,
                y_cords=$y_cords,
                id_universe='$id_universe'
                WHERE id=$id";
                

                $res3 = mysqli_query($conn, $sql3);

                if ($res3)
                {
                    $_SESSION['update'] = "<div class='success'>Location Updated Successfully</div>";
                    header('location:'.SITEURL.'manage-locations.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Location</div>";
                    header('location:'.SITEURL.'manage-locations.php');
                }
                
            }
        
        
        }?>

    </div>
</div>

<?php include('partials/footer.php'); ?>