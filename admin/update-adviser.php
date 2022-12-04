<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Adviser</h1>

        <br><br>

        <?php 
        
            if (isset($_GET['id']))
            {
                $_SESSION['change-pass'] = false; 
                $id = $_GET['id'];
                
                $sql = "SELECT * FROM adviser WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if ($count == 1)
                {
                    $row = mysqli_fetch_assoc($res);

                    $name = $row['name'];
                    $id_universe = $row['id_universe'];
                    $username = $row['username'];
                    $password = $row['password'];
                }
                else
                {
                    $_SESSION['no-adviser-found'] = "<div class='error'>Adviser Not Found</div>";
                    header('location:'.SITEURL.'admin/manage-advisers.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'admin/manage-advisers.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Universe: </td>
                    <td>
                    <select name="id_universe">
                        <?php
                            
                            $sql2 = "SELECT * FROM universe";

                            $res2 = mysqli_query($conn, $sql2);

                            $count2 = mysqli_num_rows($res2);

                            if ($count2 > 0)
                            {
                                while ($row2 = mysqli_fetch_assoc($res2))
                                {
                                    $id_univ = $row2['id'];
                                    $title = $row2['name'];

                                    ?>

                                    <option <?php if ($id_univ == $id_universe) echo "selected='selected' "; ?> value="<?php echo $id_univ; ?>">
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
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td>New password: </td>
                    <td>
                        <input type="password" name="password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Adviser" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>


        <?php 

            if (isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $id_universe = $_POST['id_universe'];
                $password = $_POST['password'];
                


                $sql3 = "UPDATE adviser SET
                name='$name',
                username='$username',
                id_universe='$id_universe'
                ";

                if ($password != "") 
                {
                    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                    
                    $sql3 .= ", password='$password'";
                }
                $sql3 .= " WHERE id=$id";
                

                $res3 = mysqli_query($conn, $sql3);

                if ($res3)
                {
                    $_SESSION['update'] = "<div class='success'>Adviser Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-advisers.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Adviser</div>";
                    header('location:'.SITEURL.'admin/manage-advisers.php');
                }
                
            }
        
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>