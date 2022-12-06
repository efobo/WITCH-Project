<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Adviser</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "ruler")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the ruler for this</div>";
            }
            else
            { 
        
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


        <!-- Add People Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" placeholder="Name">
                    </td>
                </tr>

                <tr>
                    <td>Choose a Universe:</td>
                    <td>
                        <select name="id_universe">
                        <?php
                            
                            $sql = "SELECT * FROM universe";

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

                                <option value="0">No Universe Found</option>
                                
                                <?php
                                
                            }
                        ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Password">
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Adviser" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add People Form Ends -->


        <?php
        
            if (isset($_POST['submit']))
            {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $id_universe = $_POST['id_universe'];
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                
                

                $sql2 = "INSERT INTO adviser SET
                name='$name',
                id_universe='$id_universe',
                username='$username',
                password='$password'
                ";

                $res2 = mysqli_query($conn, $sql2);

                if ($res2)
                {
                    $_SESSION['add'] = "<div class='success'>Adviser Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-advisers.php');
                }
                else 
                {
                    $_SESSION['add'] = "<div class='error'>Failed to add Adviser</div>";
                    header('location:'.SITEURL.'admin/add-adviser.php');
                }
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>