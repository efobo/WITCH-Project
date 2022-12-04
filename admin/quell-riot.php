<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Quell the Riot</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "ruler")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the ruler for this</div>";
            }
            else
            {
                $id_my_universe = $_SESSION['id_universe'];
                $sql = "SELECT * FROM rioter WHERE id_universe=$id_my_universe";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count == 0)
                {
                    echo "<div>There are 0 rioters in our universe. Who do you want to attack?</div>";
                }
                else 
                {
                    $rioters_qty = $count;
                
                    $sql2 = "SELECT * FROM army WHERE id_universe=$id_my_universe";
                    $res2 = mysqli_query($conn, $sql2);

                    $count2 = mysqli_num_rows($res2);

                    if ($count2 == 0) 
                    {
                        echo "<div>You don't have any soldiers at all! Ask the advisors to recruit an army!</div>";
                    } else {
                        $army_qty = $count2;
            
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
                }
        ?>


        <!-- Quell Riot Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>At the moment it is known about <?php echo $rioters_qty; ?> rioters</td>
                </tr>

                <tr>
                    <td>Select an available location:</td>
                    <td>
                        <select name="id_location">
                        <?php
                            
                            $sql3 = "SELECT * FROM location WHERE id_universe=$id_my_universe";

                            $res3 = mysqli_query($conn, $sql3);

                            $count3 = mysqli_num_rows($res3);

                            if ($count3 > 0)
                            {
                                while ($row3 = mysqli_fetch_assoc($res3))
                                {
                                    $id = $row3['id'];
                                    $title = $row3['name'];

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
                    <td>How many soldiers will you send to battle?</td>
                    <td>
                        
                        <input type="number" name="qty_soldiers" min="0" max="<?php echo $army_qty; ?>">
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Quell the Riot" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Quell Riot Form Ends -->


        <?php
        
            if (isset($_POST['submit']))
            {
                
                $qty_soldiers = $_POST['qty_soldiers'];
                if ($qty_soldiers < 0) 
                {
                    $_SESSION['msg'] = "<div class='error'>You can't send less then 0 soldiers into battle</div>";
                    header('location:'.SITEURL.'admin/quell-riot.php');
                }
                $riot_id_location = $_POST['id_location'];

                // находим название локации
                $sql7 = "SELECT * FROM location WHERE id=$riot_id_location";
                $res7 = mysqli_query($conn, $sql7);
                $count7 = mysqli_num_rows($res7);
                if ($count7 == 1)
                {
                    $row7 = mysqli_fetch_assoc($res7);
                    $riot_location = $row7['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with executing location</div>";
                    header('location:'.SITEURL.'admin/manage-wars.php');
                }

                // находим название вселенной
                $sql8 = "SELECT * FROM universe WHERE id=$id_my_universe";
                $res8 = mysqli_query($conn, $sql8);
                $count8 = mysqli_num_rows($res8);
                if ($count8 == 1)
                {
                    $row8 = mysqli_fetch_assoc($res8);
                    $universe = $row8['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with executing universe</div>";
                    header('location:'.SITEURL.'admin/manage-wars.php');
                }
                
                
                // Реализация самого восстания
                $army_diff = $qty_soldiers - $rioters_qty;

                if ($army_diff >= 20)
                {
                    $who_win = "ruler";    
                }
                else if ($army_diff >= 10)
                {
                    $winner_mood = rand(1, 5);
                    if ($winner_mood == 3)
                    {
                        $who_win = "rioters";
                    }
                    else
                    {
                        $who_win = "ruler";
                    }
                }
                else if ($army_diff > 0)
                {
                    $winner_mood = rand(1,3);
                    if ($winner_mood == 2)
                    {
                        $who_win = "rioters";
                    }
                    else
                    {
                        $who_win = "ruler";
                    }
                }
                else if ($army_diff == 0)
                {
                    $winner_mood = rand(1,2);
                    if ($winner_mood == 1)
                    {
                        $who_win = "rioters";
                    }
                    else
                    {
                        $who_win = "ruler";
                    }
                }
                else if ($army_diff <= -20)
                {
                    $who_win = "rioters";
                }
                else if ($army_diff <= -10)
                {
                    $winner_mood = rand(1, 5);
                    if ($winner_mood == 3)
                    {
                        $who_win = "ruler";
                    }
                    else
                    {
                        $who_win = "rioters";
                    }
                }
                else if ($army_diff < 0)
                {
                    $winner_mood = rand(1,3);
                    if ($winner_mood == 2)
                    {
                        $who_win = "ruler";
                    }
                    else
                    {
                        $who_win = "rioters";
                    }
                }

                $deceased_mood = rand(0, 100);
                $deceased_ruler = round($qty_soldiers*$deceased_mood/100);
                $deceased_mood = rand (0, 100);
                $deceased_rioters = round($army_victim*$deceased_mood/100);

                $sql4 = "DELETE FROM army WHERE id_universe=$id_my_universe LIMIT $deceased_ruler";
                $res4 = mysqli_query($conn, $sql4);
                if (!$res4)
                {
                    $_SESSION['msg'] = "<div class='error'>Error with deleting ruler army from DataBase</div>";
                    header('location:'.SITEURL.'admin/quell-riot.php');
                }  
                $sql5 = "DELETE FROM rioter WHERE id_universe=$id_my_universe LIMIT $deceased_rioters";
                $res5 = mysqli_query($conn, $sql5);
                if (!$res5)
                {
                    $_SESSION['msg'] = "<div class='error'>Error with deleting rioters from DataBase</div>";
                    header('location:'.SITEURL.'admin/quell-riot.php');
                }  
                

                $sql6 = "INSERT INTO riot SET
                id_universe=$id_my_universe,
                id_location=$riot_id_location,
                deceased_army=$deceased_ruler,
                deceased_rioters=$deceased_rioters,
                who_win='$who_win'";

                $res6 = mysqli_query($conn, $sql6);
                if ($res6)
                {
                    $news_date = date("Y-m-d h:i:s");
                    $time = date("H:i");
                    $ruler = $_SESSION['name'];

                    if ($id_ruler_started == $id_ruler_who_win)
                    {
                        $_SESSION['riot'] = "<div>Congratulations, you have successfully suppressed the uprising! Your army has lost $deceased_ruler fighters. $deceased_rioters rioters were killed.</div>";
                        $news_title = "The uprising on planet $universe has been suppressed";
                        $news_text = "Today, in the $riot_location on the planet $universe at $time, rioters raised an uprising. The valiant ruler $ruler sent his army to punish the disobedient. The uprising was suppressed at the cost of $deceased_ruler soldiers of the royal army. $deceased_rioters rioters were killed.";
                    }
                    else
                    {
                        $_SESSION['riot'] = "<div>You failed to suppress the uprising. Your army has lost $deceased_ruler fighters. $deceased_rioters rioters were killed.</div>";
                        $news_title = "Will $ruler be overthrown?";
                        $news_text = "Today, in the $riot_location on the planet $universe at $time, rioters raised an uprising. The bravery of the rebels defeated the royal army! $deceased_ruler soldiers of the royal army and $deceased_rioters rioters were killed.";
                    }

                    $sql9 = "INSERT INTO news SET
                    news_date='$news_date',
                    title='$news_title',
                    text='$news_text'";
                    $res9 = mysqli_query($conn, $sql9);
                    if (!$res9)
                    {
                        $_SESSION['news'] = "<div class='error'>The event was not added to the news</div>";
                    }
                    
                }
                else
                {
                    $_SESSION['riot'] = "<div class='error'>Something went wrong. It was not possible to quell the riot.</div>";
                }
               header('location:'.SITEURL.'admin/manage-wars.php');

                
               
            }
        }}
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>