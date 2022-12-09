<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Army</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "adviser")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the adviser for this</div>";
            }
            else { 
        
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

                $id_universe = $_SESSION['id_universe'];

                $sql = "SELECT * FROM people WHERE id_universe=$id_universe";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count == 0)
                {
                    echo "<div>There are 0 people. You can't take anybody.</div>";
                }
                else
                {
                    $people_qty = $count;
                
            
        ?>


        <!-- Add Army Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Enter the Quantity: </td>
                    <td>
                        <input type="number" name="qty" value="<?php if ($people_qty >= 10) echo 10; else echo $people_qty; ?>" min="1" max="<?php echo $people_qty; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Soldiers" class="btn-danger">
                    </td>
                </tr>
            </table>
        </form>
        
        <?php 
         if (isset($_POST['submit']))
         {
            $qty = $_POST['qty'];

            $escape_percent = rand(0, 70);
            $rioters_percent = rand (0, 100);

            $escape_qty = round($qty * $escape_percent/100);
            $rioters_qty = round($escape_qty * $escape_percent/100);
            $killed_qty = $escape_qty - $rioters_qty;
            $army_qty = $qty - $escape_qty;

            $sql2 = "SELECT * FROM people WHERE id_universe=$id_universe LIMIT $qty";

            $res2 = mysqli_query($conn, $sql2);
            if ($res2)
            {
                $names_arr = array();
                $id_arr = array();
                $i = 0;

                while ($row2 = mysqli_fetch_assoc($res2))
                {
                    $names_arr[$i] = $row2['name'];
                    $id_arr[$i] = $row2['id'];
                    $i++;
                }

                //убираем людей
                for ($i = 0; $i < $qty; $i++) {
                    $sql3 = "DELETE FROM people WHERE id=$id_arr[$i]";
                    $res3 = mysqli_query($conn, $sql3);
                    if (!$res3)
                    {
                        $_SESSION['add'] = "<div class='error'>Failed to delete person. $i people have already been removed</div>";
                        header('location:'.SITEURL.'manage-army.php');
                        exit;
                    }
                }

                //добавляем в армию
                for ($i = 0; $i < $army_qty; $i++) {
                    $sql4 = "INSERT INTO army SET
                        name='$names_arr[$i]',
                        id_universe=$id_universe";
                    $res4 = mysqli_query($conn, $sql4);
                    if (!$res4) {
                        $_SESSION['add'] = "<div class='error'>Failed to add soldier. $i soldiers have already been added. $qty people have already been removed</div>";
                        header('location:'.SITEURL.'manage-army.php');
                        exit;
                    }
                }

                //добавляем в бунтовщиков
                for ($i = $army_qty; $i < ($rioters_qty + $army_qty); $i++) {
                    $sql4 = "INSERT INTO rioter SET
                        name='$names_arr[$i]',
                        id_universe=$id_universe";
                    $res4 = mysqli_query($conn, $sql4);
                    if (!$res4) {
                        $_SESSION['add'] = "<div class='error'>Failed to add rioter. $i rioters have already been added. $army_qty soldiers have already been added. $qty people have already been removed</div>";
                        header('location:'.SITEURL.'manage-army.php');
                        exit;
                    }
                }

                $sql5 = "SELECT * FROM universe WHERE id=$id_universe";
                $res5 = mysqli_query($conn, $sql5);
                if ($res5)
                {
                    $row5 = mysqli_fetch_assoc($res5);
                    $universe = $row5['name'];
                    //новости
                    $news_date = date("Y-m-d h:i:s");
                    $adviser = $_SESSION['name'];
                    $news_title = "A new draft into the army on $universe!";
                    $news_text = "The government has announced a new set of recruits. Rumor has it that it was the initiative of the royal adviser $adviser. $qty peasants were forcibly captured. But $escape_qty of them decided to run away. $rioters_qty of them succeeded, they joined the rebels and are now forced to hide from the authorities. But the remaining $killed_qty poor devils were unlucky and they were shot as soon as they were caught.";
                    $sql6 = "INSERT INTO news SET
                        news_date='$news_date',
                        title='$news_title',
                        text='$news_text'";
                    $res6 = mysqli_query($conn, $sql6);
                    if (!$res6)
                    {
                        $_SESSION['news'] = "<div class='error'>The event was not added to the news</div>";
                    }
                    $_SESSION['add'] = "<div class='success'>Soldiers added Successfully! <br>$escape_qty peasants decided to escape, we managed to catch $killed_qty and kill them for disobedience, the $rioters_qty remaining joined the rioters. <br>$army_qty soldiers joined the ranks of our army.</div>";
                    header('location:'.SITEURL.'manage-army.php');
                }
                else{
                    $_SESSION['news'] = "<div class='error'>The event was not added to the news</div>";
                    $_SESSION['add'] = "<div class='success'>$news_title <br> $news_text <br> Soldiers added Successfully! <br>$escape_qty peasants decided to escape, we managed to catch $killed_qty and kill them for disobedience, the $rioters_qty remaining joined the rioters. <br>$army_qty soldiers joined the ranks of our army.</div>";
                    header('location:'.SITEURL.'manage-army.php');
                }

                

                
                
                
                
            }
            else
            {
                $_SESSION['add'] = "<div class='error'>Failed to execute people</div>";
                header('location:'.SITEURL.'manage-army.php');
            }
            
            

            
           
            
         }
    }} ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>