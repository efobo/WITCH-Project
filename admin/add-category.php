<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 
        
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


        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" class="btn-secondary">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes  
                        <input type="radio" name="featured" value="No"> No  
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes  
                        <input type="radio" name="active" value="No"> No  
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-danger">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Category Form Ends -->


        <?php
        
            if (isset($_POST['submit']))
            {
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                

                if (isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else {
                    //$featured = "No";
                    $_SESSION['msg'] = "<div class='error'>Select an item 'featured'</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }


                if (isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    //$active = "No";
                    $_SESSION['msg'] = "<div class='error'>Select an item 'active'</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }

                //print_r($_FILES['image']);

                //die();

                if (isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];


                    if ($image_name != "")
                    {
                        $ext = end(explode('.', $image_name));


                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../img/category/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if ($upload == false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            header('location:'.SITEURL.'admin/add-category.php');
                            die();
                        }
                    }
                    
                }
                else
                {
                    $image_name ="";
                }

                $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                ";

                echo $title;
                echo $featured;
                echo $active;

                $res = mysqli_query($conn, $sql);

                if ($res)
                {
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else 
                {
                    $_SESSION['add'] = "<div class='error'>Failed to add Category</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>