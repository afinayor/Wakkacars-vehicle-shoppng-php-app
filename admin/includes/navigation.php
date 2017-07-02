<?php

$linkarray = explode('/',$_SERVER['PHP_SELF']);

$activelink = end($linkarray);



   $user1 = db::getInstance()->query('SELECT * FROM adminusers WHERE id = ?', array(session::get(config::get('session/session_name'))))->first();



    $username = $user1->username;
    $admin = new admin();
?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html"><?php echo $admin->detail()->website_name; ?></a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo escape($username); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php?user=<?php echo escape($username); ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                </li>
                <li>
                    <a href="changepassword.php"><i class="fa fa-fw fa-key"></i> Change Password</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li <?php if($activelink=="index.php"){echo "class='active'";} ?> >
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li <?php if($activelink=="overview.php"){echo "class='active'";} ?> >
                <a href="overview.php"><i class="fa fa-fw fa-recycle"></i> Overview</a>
            </li>
            <li <?php if($activelink=="messages.php"){echo "class='active'";} ?> >
                <a href="messages.php"><i class="fa fa-fw fa-mail-forward"></i> Messages</a>
            </li>
            <li <?php if($activelink=="profile.php"){echo "class='active'";} ?>>
                <a href="profile.php?user=<?php echo $username; ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Profile</a>
            </li>
            <li <?php if($activelink=="manageadmin.php"){echo "class='active'";} ?> >
                <a href="manageadmin.php"><i class="fa fa-fw fa-wrench"></i> Manage Admin</a>
            </li>
            <li <?php if($activelink=="addcar.php"){echo "class='active'";} ?> >
                <a href="addcar.php"><i class="fa fa-fw fa-car"></i> Add Vehicle</a>
            </li>
            <li <?php if($activelink=="managevehicles.php"){echo "class='active'";} ?> >
                <a href="managevehicles.php"><i class="fa fa-fw fa-gears"></i> Manage Vehicles</a>
            </li>
            <li <?php if($activelink=="manageusers.php"){echo "class='active'";} ?> >
                <a href="manageusers.php"><i class="fa fa-fw fa-users"></i> Manage Users</a>
            </li>
            <li <?php if($activelink==""){echo "class='active'";} ?> >
                <a href="../"><i class="fa fa-fw fa-file"></i> Home Page</a>
            </li>
            <li <?php if($activelink=="changepassword.php"){echo "class='active'";} ?> >
                <a href="changepassword.php"><i class="fa fa-fw fa-key"></i> Change Password</a>
            </li>
            <li <?php if($activelink=="pages.php"){echo "class='active'";} ?> >
                <a href="pages.php"><i class="fa fa-fw fa-comment-o"></i> Pages</a>
            </li>


            <li <?php if($activelink=="logout.php"){echo "class='active'";} ?> >
                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Logout</a>
            </li>

        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
