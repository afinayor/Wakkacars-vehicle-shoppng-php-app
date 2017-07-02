<?php
$title="My Profile";
require_once'includes/head.php';

    if(!$username = input::get('user')){
        redirect::to('index.php');
    }else{
        $user = new user($username);
        if(!$user->exists()){
            redirect::to(404);
        }else{
            $data = $user->data();
        }
    }
?>
<body>

<div id="wrapper">

    <?php
    require_once'includes/navigation.php';
    ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        My Profile
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-bar-chart-o"></i> Profile
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="update.php" style="margin-bottom: 5px" class="btn btn-success">Update Profile</a>
                    <dl class="dl-horizontal">


                        <dt> Name:</dt> <dd><?php echo escape($user1->name) ?></dd>


                        <dt>Username:</dt> <dd><?php echo escape($user1->username) ?></dd>


                        <dt>Email:</dt><dd> <?php echo escape($user1->email) ?></dd>

                        <dt>Phone: </dt><dd><?php echo escape($user1->phone) ?></dd>
                    </dl>
                </div>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<?php
require_once'includes/scripts.php';
?>
