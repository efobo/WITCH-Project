<?php include('partials-front/menu.php'); ?>


    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
                <div class="food-search-box text-center">

                <?php 

                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                
                ?>
                
                <h2>Foods on Your Search <a href="#">"<?php echo $search; ?>"</a></h2>
            </div>
        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php

               
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);
                if ($count > 0)
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];

                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                
                                if ($image_name == "")
                                {
                                    echo "<div class='error'>Image not Available</div>";
                                }
                                else
                                {
                                    ?>

                                    <img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">

                                    <?php
                                }
                                ?>
                                
                            </div>
                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>
                                <a href="order.html" class="btn btn-primary">Order now</a>
                            </div>

                            <div class="clearfix"></div>

                        </div>

                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>Food not Found</div>";
                }
            
            ?>
            
           
            <div class="clearfix"></div>
            
        </div>

        <p class="text-center">
            <a href="#">See All Menu</a>
        </p>
    </section>
    <!-- Food Menu Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>

