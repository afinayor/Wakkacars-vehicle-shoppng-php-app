<?php
$title="Manage Vehicles";
require_once'includes/head.php';
$datatable = "true";

$datas = db::getInstance()->query('SELECT * FROM new_vehicles ORDER BY id DESC',array())->results();

if(isset($_GET['pub']) && isset($_GET['id'])){
    if($_GET['pub']== 'no'){
        $change = db::getInstance()->update('new_vehicles',$_GET['id'], array('publish'=>0));
//        if($change) {
            session::flash('allcars', 'This car has been un-published.');
            redirect::to('managevehicles.php');
//        }
    }elseif($_GET['pub']== 'yes'){
        $change = db::getInstance()->update('new_vehicles',$_GET['id'], array('publish'=>1));
//        if($change) {
            session::flash('allcars', 'This vehicle has been published');
            redirect::to('managevehicles.php');
//        }
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
                        Manage Vehicles
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Page
                        </li>
                    </ol>
                </div>
            </div>

            <?php

            if(session::exists('allcars')){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php
                            echo '<p><i class="fa fa-check-square"></i> '.session::flash('allcars').'</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            <?php
            }
            ?>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="height:54px;">
                            <span style="font-size: 23px">All Vehicles</span>
                            <a href="vehiclelist.php"><button type="button" class="btn btn-success pull-right">Car Model List</button></a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Transmission</th>
                                        <th>Condition</th>
                                        <th>Share</th>
                                        <th>Publish</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i= 0;

                                        foreach($datas as $data){
                                            $i++;
//                                            $images = db::getInstance()->get('gallery',array('vehicle_id','=',$data->id))->count();
                                            $images = db::getInstance()->query('SELECT * FROM gallery WHERE vehicle_id = ?',array($data->id));
                                            $images = $images->count();

//                                            echo "<script>alert('".$images."')</script>";
                                            if($images>0){
                                                $image = db::getInstance()->query('SELECT * FROM gallery WHERE vehicle_id = ?',array($data->id))->first();
                                                $image = $image->name;
                                                $image = "<img src='images/uploads/".$image."' class='thumbnail' style='width:100px;margin-bottom:0px;' >";
                                            }else{
                                                $image = "No Image";
                                            }

                                            if($data->publish == 1){
                                                $publish = "<a href='".$_SERVER['PHP_SELF']."?pub=no&id=".$data->id."'><button class='btn btn-success'>Yes</button></a>";
                                            }else{
                                                $publish = "<a href='".$_SERVER['PHP_SELF']."?pub=yes&id=".$data->id."'><button class='btn btn-danger'>No</button></a>";
                                            }

                                            $link = $admin->detail()->website_url."/details.php?no=".hash::encode($data->id);
                                            echo "<tr class='odd gradeX'>
                                        <td>$i</td>
                                        <td>$data->title</td>
                                        <td>$image</td>
                                        <td>$data->type</td>
                                        <td>&#8358;$data->price</td>
                                        <td>$data->transmission</td>
                                        <td>$data->condition</td>
                                        <td><button class='btn btn-warning' data-toggle='modal' data-target='#$data->id'>Link</button></td>
                                        <td>$publish</td>
                                        <td>
<div class='btn-group'>

                      <a class='btn btn-info dropdown-toggle' data-toggle='dropdown' href='ui_button.html#'><i class='fa fa-cog'></i> Action <span class='caret'></span></a>

                      <ul class='dropdown-menu dropdown-info'>
                                                    <li><a href='gallery.php?id=".$data->id."'>Add Gallery</a></li>
                                                    <li><a href='update_vehicle.php?id=".$data->id."'>Edit</a></li>
                                                    <li><a href='delete.php?id=".$data->id."'>Delete</a></li>


                      </ul>
</div></td>
                                    </tr>


                                    <div class='modal fade' id='$data->id'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <!-- Modal Header -->
                <div class='modal-header'>
                    <button type='button' class='close'data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Copy this link for sharing!</h4>
                </div>
                <!-- Modal Body -->
                <div class='modal-body'>
                    <a href='$link'>$link</a>
                </div>
                <!-- Modal Footer -->

            </div>
        </div>
    </div>";


                                        }


                                    ?>


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            <!-- /.row -->


            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



</div>
<?php
require_once'includes/scripts.php';
?>

