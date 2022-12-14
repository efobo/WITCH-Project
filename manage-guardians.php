<?php include('partials/menu.php'); ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
        <h1>Guardians</h1>
        <br><br>

        <?php
        
            if (isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
                echo "<br><br>";
            }

            if (isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
                echo "<br><br>";
            }

            if (isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
                echo "<br><br>";
            }

            if (isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
                echo "<br><br>";
            }

            if (isset($_SESSION['unauthorize']))
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
                echo "<br><br>";
            }

            if (isset($_SESSION['no-guardian-found']))
            {
                echo $_SESSION['no-guardian-found'];
                unset($_SESSION['no-guardian-found']);
                echo "<br><br>";
            }

        ?>
        <br>


        <!-- Button to Add Army -->
        <a href="<?php echo SITEURL; ?>add-guardian.php" class="btn-primary">Add Guardian</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Magical abilities</th>
                <th>Universe</th>
                <th>More info</th>
                <th>Image</th>
                <th>username</th>
                <th>Actions</th>
            </tr>
            <?php
            
            $sql = "SELECT * FROM guardian";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $name = $row['name'];
                    $username = $row['username'];
                    $magical_abilities = $row['magical_abilities'];
                    $more_info = $row['more_info'];
                    $image_name = $row['image_name'];
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
                        $universe = "unknown";
                    }
                   
                    ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $magical_abilities; ?></td>
                            <td><?php echo $universe; ?></td>
                            <td><?php echo $more_info; ?></td>
                            <td>
                                <?php
                                    
                                    if ($image_name == "")
                                    {
                                        echo "<div>Image Not Added</div>";
                                    }
                                    else
                                    {
                                        ?>

                                        <img src="<?php echo SITEURL; ?>img/guardian/<?php echo $image_name; ?>" width='100px'>

                                        <?php
                                    }

                                    ?>
                            </td>
                            <td><?php echo $username; ?></td>

                            <td>
                                <a href="<?php echo SITEURL;?>update-guardian.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL;?>delete-guardian.php?id=<?php echo $id; ?>" class="btn-danger">Delete</a>
                                
                                
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