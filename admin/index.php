<?php
    $title="Home";
    require_once'includes/head.php';
    $sms = new sms;
$no_of_admin = db::getInstance()->query('SELECT * FROM adminusers',array())->count();
$no_of_topics = db::getInstance()->query('SELECT * FROM new_vehicles',array())->count();
$no_of_users = db::getInstance()->query('SELECT * FROM users',array())->count();
$no_of_messages = db::getInstance()->query('SELECT * FROM messages WHERE unread=0')->count();
$getClick = db::getInstance()->get('pageclick',array('page_name','=','admin'))->first();

$new = $getClick->no + 1;
$pageclick = db::getInstance()->update('pageclick',$getClick->id,array('no'=>$new));

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
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

 <?php
    include_once'includes/flashing.php';
 ?>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $no_of_admin ?></div>
                                        <div>Registered Admins!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="manageadmin.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $no_of_users; ?></div>
                                        <div>Registered Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="manageusers.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $no_of_topics ?></div>
                                        <div>Vehicles</div>
                                    </div>
                                </div>
                            </div>
                            <a href="managevehicles.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-mail-forward fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $no_of_messages ?></div>
                                        <div>Unread messages</div>
                                    </div>
                                </div>
                            </div>
                            <a href="messages.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Messages</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">

                    </div>
                    <div class="col-lg-3 col-md-6">

                    </div>
                <!-- /.row -->
                    <?php
                    if($admin->detail()->smsUsername && $admin->detail()->smsPassword){
                        ?>

                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-phone fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo ceil($sms->sms_balance()); ?></div>
                                            <div>SMS Unit</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="messages.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Messages</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">

                        </div>
                        <div class="col-lg-3 col-md-6">

                        </div>

                        <?php
                    }


                    ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
<?php
    require_once'includes/scripts.php';
?>
