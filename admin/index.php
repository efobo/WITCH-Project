<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                
            <h1>Hello, <?php echo 'the '.$_SESSION['status'].' '.$_SESSION['name']; ?>!</h1>

            <br><br>

            <h3>Learn the latest news</h3>

            <br><br>


            <?php 
                $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 6";
                $res = mysqli_query($conn, $sql);
                if ($res)
                {
                    $count = mysqli_num_rows($res);
                    if ($count > 0)
                    {
                        while ($row = mysqli_fetch_assoc($res))
                        {
                            $news_date = $row['news_date'];
                            $title = $row['title'];
                            $text = $row['text'];
                            ?>
                            <div class="news-box">
                                <p style="color: grey;"><?php echo $news_date; ?></p>
                                <h4><?php echo $title; ?></h4>
                                <br>
                                <p><?php echo $text;?></p>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        echo "<div>There is no news yet :(</div>";
                    }
                }
                else
                {
                    echo "<div class='error'>News Access error</div>";
                }
            ?>

            
            
            <div class="clearfix"></div>

            </div>
            
        </div>
        <!-- Main Content Section Ends -->

        <?php include('partials/footer.php'); ?>