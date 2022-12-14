<?php include('partials/menu.php'); ?>

    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
        <h1>Advisers</h1>
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

            if (isset($_SESSION['no-adviser-found']))
            {
                echo $_SESSION['no-adviser-found'];
                unset($_SESSION['no-adviser-found']);
            }

        ?>
        <br><br>

        <!-- Button to Add Army -->
        <a href="<?php echo SITEURL; ?>add-adviser.php" class="btn-primary">Add Adviser</a>

        <br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Universe</th>
                <th>username</th>
                <th>Actions</th>
            </tr>
            <?php
            
            $sql = "SELECT * FROM adviser";

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
                            <td width='30%'><?php echo $name; ?></td>
                            <td><?php echo $universe; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>update-adviser.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL;?>delete-adviser.php?id=<?php echo $id; ?>" class="btn-danger">Delete</a>
                                
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