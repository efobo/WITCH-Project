<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Worlds</h1>
        <br><br>
         <!-- Button to Add Food -->
         <a href="<?php echo SITEURL; ?>admin/manage-portals.php" class="btn-primary">View all portals</a>
         <a href="<?php echo SITEURL; ?>admin/manage-locations.php" class="btn-primary">View all locations</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Map</th>
                <th>Nation</th>
            </tr>
            <?php
            
            $sql = "SELECT * FROM universe";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $name = $row['name'];
                   
                    ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td width='30%'><?php echo $name; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/manage-portals.php?id_univ=<?php echo $id; ?>" class="btn-secondary">Portals</a>
                                <a href="<?php echo SITEURL;?>admin/manage-locations.php?id_univ=<?php echo $id; ?>" class="btn-secondary">Locations</a>
                                
                            </td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/manage-army.php?id_univ=<?php echo $id; ?>" class="btn-danger">Army</a>
                                <a href="<?php echo SITEURL;?>admin/manage-people.php?id_univ=<?php echo $id; ?>" class="btn-danger">Population</a>
                                <a href="<?php echo SITEURL;?>admin/manage-rioters.php?id_univ=<?php echo $id; ?>" class="btn-danger">Rioters</a>
                            </td>
                        </tr>

                    <?php
                }
            }
            else
            {
                echo "<tr> <td colspan='7' class='error'>Food not Added Yet</td> </tr>";
            }
        ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>