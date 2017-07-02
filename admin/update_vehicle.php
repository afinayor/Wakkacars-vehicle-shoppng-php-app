<?php
$title="Update Vehicle";
require_once'includes/head.php';
$errors = array();
if(input::get('id')){
    if(input::get('id')!= "" && db::getInstance()->query('SELECT id FROM new_vehicles WHERE id = ?',array(input::get('id')))->count() > 0){
        $id = input::get('id');
        $data = db::getInstance()->query('SELECT * FROM new_vehicles WHERE id = ?',array(input::get('id')))->first();
    }else{
        redirect::to(404);
    }
}else{
    redirect::to(404);
}
if (input::exists()) {
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'required' => true,
                'min' => 2,
                'max' => 150
            ),
            'discription' => array(

            ),
            'type' => array(
                'required' => true,
                'min' => 1
            ),
            'price' => array(
                'required' => true,
                'max' => 50
            ),
            'manufacturer' => array(
                'required' => true,
                'min' => 1,
                'max' => 30

            ),
            'model' => array(
                'required' => true,
                'min' => 1,
                'max' => 30
            ),
            'transmission' => array(
                'required' => true,
                'min' => 5,
                'max' => 15
            ),
            'condition' => array(
                'required' => true,
                'min' => 1,
                'max' => 30
            ),
            'year' => array(
                'required' => true,
                'min' => 1,
                'max' => 15
            ),
            'mileage' => array(
                'max' => 20
            )
        ));
        if ($validate->passed()) {
            $manuc =  db::getInstance()->query('SELECT makes_name FROM addon_makes WHERE makes_id = ?',array(input::get('manufacturer')))->first();
            echo "<script>alert('".$manuc->makes_name."')</script>";
//            //register user
            $user = new user();

            $salt = hash::salt(32);

            try{
                $user->updatecar($id,array(
                    'title' => input::get('title'),
                    'discription' => input::get('discription'),
                    'type' => input::get('type'),
                    'price' => input::get('price'),
                    'manufacturer' => $manuc->makes_name,
                    'model' => input::get('model'),
                    'transmission' => input::get('transmission'),
                    'condition' => input::get('condition'),
                    'model_year' => input::get('year'),
                    'mileage' => input::get('mileage')

                ));
            }catch(Exception $e){
                die($e->getMessage());
            }

            session::flash('home','You Have Successfully Updated The Vehicle');
            redirect::to('index.php');
        } else {
            //output errors
            foreach ($validate->errors() as $error) {
                $errors[] = $error;
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
                        Update Vehicle
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Basic Info</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if(count($errors)>0){
                            foreach($errors as $err) {
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
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id; ?>" method="post" role="form">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control input-lg" name="title" id="" value="<?php echo $data->title; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="redactor_content" >Description</label>
                                    <textarea id="redactor_content" name="discription">
<?php echo $data->discription; ?>
                                    </textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label">Type</label>
                                        <div class="">
                                            <select name="type" id="type" class="form-control input-lg">
                                                <option value="">Type</option>
                                                <option <?php if($data->type == "Sedan"){echo "selected";} ?> value="Sedan" >Sedan</option>
                                                <option <?php if($data->type == "Coupe"){echo "selected";} ?> value="Coupe" >Coupe</option>
                                                <option <?php if($data->type == "Sports Car"){echo "selected";} ?> value="Sports Car" >Sports Car</option>
                                                <option <?php if($data->type == "Luxury Car"){echo "selected";} ?> value="Luxury Car" >Luxury Car</option>
                                                <option <?php if($data->type == "SUV"){echo "selected";} ?> value="SUV" >SUV</option>
                                                <option <?php if($data->type == "Van"){echo "selected";} ?> value="Van" >Van</option>
                                                <option <?php if($data->type == "Truck"){echo "selected";} ?> value="Truck" >Truck</option>


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">

                                    <div class="form-group">
                                        <label for="price" class="control-label">Price</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">₦</span>
                                            <input type="number" value="<?php echo $data->price; ?>" id="price" name="price" value="0" placeholder="Total Price" class="form-control input-lg">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="manufacturer" class="control-label">Manufacturer</label>
                                    <div class="">
                                        <select name="manufacturer" id="brand" onchange="up()" class="form-control input-lg">
                                            <option value="">Manufacturer</option>
                                            <?php
                                                $makes = new model();

                                                $makes_array = $makes->manufacturer_update($data->manufacturer);

                                                foreach($makes_array as $make){
                                                        echo $make;
                                                }


                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="model" class="control-label">Model</label>
                                    <div class="">
                                        <select name="model" id="model" class="form-control input-lg">
                                            <option value="">Model</option>
                                            <?php

                                                    $model_array = $makes->models_update($data->model);
                                                    foreach($model_array as $model){
                                                        echo $model;
                                                    }


                                            ?>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="transmission" class="control-label">Transmission</label>
                                    <div class="">
                                        <select name="transmission" id="transmission" class="form-control input-lg">
                                            <option  value="">Transmission</option>
                                            <option <?php if($data->transmission == "Automatic"){echo "selected";} ?> value="Automatic">Automatic</option>
                                            <option <?php if($data->transmission == "Manual"){echo "selected";} ?> value="Manual">Manual</option>
                                            <option <?php if($data->transmission == "Semi Automatic"){echo "selected";} ?> value="Semi Automatic">Semi Automatic</option>
                                            <option <?php if($data->transmission == "Other"){echo "selected";} ?> value="Other">Other</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="condition" class="control-label">Condition</label>
                                    <div class="">
                                        <select name="condition" id="condition" class="form-control input-lg">
                                            <option value="">condition</option>
                                            <option <?php if($data->condition == "new"){echo "selected";} ?> value="new">New</option>
                                            <option <?php if($data->condition == "used"){echo "selected";} ?> value="used">Used</option>
                                            <option <?php if($data->condition == "pre_owned"){echo "selected";} ?> value="pre_owned">Certified Pre Owned</option>
                                            <option <?php if($data->condition == "recondition"){echo "selected";} ?> value="recondition">Recondition</option>
                                            <option <?php if($data->condition == "Other"){echo "selected";} ?> value="other">Other</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="from" class="control-label">Model Year</label>
                                    <select name="year" id="from" class="form-control input-lg">
                                        <option  value="">Year</option>
                                        <?php
                                        foreach(years::updatelistYears($data->model_year) as $year){
                                            echo $year;
                                        }
                                        ?>      </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="Mileage" class="control-label">Mileage</label>

                                    <div class="">

                                        <div class="input-group">
                                            <span class="input-group-addon">kms</span>
                                            <input type="number" id="Mileage"
                                                   placeholder="Mileage"  name="mileage" value="<?php echo $data->mileage; ?>" placeholder="Mileage" class="form-control input-lg">
                                        </div>



                                    </div>

                                </div>

                            </div>

                            <script type="text/javascript">
                                function up(){
                                    for(i = 0;i< document.getElementById('model').length;i++)
                                    {
                                        document.getElementById('model').options[i].style.display = "inline";
                                    }
                                    var val = document.getElementById('brand').value;
                                    if(val!='') {

                                        for(i = 0;i< document.getElementById('model').length;i++)
                                        {
                                            if(document.getElementById('model').options[i].className != "model-"+val)
                                            {
                                                document.getElementById('model').options[i].style.display = "none";
                                            }
                                        }
                                    }

                                }
                            </script>
                            <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

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
