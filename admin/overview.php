<?php
$title="Overview";
require_once'includes/head.php';
$value = db::getInstance()->query('SELECT * FROM overview WHERE 1',array())->first();
if (input::exists()) {
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'website_name' => array(
                'required' => true,
                'min' => 1,
                'max' => 30

            ),'website_url' => array(
                'required' => true,
                'min' => 1,
                'max' => 50

            ),
            'discription' => array(
                'required' => true,
                'min' => 6,
                'max' => 200
            ),
            'email' => array(
                'required' => true,
                'min' => 3,
                'max' => 50,
                'mail' => true
            ),
            'phone' => array(
                'required' => true,
                'min' => 5,
                'max' => 15
            ),
            'facebook' => array(
            'min' => 2,
            'max' => 50
            ),
            'twitter' => array(
                'min' => 2,
                'max' => 50
            ), 'google+' => array(
                'min' => 2,
                'max' => 50
            ),'webmail_username' =>array(
                'min' => 3,
                'max' => 50,
                'mail' => true
            ),'webmail_password' =>array(
                'min' => 3,
                'max' => 50
            ),'sms_username' =>array(
                'min' => 3,
                'max' => 50

            ),'sms_password' =>array(
                'min' => 3,
                'max' => 50
            )
        ));
        if ($validate->passed()) {
            $update = db::getInstance()->update('overview',1,array('name' => input::get('website_name'),
                'url' => input::get('website_url'),
                'discription' => input::get('discription'),'email'=>input::get('email'),
                'phone'=>input::get('phone'),'facebook'=>input::get('facebook'),'twitter'=>input::get('twitter'),
                'googleplus'=>input::get('google+'),'webmail_username'=>input::get('webmail_username'),
                'webmail_password'=>input::get('webmail_password'),'sms_username'=>input::get('sms_username'),
                'sms_password'=>input::get('sms_password')));

                session::flash('home', 'You have succesfully edited the website details!');
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
                        Overview
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <form action="" method="post" role="form">


                        <div class="form-group">
                            <label for="">Website Name</label>
                            <input type="text" class="form-control" name="website_name" id="" value="<?php if(!empty($value->name)){echo $value->name ;} ?>" placeholder="Website Name">
                        </div>
                        <div class="form-group">
                            <label for="">Website URL</label>
                            <input type="url" class="form-control" name="website_url" id="" value="<?php if(!empty($value->url)){echo $value->url ;} ?>" placeholder="Website url">
                        </div>
                        <div class="form-group">
                            <label for="">Short Discription</label>

                            <textarea class="form-control"  name="discription"><?php if(!empty($value->discription)){echo $value->discription ;} ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" id="" value="<?php if(!empty($value->email)){echo $value->email ;} ?>" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" id="" value="<?php if(!empty($value->phone)){echo $value->phone ;} ?>" placeholder="Phone">
                        </div>
                        <div class="form-group">
                            <label for="">Facebook</label>
                            <input type="text" class="form-control" name="facebook" id="" value="<?php if(!empty($value->facebook)){echo $value->facebook ;} ?>" placeholder="Facebook Username">
                        </div>
                        <div class="form-group">
                            <label for="">Twitter</label>
                            <input type="text" class="form-control" name="twitter" id="" value="<?php if(!empty($value->twitter)){echo $value->twitter ;} ?>" placeholder="Twitter">
                        </div>
                        <div class="form-group">
                            <label for="">Google+</label>
                            <input type="text" class="form-control" name="google+" id="" value="<?php if(!empty($value->googleplus)){echo $value->googleplus ;} ?>" placeholder="Google+">
                        </div>
                        <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <div class="panel panel-primary">
                        	  <div class="panel-heading">
                        			<h3 class="panel-title">Email Settings</h3>
                        	  </div>
                        	  <div class="panel-body">
                                  <div class="form-group">
                                      <label for="webmail username"  class="control-label">Webmail Mail</label>

                                          <input type="text" class="form-control" id="" name="webmail_username"value="<?php if(!empty($value->webmail_username)){echo $value->webmail_username ;} ?>">

                                  </div>
                                  <div class="form-group">
                                      <label for="webmail password"  class="control-label">Webmail Password</label>

                                      <input type="password" class="form-control" id="" name="webmail_password" value="<?php if(!empty($value->webmail_password)){echo $value->webmail_password ;} ?>">

                                  </div>

                              </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">SMS Settings</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="sms username"  class="control-label">Username</label>

                                    <input type="text" class="form-control" id="" name="sms_username"value="<?php if(!empty($value->sms_username)){echo $value->sms_username ;} ?>">

                                </div>
                                <div class="form-group">
                                    <label for="sms password"  class="control-label">Password</label>

                                    <input type="password" class="form-control" id="" name="sms_password" value="<?php if(!empty($value->sms_password)){echo $value->sms_password ;} ?>">

                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
            </div>
                <div class="col-sm-6 col-md-6">

                    <?php

                    if(!empty($errors)){
                        foreach ($errors as $err){
                            $err = str_replace('_',' ',$err);
                            echo "<div class='alert alert-danger'>
                    <strong>$err</strong>
                </div>";
                        }
                    }
                    ?>
                </div>

            <!-- /.row -->
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<?php
require_once'includes/scripts.php';
?>
