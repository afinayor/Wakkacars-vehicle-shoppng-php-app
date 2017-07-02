<?php
$title="Vehicle Models";
require_once'includes/head.php';
$errors1 = array();
$errors2 = array();
?>
<?php
if (input::exists()) {
    if(input::get('manufacturer_hidden')) {
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'Manufacturer' => array(
                'required' => true,
                'min' => 1,
                'max' => 150
            )
        ));
        if ($validate->passed()) {
            $add_manufacturer = db::getInstance()->insert('addon_makes',array('makes_name'=>input::get('Manufacturer')));

            session::flash('manufacturer', 'You Have Successfully Added A New Vehicle Manufacturer');
            redirect::to('vehiclelist.php');
        } else {
            //output errors
            foreach ($validate->errors() as $error) {
                $errors1[] = $error;
            }
        }
    }
    if(input::get('model_hidden')) {
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'Manufacturer' => array(
                'required' => true,
                'min' => 1,
                'max' => 150
            ),
            'model' => array(
                'required' => true,
                'min' => 1,
                'max' => 150)
        ));
        if ($validate->passed()) {
            $add_model = db::getInstance()->insert('addon_models',array('models_name'=>input::get('model'),'makes_id'=>input::get('Manufacturer')));
            session::flash('manufacturer', 'You Have Successfully Added A New Vehicle Model');
            redirect::to('vehiclelist.php');
        } else {
            //output errors
            foreach ($validate->errors() as $error) {
                $errors2[] = $error;
            }
        }
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
                        Vehicle List Manager
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Vehicle List
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <?php

            if(session::exists('manufacturer')){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php
                            echo '<p><i class="fa fa-check-square"></i> '.session::flash('manufacturer').'</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            <?php
            }
            ?>


            <div class="row">
                <div class="col-xs-12 col-md-6">
                        <div class="panel panel-primary">
                              <div class="panel-heading">
                                    <h3 class="panel-title">Add Manufacturer</h3>
                              </div>
                              <div class="panel-body">
                                  <?php
                                  if(count($errors1)>0){
                                      foreach($errors1 as $err) {
                                          $err = str_replace('_',' ',$err);
                                          $err = ucwords($err);
                                          ?>
                                          <div class="alert alert-danger">
                                              <button type="button" class="close" data-dismiss="alert"
                                                      aria-hidden="true">&times;</button>
                                              <strong><?php echo $err; ?></strong>
                                          </div>

                                      <?php
                                      }
                                  }
                                  ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" role="form">

                                        <div class="form-group">
                                            <label for="Manufacturer">Manufacturer Name</label>
                                            <input type="text" class="form-control" name="Manufacturer" id="" placeholder="">
                                        </div>


                                        <input name="manufacturer_hidden" type="hidden" value="true"/>
                                        <button type="submit"  class="btn btn-primary">Submit</button>
                                    </form>
                              </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-primary">
                	  <div class="panel-heading">
                			<h3 class="panel-title">Add model</h3>
                	  </div>
                	  <div class="panel-body">
                          <?php
                          if(count($errors2)>0){
                              foreach($errors2 as $err) {
                                  $err = str_replace('_',' ',$err);
                                  $err = ucwords($err);
                                  ?>
                                  <div class="alert alert-danger">
                                      <button type="button" class="close" data-dismiss="alert"
                                              aria-hidden="true">&times;</button>
                                      <strong><?php echo $err; ?></strong>
                                  </div>

                              <?php
                              }
                          }
                          ?>
                			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" role="form">

                				<div class="form-group">
                					<label for="">Manufacturers</label>
                                    <select name="Manufacturer" id="Manuc" class="form-control">
                                    	<option value=""> -- Select One -- </option>
                                        <?php
                                            $models = new model();
                                        foreach($models->manufacturers() as $model){
                                            echo "$model";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Model Name</label>

                                    <input type="text" name="model" class="form-control" id="model" placeholder="">
                                    <input name="model_hidden" type="hidden" value="true"/>

                                </div>



                				<button type="submit" class="btn btn-primary">Submit</button>
                			</form>
                	  </div>
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
