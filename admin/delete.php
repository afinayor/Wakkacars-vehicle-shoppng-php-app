<?php
$title="Delete";
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
                        Delete
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-remove"></i> Delete
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    $show_del="show";
                    if(input::get('adm')){
                        $show_del="show";

                        if(isset($_POST['sub_del'])){
                            if(@$_POST['delete']=='no'){
                                echo "<p class='alert alert-success'>Member Not Deleted.</p>";
                                $show_del="no";
                                header("Refresh:5 ; url=manageadmin.php");
                            }elseif(@$_POST['delete']=='yes'){
                                $show_del="no";

                                if(db::getInstance()->delete('adminusers',array('id','=',input::get('adm')))){
                                    echo "<p class='alert alert-warning'>Member Has Been Deleted.</p>";
                                    header("Refresh:5 ; url=manageadmin.php");
                                }else{

                                }
                            }else{
                                echo "<p class='alert alert-warning'>Nothing Selected. Please select an option.</p>";
                            }
                        }
                        if($show_del=="show"){



                          ?>
                            <form action='' role='form' method='POST'>
                            <div class="form-group">
                                <p><strong>Are You Sure You Want To Delete This Admin?</strong></p>

                                <label class="radio-inline">
                                    <input type="radio" name="delete" id="delete" value="yes" checked> Yes
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="delete" id="delete" value="no"> No
                                </label>

                            </div>
                                <br /><input type='submit' name='sub_del' />



                    <?php
                    }


                    }elseif(input::get('id')) {
                        //////////////////////////////////////////////////////////////////////////////////////////
                        //deleting the cars
                    if(isset($_POST['veh_del'])){
                        if(@$_POST['delete']=='no'){
                            echo "<p class='alert alert-success'>Vehicle Was Not Deleted.</p>";
                            $show_del="no";
                            header("Refresh:5 ; url=managevehicles.php");
                        }elseif(@$_POST['delete']=='yes'){
                            $show_del="no";

                            if(db::getInstance()->delete('new_vehicles',array('id','=',input::get('id')))){
                                echo "<p class='alert alert-warning'>Vehicle Has Been Deleted.</p>";
                                header("Refresh:5 ; url=managevehicles.php");
                            }else{

                            }
                        }else{
                            echo "<p class='alert alert-warning'>Nothing Selected. Please select an option.</p>";
                        }
                    }
                    if($show_del=="show"){


                    ?>
                                <form action='' role='form' method='POST'>
                                    <div class="form-group">
                                        <p><strong>Are You Sure You Want To Delete This Vehicle?</strong></p>

                                        <label class="radio-inline">
                                            <input type="radio" name="delete" id="delete" value="yes" checked> Yes
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" name="delete" id="delete" value="no"> No
                                        </label>

                                    </div>
                                    <br/><input type='submit' name='veh_del'/>



                                    <?php


                                    }

                                    }elseif(input::get('user')){
                                    $show_del="show";

                                    if(isset($_POST['sub_del'])){
                                        if(@$_POST['delete']=='no'){
                                            echo "<p class='alert alert-success'>User Not Deleted.</p>";
                                            $show_del="no";
                                            header("Refresh:5 ; url=manageusers.php");
                                        }elseif(@$_POST['delete']=='yes'){
                                            $show_del="no";

                                            if(db::getInstance()->delete('users',array('id','=',input::get('user')))){
                                                echo "<p class='alert alert-warning'>User Has Been Deleted.</p>";
                                                header("Refresh:5 ; url=manageusers.php");
                                            }else{

                                            }
                                        }else{
                                            echo "<p class='alert alert-warning'>Nothing Selected. Please select an option.</p>";
                                        }
                                    }
                                    if($show_del=="show"){



                                    ?>
                                    <form action='' role='form' method='POST'>
                                        <div class="form-group">
                                            <p><strong>Are You Sure You Want To Delete This User?</strong></p>

                                            <label class="radio-inline">
                                                <input type="radio" name="delete" id="delete" value="yes" checked> Yes
                                            </label>

                                            <label class="radio-inline">
                                                <input type="radio" name="delete" id="delete" value="no"> No
                                            </label>

                                        </div>
                                        <br /><input type='submit' name='sub_del' />



                                        <?php
                                        }


                                        }

                    ?>


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
