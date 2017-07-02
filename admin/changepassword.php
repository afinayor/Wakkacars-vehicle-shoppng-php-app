<?php
$title="blank page";
require_once'includes/head.php';

if(input::exists()){
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST,array(
            'password_current' =>array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'matches' => 'password_new'
            )
        ));
        if($validation->passed()){
            if(hash::make(input::get('password_current'),$user->data()->salt) !== $user->data()->password){
                $errors[] = "Your current password is wrong.";
            }else{
                $salt = hash::salt(32);
                $user->update(array(
                    'password' => hash::make(input::get('password_new'),$salt),
                    'salt' => $salt
                ));
                session::flash('home','Your password has been updated');
                redirect::to('index.php');
            }
        }else{
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
                        Page Name
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-key"></i> Page
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input class="form-control" type="password" name="password_current" id="current_password">
                            </div>
                            <div class="form-group">
                                <label for="password_new">New Password</label>
                                <input class="form-control" type="password" name="password_new" id="password_new">
                            </div>
                            <div class="form-group">
                                <label for="password_new_again" class="field">New Password Again</label>
                                <input class="form-control" type="password" name="password_new_again" id="password_new_again">
                            </div>
                            <div class="form-group">
                                <input type="submit" type="button" class="btn btn-default" value="Change">
                                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                            </div>

                        </form>

                    </div>
                <div class="col-lg-6">
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
