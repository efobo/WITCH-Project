<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Start the Battle</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "ruler")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the ruler for this</div>";
            }
            else
            {
                $id_my_universe = $_SESSION['id_universe'];
                $sql3 = "SELECT * FROM army WHERE id_universe=$id_my_universe";
                $res3 = mysqli_query($conn, $sql3);

                $count3 = mysqli_num_rows($res3);

                if ($count3 == 0) 
                {
                    echo "<div>You don't have any soldiers at all! Ask the advisors to recruit an army!</div>";
                } else {
        
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
        ?>


        <!-- Start Battle Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Choose the ruler you want to attack</td>
                    <td>
                        <select name="id_ruler_victim">
                        <?php
                            $id_ruler_started = $_SESSION['id'];
                            $sql5 = "SELECT * FROM ruler WHERE id<>$id_ruler_started";
                            $res5 = mysqli_query($conn, $sql5);
                            $count5 = mysqli_num_rows($res5);
                            if ($count5 > 0)
                            {
                                while ($row5 = mysqli_fetch_assoc($res5))
                                {
                                    $id_ruler_victim = $row5['id'];
                                    $title = $row5['name'];
                                    $id_universe = $row5['id_universe'];
                                    
                                    $sql6 = "SELECT * FROM universe WHERE id=$id_universe";

                                    $res6 = mysqli_query($conn, $sql6);

                                    $count6 = mysqli_num_rows($res6);

                                    if ($count6 == 1)
                                    {
                                        $row6 = mysqli_fetch_assoc($res6);
                                        $universe = $row6['name'];
                                    }
                                    else
                                    {
                                        $universe = "unknown";
                                    }
                                    
                                    ?>

                                    <option value="<?php echo $id_ruler_victim; ?>">
                                        <?php echo $title.'('.$universe.')'; ?>
                                    </option>

                                    <?php
                                }
                            }
                            else {
                                ?>

                                <option value="0">No else Rulers Found</option>
                                
                                <?php
                            }
                        ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Select an available location:</td>
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

                                    <option value="<?php echo $id; ?>">
                                        <?php echo $title.'('.$universe.')'; ?>
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
                        
                        <input type="number" name="qty_soldiers" min="0" max="<?php echo $count3; ?>">
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Start the Battle" class="btn-danger">
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
                        header('location:'.SITEURL.'admin/start-battle.php');
                }
                $battle_id_location = $_POST['id_location'];
                // Находим name у location и battle_id_universe 
                $sql4 = "SELECT * FROM location WHERE id=$battle_id_location";
                $res4 = mysqli_query($conn, $sql4);
                $count4 = mysqli_num_rows($res4);
                if ($count4 == 1)
                {
                    $row4 = mysqli_fetch_assoc($res4);
                    $battle_id_universe = $row4['id_universe'];
                    $battle_location = $row4['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with battle id universe</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }

                // Находим name у battle_id_universe 
                $sql12 = "SELECT * FROM universe WHERE id=$battle_id_universe";
                $res12 = mysqli_query($conn, $sql12);
                $count12 = mysqli_num_rows($res12);
                if ($count12 == 1)
                {
                    $row12 = mysqli_fetch_assoc($res12);
                    $battle_universe = $row12['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with battle universe</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }
                

                $id_ruler_started = $_SESSION['id'];
                $id_universe_started = $_SESSION['id_universe'];
                $ruler_started = $_SESSION['name'];
                $id_ruler_victim = $_POST['id_ruler_victim'];


                // Находим id universe у victim
                $sql7 = "SELECT * FROM ruler WHERE id=$id_ruler_victim";
                $res7 = mysqli_query($conn, $sql7);
                $count7 = mysqli_num_rows($res7);
                if ($count7 == 1)
                {
                    $row7 = mysqli_fetch_assoc($res7);
                    $id_universe_victim = $row7['id_universe'];
                    $ruler_victim = $row7['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with id universe victim</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }

                // Находим universe name у victim
                $sql10 = "SELECT * FROM universe WHERE id=$id_universe_victim";
                $res10 = mysqli_query($conn, $sql10);
                $count10 = mysqli_num_rows($res10);
                if ($count10 == 1)
                {
                    $row10 = mysqli_fetch_assoc($res10);
                    $universe_victim = $row10['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with universe name victim</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }

                // Находим universe name у started
                $sql11 = "SELECT * FROM universe WHERE id=$id_universe_started";
                $res11 = mysqli_query($conn, $sql11);
                $count11 = mysqli_num_rows($res11);
                if ($count11 == 1)
                {
                    $row11 = mysqli_fetch_assoc($res11);
                    $universe_started = $row11['name'];
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with universe name started</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }

                
                // Находим кол-во army у victim
                $sql8 = "SELECT * FROM army WHERE id_universe=$id_universe_victim";
                $res8 = mysqli_query($conn, $sql8);
                if ($res8)
                {
                    $count8 = mysqli_num_rows($res8);
                    $army_victim = $count8;
                }
                else
                {
                    $_SESSION['msg'] = "<div class='error'>Some error with army victim</div>";
                    header('location:'.SITEURL.'admin/start-battle.php');
                }
                
                
                // Реализация самого боя
                if ($id_universe_victim == 2)
                {
                    $id_ruler_who_win = $id_ruler_victim;
                    $deceased_mood = rand(0, 1);
                    if ($deceased_mood == 0)
                    {
                        $deceased_started = 0;
                    }
                    else if ($deceased_mood == 1)
                    {
                        $deceased_percent = rand(1, 50);
                        $deceased_started = round($qty_soldiers*$deceased_percent/100);

                        $sql10 = "DELETE FROM army WHERE id_universe=$id_universe_started LIMIT $deceased_started";
                        $res10 = mysqli_query($conn, $sql10);
                        if (!$res10)
                        {
                            $_SESSION['msg'] = "<div class='error'>Error with deleting started army from DataBase</div>";
                            header('location:'.SITEURL.'admin/start-battle.php');
                        }      
                    }

                    if ($army_victim > 0)
                    {
                        $deceased_mood = rand(1, 5);
                        if ($deceased_mood == 1)
                        {
                            $deceased_percent = rand(1, 10);
                            $deceased_victim = round($army_victim*$deceased_percent/100);
                            
                            $sql10 = "DELETE FROM army WHERE id_universe=$id_universe_victim LIMIT $deceased_victim";
                            $res10 = mysqli_query($conn, $sql10);
                            if (!$res10)
                            {
                                $_SESSION['msg'] = "<div class='error'>Error with deleting victim army from DataBase</div>";
                                header('location:'.SITEURL.'admin/start-battle.php');
                            }  
                        }
                        else $deceased_victim = 0;

                    }
                    else
                    {
                        $deceased_victim = 0;
                    }
                }
                else
                {
                    $army_diff = $qty_soldiers - $army_victim;

                    if ($army_diff >= 20)
                    {
                        $id_ruler_who_win = $id_ruler_started;    
                    }
                    else if ($army_diff >= 10)
                    {
                        $winner_mood = rand(1, 5);
                        if ($winner_mood == 3)
                        {
                            $id_ruler_who_win = $id_ruler_victim;
                        }
                        else
                        {
                            $id_ruler_who_win = $id_ruler_started;
                        }
                    }
                    else if ($army_diff > 0)
                    {
                        $winner_mood = rand(1,3);
                        if ($winner_mood == 2)
                        {
                            $id_ruler_who_win = $id_ruler_victim;
                        }
                        else
                        {
                            $id_ruler_who_win = $id_ruler_started;
                        }
                    }
                    else if ($army_diff == 0)
                    {
                        $winner_mood = rand(1,2);
                        if ($winner_mood == 1)
                        {
                            $id_ruler_who_win = $id_ruler_victim;
                        }
                        else
                        {
                            $id_ruler_who_win = $id_ruler_started;
                        }
                    }
                    else if ($army_diff <= -20)
                    {
                        $id_ruler_who_win = $id_ruler_victim;
                    }
                    else if ($army_diff <= -10)
                    {
                        $winner_mood = rand(1, 5);
                        if ($winner_mood == 3)
                        {
                            $id_ruler_who_win = $id_ruler_started;
                        }
                        else
                        {
                            $id_ruler_who_win = $id_ruler_victim;
                        }
                    }
                    else if ($army_diff < 0)
                    {
                        $winner_mood = rand(1,3);
                        if ($winner_mood == 2)
                        {
                            $id_ruler_who_win = $id_ruler_started;
                        }
                        else
                        {
                            $id_ruler_who_win = $id_ruler_victim;
                        }
                    }

                    $deceased_mood = rand(0, 100);
                    $deceased_started = round($qty_soldiers*$deceased_mood/100);
                    $deceased_mood = rand (0, 100);
                    $deceased_victim = round($army_victim*$deceased_mood/100);

                    $sql10 = "DELETE FROM army WHERE id_universe=$id_universe_started LIMIT $deceased_started";
                    $res10 = mysqli_query($conn, $sql10);
                    if (!$res10)
                    {
                        $_SESSION['msg'] = "<div class='error'>Error with deleting started army from DataBase</div>";
                        header('location:'.SITEURL.'admin/start-battle.php');
                    }  
                    $sql11 = "DELETE FROM army WHERE id_universe=$id_universe_victim LIMIT $deceased_victim";
                    $res11 = mysqli_query($conn, $sql11);
                    if (!$res11)
                    {
                        $_SESSION['msg'] = "<div class='error'>Error with deleting victim army from DataBase</div>";
                        header('location:'.SITEURL.'admin/start-battle.php');
                    }  
                }

                $sql9 = "INSERT INTO battle SET
                battle_id_universe=$battle_id_universe,
                battle_id_location=$battle_id_location,
                id_ruler_started=$id_ruler_started,
                id_ruler_victim=$id_ruler_victim,
                deceased_started=$deceased_started,
                deceased_victim=$deceased_victim,
                id_ruler_who_win=$id_ruler_who_win";

                $res9 = mysqli_query($conn, $sql9);
                if ($res9)
                {
                    
                    if ($id_ruler_started == $id_ruler_who_win)
                    {
                        $_SESSION['battle'] = "<div>Congratulations on your victory! Your army has lost $deceased_started fighters. The opponent's army lost $deceased_victim fighters.</div>";
                        $news_text = "$ruler_started from the planet $universe_started attacked the $ruler_victim from the planet $universe_victim and WON! The battle took place in a $battle_location on planet $battle_universe. During the battle, the army of $ruler_started lost $deceased_started fighters. The $ruler_victim Army lost $deceased_victim fighters.";
                    }
                    else
                    {
                        $_SESSION['battle'] = "<div>Oh no, you've failed! Your army has lost $deceased_started fighters. The opponent's army lost $deceased_victim fighters.</div>";
                        $news_text = "$ruler_started from the planet $universe_started attacked the $ruler_victim from the planet $universe_victim and LOST! The battle took place in a $battle_location on planet $battle_universe. During the battle, the army of $ruler_started lost $deceased_started fighters. The $ruler_victim Army lost $deceased_victim fighters.";
                    }

                    $news_title = "$ruler_started vs $ruler_victim. WAR!";
                    $news_date = date("Y-m-d h:i:s");                  

                    $sql13 = "INSERT INTO news SET
                    news_date='$news_date',
                    title='$news_title',
                    text='$news_text'";
                    $res13 = mysqli_query($conn, $sql13);
                    if (!$res13)
                    {
                        $_SESSION['news'] = "<div class='error'>The event was not added to the news</div>";
                    }

                    
                }
                else
                {
                    $_SESSION['battle'] = "<div class='error'>Something went wrong. It was not possible to arrange a battle.</div>";
                }
               header('location:'.SITEURL.'admin/manage-wars.php');

                
               
            }
        }}
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>