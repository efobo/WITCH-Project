<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Battles History</h1>
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
        <a href="<?php echo SITEURL; ?>admin/start-battle.php" class="btn-primary">Start the Battle</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>№</th>
                <th>Place</th>
                <th>Who Started</th>
                <th>Who was attacked</th>
                <th>Deceased who started</th>
                <th>Deceased who was attacked</th>
                <th>Who won</th>
            </tr>
            <?php
            $sql = "SELECT * FROM battle";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $battle_id_universe = $row['battle_id_universe'];
                    $battle_id_location = $row['battle_id_location'];
                    $id_ruler_started = $row['id_ruler_started'];
                    $id_ruler_victim = $row['id_ruler_victim'];
                    $deceased_started = $row['deceased_started'];
                    $deceased_victim = $row['deceased_victim'];
                    $id_ruler_who_win = $row['id_ruler_who_win'];

                    $sql2 = "SELECT * FROM universe WHERE id=$battle_id_universe";
                    $res2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_num_rows($res2);
                    if ($count2 == 1)
                    {
                        $row2 = mysqli_fetch_assoc($res2);
                        $battle_universe = $row2['name'];
                    }
                    else
                    {
                        $battle_universe = "unknown";
                    }
                   
                    $sql3 = "SELECT * FROM location WHERE id=$battle_id_location";
                    $res3 = mysqli_query($conn, $sql3);
                    $count3 = mysqli_num_rows($res3);
                    if ($count3 == 1)
                    {
                        $row3 = mysqli_fetch_assoc($res3);
                        $battle_location = $row3['name'];
                    }
                    else
                    {
                        $battle_location = "unknown";
                    }

                    $sql4 = "SELECT * FROM ruler WHERE id=$id_ruler_started";
                    $res4 = mysqli_query($conn, $sql4);
                    $count4 = mysqli_num_rows($res4);
                    if ($count4 == 1)
                    {
                        $row4 = mysqli_fetch_assoc($res4);
                        $ruler_started = $row4['name'];
                        $ruler_started_universe_id = $row4['id_universe'];

                        $sql6 = "SELECT * FROM universe WHERE id=$ruler_started_universe_id";
                        $res6 = mysqli_query($conn, $sql6);
                        $count6 = mysqli_num_rows($res6);
                        if ($count6 == 1)
                        {
                            $row6 = mysqli_fetch_assoc($res6);
                            $ruler_started_universe = "from ".$row6['name'];
                        }
                        else
                        {
                            $ruler_started_universe = "unknown";
                        }
                    }
                    else
                    {
                        $ruler_started = "unknown";
                    }

                    $sql5 = "SELECT * FROM ruler WHERE id=$id_ruler_victim";
                    $res5 = mysqli_query($conn, $sql5);
                    $count5 = mysqli_num_rows($res5);
                    if ($count5 == 1)
                    {
                        $row5 = mysqli_fetch_assoc($res5);
                        $ruler_victim = $row5['name'];
                        $ruler_victim_universe_id = $row5['id_universe'];
                        
                        $sql7 = "SELECT * FROM universe WHERE id=$ruler_victim_universe_id";
                        $res7 = mysqli_query($conn, $sql7);
                        $count7 = mysqli_num_rows($res7);
                        if ($count7 == 1)
                        {
                            $row7 = mysqli_fetch_assoc($res7);
                            $ruler_victim_universe = "from ".$row7['name'];
                        }
                        else
                        {
                            $ruler_victim_universe = "unknown";
                        }
                    }
                    else
                    {
                        $ruler_victim = "unknown";
                    }

                    if ($id_ruler_who_win == $id_ruler_started)
                    {
                        $ruler_who_win = $ruler_started;
                        $ruler_who_win_universe = $ruler_started_universe;
                    }
                    else if ($id_ruler_who_win == $id_ruler_victim)
                    {
                        $ruler_who_win = $ruler_victim;
                        $ruler_who_win_universe = $ruler_victim_universe;
                    }
                    else
                    {
                        $ruler_who_win = "unknown";
                    }
                    ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td width='30%'><?php echo $battle_location." on ".$battle_universe; ?></td>
                            <td><?php echo $ruler_started." ".$ruler_started_universe; ?></td>
                            <td><?php echo $ruler_victim." ".$ruler_victim_universe; ?></td>
                            <td><?php echo $deceased_started; ?></td>
                            <td><?php echo $deceased_victim; ?></td>
                            <td><?php echo $ruler_who_win." ".$ruler_who_win_universe; ?></td>
                        </tr>

                    <?php
                }
            }
            else
            {
                echo "<tr> <td colspan='7' class='error'>Not a single battle has been fought yet</td> </tr>";
            }
        ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>