<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Location</h1>

        <br><br>

        <?php 
            
            if ($_SESSION['status'] != "guardian")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the guards for this</div>";
            }
            else
            { 
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" placeholder="Name of Location">
                    </td>
                </tr>

                <tr>
                    <td>X Coordinate: </td>
                    <td>
                        <input type="number" name="x_cord" >
                    </td>
                </tr>

                <tr>
                    <td>Y Coordinate: </td>
                    <td>
                        <input type="number" name="y_cord" >
                    </td>
                </tr>

                <tr>
                    <td>Select Universe: </td>
                    <td>
                        <select name="id_universe">
                        <?php
                            
                            $sql = "SELECT * FROM universe";

                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0)
                            {
                                while ($row = mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $title = $row['name'];

                                    ?>

                                    <option value="<?php echo $id; ?>">
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
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Location" class="btn-danger">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            if (isset($_POST['submit']))
            {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $x_cord = $_POST['x_cord'];
                $y_cord = $_POST['y_cord'];
                $id_universe = $_POST['id_universe'];


                $sql2 = "INSERT INTO location SET
                name='$name',
                x_cords=$x_cord,
                y_cords=$y_cord,
                id_universe='$id_universe'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if ($res2)
                {
                    $_SESSION['add'] = "<div class='success'>Location Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-locations.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Location</div>";
                    header('location:'.SITEURL.'admin/manage-locations.php');
                }
            }
        
        
        } ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>