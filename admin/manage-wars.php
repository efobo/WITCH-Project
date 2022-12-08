<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
           <?php
                if (isset($_SESSION['battle']))
                {
                    echo $_SESSION['battle'];
                    echo '<br><br>';
                    unset($_SESSION['battle']);
                }
                if (isset($_SESSION['riot']))
                {
                    echo $_SESSION['riot'];
                    echo '<br><br>';
                    unset($_SESSION['riot']);
                }
                if (isset($_SESSION['msg']))
                {
                    echo $_SESSION['msg'];
                    echo '<br><br>';
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['news']))
                {
                    echo $_SESSION['news'];
                    echo '<br><br>';
                    unset($_SESSION['news']);
                }
            ?>
            <a href="<?php echo SITEURL;?>admin/start-battle.php">
                <div style="width: 20%;" class="col-3 text-center" >
                    <h1>Start the Battle</h1>
                </div>
            </a>
            
            <a href="<?php echo SITEURL;?>admin/quell-riot.php">
                <div class="col-3 text-center">
                    <h1>Quell the Riot</h1>
                </div>
            </a>

            
            <div class="clearfix"></div>
            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>