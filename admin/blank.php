<?php
$title="blank page";
require_once'includes/head.php';
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
                        Page Name
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Page
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

<div class="row">
    <?php

        $mailer = new mymail();

    $black = $mailer->sendmail('testing','message','afotrick2011@gmail.com','agbo@yahoo.com',array('ak@yahoo.com','bayo@yahoo.com'));
    echo $black;
    ?>

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
