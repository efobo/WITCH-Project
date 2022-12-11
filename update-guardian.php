<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Guardian</h1>

        <br><br>

        <?php 
            if ($_SESSION['status'] != "ruler")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the ruler for this</div>";
            }
            else {
        
            if (isset($_GET['id']))
            {
                $id = $_GET['id'];
                
                $sql = "SELECT * FROM guardian WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if ($count == 1)
                {
                    $row = mysqli_fetch_assoc($res);

                    $name = $row['name'];
                    $id_universe = $row['id_universe'];
                    $magical_abilities = $row['magical_abilities'];
                    $more_info = $row['more_info'];
                    $current_image = $row['image_name'];
                    $username = $row['username'];
                    $password = $row['password'];
                }
                else
                {
                    $_SESSION['no-guardian-found'] = "<div class='error'>Guardian Not Found</div>";
                    header('location:'.SITEURL.'manage-guardians.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'manage-guardians.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" maxlength="100" value="<?php echo $name; ?>">
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
                    <td>Magical abilities:</td>
                    <td>
                        <textarea name="magical_abilities" cols="30" rows="5"><?php echo $magical_abilities; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>More info:</td>
                    <td>
                        <textarea name="more_info" cols="30" rows="5"><?php echo $more_info; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if ($current_image == "")
                            {
                                echo "<div class='error'>Image not Available</div>";
                            }
                            else
                            {
                                ?>

                                <img src="<?php echo SITEURL; ?>img/guardian/<?php echo $current_image; ?>" width="150px">

                                <?php
                            }
                        ?>
                    </td>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image" class="btn-secondary" >
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" maxlength="100" value="<?php echo $username; ?>">
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
                        <input type="submit" name="submit" value="Update Guardian" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>


        <?php 

            if (isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $magical_abilities = mysqli_real_escape_string($conn, $_POST['magical_abilities']);
                $more_info = mysqli_real_escape_string($conn, $_POST['more_info']);
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $id_universe = $_POST['id_universe'];
                $password = $_POST['password'];

                if (isset($_FILES['image']['name']))
                {
                    
                    $image_name = $_FILES['image']['name'];

                    if ($image_name != "")
                    {
                        $ext = end(explode('.', $image_name));
                        $image_name = "Picture-".rand(0000,9999).'.'.$ext;

                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "img/guardian/".$image_name;

                        $upload = move_uploaded_file($src_path, $dest_path);

                        if ($upload == false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                            header('location:'.SITEURL.'manage-guardian.php');

                            die();
                        }

                        if ($current_image != "")
                        {
                            $remove_path = "img/guardian/".$current_image;

                            $remove = unlink($remove_path);

                            if ($remove == false)
                            {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                header('location:'.SITEURL.'manage-guardian.php');

                                die();
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
                


                $sql3 = "UPDATE guardian SET
                name='$name',
                magical_abilities='$magical_abilities',
                more_info='$more_info',
                username='$username',
                id_universe='$id_universe'
                ";

                if ($password != "") 
                {
                    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                    
                    $sql3 .= ", password='$password'";
                }
                if ($image_name != $current_image)
                {
                    $sql3 .= ", image_name='$image_name'";
                }
                $sql3 .= " WHERE id=$id";
                

                $res3 = mysqli_query($conn, $sql3);

                if ($res3)
                {
                    $_SESSION['update'] = "<div class='success'>Guardian Updated Successfully</div>";
                    header('location:'.SITEURL.'manage-guardians.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Guardian</div>";
                    header('location:'.SITEURL.'manage-guardians.php');
                }
                
            }
        
        
        }?>

    </div>
</div>

<?php include('partials/footer.php'); ?>