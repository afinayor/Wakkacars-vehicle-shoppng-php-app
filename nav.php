<?php
$linkarray = explode('/',$_SERVER['PHP_SELF']);

$activelink = end($linkarray);
?>
<nav class="navbar navbar-inverse navbar-fixed-top <?php if($activelink == "index.php" || $activelink == "login.php" || $activelink == "register.php" || $activelink == "changepassword.php"){echo "navbar-transparent";} ?>" role="navigation">
    <div class="container" style="padding-left: 5px;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            $admin = new admin();
            $user = new user();
            ?>
            <a class="navbar-brand" href="index.php"><?php echo $admin->detail()->website_name; ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li <?php if($activelink == "index.php"){echo "class='active'";} ?> ><a href="index.php"><i class="pe-7s-home"></i><p>Home</p></a></li>
                <li <?php if($activelink == "about.php"){echo "class='active'";} ?>><a href="about.php"><i class="pe-7s-info"></i><p>About</p></a></li>
                <li <?php if($activelink == "contact.php"){echo "class='active'";} ?>><a href="contact.php"><i class="pe-7s-mail"></i><p>Contact</p></a></li>
                <li <?php if($activelink == "search.php"){echo "class='active'";} ?>><a href="search.php"><i class="pe-7s-search"></i><p>Search</p></a></li>
                <li <?php if($activelink == "gallery.php"){echo "class='active'";} ?>><a href="gallery.php"><i class="pe-7s-photo-gallery"></i><p>Gallery</p></a></li>

                <?php
                if(!$user->isLoggedIn()) {
                    ?>
                    <li <?php if ($activelink == "login.php") {
                        echo "class='active'";
                    } ?>><a href="login.php"><i class="pe-7s-id"></i>

                            <p>Login</p></a></li>
                <?php
                }else{

                ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="pe-7s-user"></i>
                            <p>Account</p>
                        </a>
                        <ul class="dropdown-menu">
<!--                            <li><a href="profile.php">Profile</a></li>-->
                            <li><a href="wishlist.php">My Wishlist</a></li>
                            <li><a href="changepassword.php">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>

                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
