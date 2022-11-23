<?php include('partials-front/menu.php'); ?>

<?php

    if (isset($_GET['food_id']))
    {
        $food_id = $_GET['food_id'];

        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);
        if ($count==1)
        {
            $row = mysqli_fetch_assoc($res);
            
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
            
        }
        else
        {
            header('location:'.SITEURL); 
        }
    }
    else
    {
        header('location:'.SITEURL);
    }
?>


     <!-- Food Search Section Starts Here -->
     <section class="order-area text-center">
        <div class="container">

            <h2 class="text-center">Fill this form to confirm your order</h2>
            <br><br>
            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>
                    
                    <br>

                    <div class="food-menu-img">
                        <?php
                        
                        if ($image_name == "")
                        {
                            echo "<div class='error'>Image not Available</div>";
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL;?>img/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                        
                    </div>

                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend>Delivery Details</legend>

                    <br>

                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Mary Johnson" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="89000000000" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="email@mail.ru" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
            </form>

            <?php
            
                if (isset($_POST['submit']))
                {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;

                    $order_date = date("Y-m-d h:i:s");


                    
                    $status = "Ordered";

                    $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
                    $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
                    $customer_email = $_POST['email'];
                    $customer_address = mysqli_real_escape_string($conn, $_POST['address']);

                    $sql2 = "INSERT INTO tbl_order SET
                        food='$food',
                        price=$price,
                        qty=$qty,
                        total=$total,
                        order_date='$order_date',
                        status='$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                        ";
                        //echo $sql2; die();
                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2)
                    {
                        $_SESSION['order'] = "<div class='success text-center'>Dish Ordered Successfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Dish</div>";
                        header('location:'.SITEURL);
                    }

                }
            ?>
        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>