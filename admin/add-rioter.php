<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Rioters</h1>

        <br><br>

        <?php 
  
            if ($_SESSION['status'] != "adviser")
            {
                echo "<div>Sorry, you don't have access to change this data. Ask one of the adviser for this</div>";
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
                        <input type="text" name="name" placeholder="Name" value="Ivan">
                    </td>
                </tr>

                <tr>
                    <td>Enter the Quantity: </td>
                    <td>
                        <input type="number" name="qty" value="10">
                    </td>
                </tr>

                <tr>
                    <td>Status: </td>
                    <td>
                        <input type="text" name="status" value="alive">
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
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add People" class="btn-danger">
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
                $status = mysqli_real_escape_string($conn, $_POST['status']);
                $qty = $_POST['qty'];
                

                for ($i = 0; $i < $qty; $i++) {

                    $sql2 = "INSERT INTO rioter SET
                    name='$name',
                    id_universe='$id_universe',
                    status='$status'
                    ";


                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2)
                    {
                        $_SESSION['add'] = "<div class='success'>Rioters Added Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-rioters.php');
                    }
                    else 
                    {
                        $_SESSION['add'] = "<div class='error'>Failed to add Rioters</div>";
                        header('location:'.SITEURL.'admin/add-rioters.php');
                    }
                }
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>