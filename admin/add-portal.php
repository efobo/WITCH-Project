<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Portal</h1>

        <br><br>

        <?php 
            
            if ($_SESSION['status'] != "guardian")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the guards for this</div>";
            }
            else
            { 
                $username = $_SESSION['user'];
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Select Location: </td>
                    <td>
                        <select name="id_location">
                        <?php
                            
                            $sql = "SELECT * FROM location";

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

                                <option value="0">No Location Found</option>
                                
                                <?php
                                
                            }
                        ?>

                        </select>
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Portal" class="btn-danger">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            if (isset($_POST['submit']))
            {
                
                $id_location = $_POST['id_location'];


                $sql2 = "INSERT INTO portal SET
                id_location='$id_location',
                created_by='$username'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if ($res2)
                {
                    $_SESSION['add'] = "<div class='success'>Portal Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-portals.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Portal</div>";
                    header('location:'.SITEURL.'admin/manage-portals.php');
                }
            }
        
        
        } ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>