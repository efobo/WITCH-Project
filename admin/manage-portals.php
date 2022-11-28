<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Portals</h1>
        <br><br>

        <?php
        
            if (isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['unauthorize']))
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

        ?>
        <br><br>

        <!-- Button to Add Portal -->
        <a href="<?php echo SITEURL; ?>admin/add-portal.php" class="btn-primary">Add Portal</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Location</th>
                <th>Universe</th>
                <th>Created by</th>
                <th>Actions</th>
            </tr>
            <?php
            if (isset($_GET['id_univ'])) 
            {
                $id_univ = $_GET['id_univ'];
                $sql = "SELECT * FROM portal WHERE id_location IN (SELECT id FROM location WHERE id_universe=$id_univ)";
            }
            else
            {
                $sql = "SELECT * FROM portal";
            }
            
            

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $id_location = $row['id_location'];
                    $created_by = $row['created_by'];


                    $sql2 = "SELECT * FROM location WHERE id=$id_location";
                    $res2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_num_rows($res2);
                    if ($count2 == 1)
                    {
                        $row2 = mysqli_fetch_assoc($res2);
                        $location = $row2['name'];
                        $id_universe = $row2['id_universe'];

                        $sql3 = "SELECT * FROM universe WHERE id=$id_universe";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);
                        if ($count3 == 1)
                        {
                            $row3 = mysqli_fetch_assoc($res3);
                            $universe = $row3['name'];

                        
                        }
                        else
                        {
                            $universe = "unknown";
                        }
                        
                    }
                    else
                    {
                        $location = "unknown";
                        $universe = "unknown";
                    }
                   
                    ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $location; ?></td>
                            <td><?php echo $universe; ?></td>
                            <td><?php echo $created_by; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update-portal.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL;?>admin/delete-portal.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                                
                            </td>
                        </tr>

                    <?php
                }
            }
            else
            {
                echo "<tr> <td colspan='7' class='error'>Portals not Added Yet</td> </tr>";
            }
        ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>