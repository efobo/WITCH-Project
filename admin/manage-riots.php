<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>History of Riots</h1>
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

        <!-- Button to Add Army -->
        <a href="<?php echo SITEURL; ?>admin/quell-riot.php" class="btn-primary">Quell the Riot</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Place</th>
                <th>Deceased army</th>
                <th>Deceased rioters</th>
                <th>Who won</th>
            </tr>
            <?php
            $id_universe = $_SESSION['id_universe'];
            $sql = "SELECT * FROM riot WHERE id_universe=$id_universe";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    
                    $id = $row['id'];
                    $id_location = $row['id_location'];
                    $deceased_army = $row['deceased_army'];
                    $deceased_rioters = $row['deceased_rioters'];
                    $who_win = $row['who_win'];

                    $sql2 = "SELECT * FROM location WHERE id=$id_location";
                    $res2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_num_rows($res2);
                    if ($count2 == 1)
                    {
                        $row2 = mysqli_fetch_assoc($res2);
                        $location = $row2['name'];
                    }
                    else
                    {
                        $location = "unknown";
                    }
                    ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td width='30%'><?php echo $location; ?></td>
                            <td><?php echo $deceased_army; ?></td>
                            <td><?php echo $deceased_rioters; ?></td>
                            <td><?php echo $who_win; ?></td>
                        </tr>

                    <?php
                }
            }
            else
            {
                echo "<tr> <td colspan='7' class='error'>Not a single riot has been suppressed yet</td> </tr>";
            }
        ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>