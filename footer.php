<footer class="container">
    <div id="footer1" class="row">
        <div class="col-sm-6 col-md-6">
            <h3>Contact Us</h3>

            <?php
                $admin = new admin();
                echo "<p>".$admin->detail()->phone."</p>";
                echo "<a href='#' style='color: #ffffff;'>".$admin->detail()->email."</a>";
            ?>

        </div>
        <div class="col-sm-6 col-md-6">
            <h3>Follow Us</h3>

            <div class="fablock"><a href="http://www.facebook.com" class="fa fa-facebook"></a></div>
            <div class="fablock"><a href="http://www.twitter.com" class="fa fa-twitter"></a></div>
            <div class="fablock"><a href="http://www.google.com" class="fa fa-google-plus"></a></div>



        </div>
    </div>
    <div id="footer2" class="row">
        <p>&copy; All right reserved. Built by <a href="http://www.developer.wakkacars.com">Demayor</a></p>
    </div>

</footer>