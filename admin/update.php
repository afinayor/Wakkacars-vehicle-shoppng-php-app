<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:04
 * **/
$title="Update Your Details";
require_once'includes/head.php';

if(!$user->isLoggedIn()){
    redirect::to('index.php');
}
if(input::exists()){
    if(token::check(input::get('token'))) {
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => true,
                'min' => 3,
                'max' => 50,
                'email' => true
            ),
            'phone' => array(
                'required' => true,
                'min' => 3,
                'max' => 50
            )
        ));
        if ($validation->passed()) {
            try {
                $user->update(array(
                    'name' => input::get('name'),
                    'email' => input::get('email'),
                    'phone' => input::get('phone')
                ));
                session::flash('home','Your details have been updated.');
                redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }


        }else{
            foreach ($validate->errors() as $error) {
                $errors[] = $error;
            }
        }
    }
}

echo "<body>";
?>

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
                        Update Your Details
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-refresh"></i> Update Details
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-6">
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="<?php echo escape($user->data()->name) ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="<?php echo escape($user->data()->email) ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control" type="text" id="phone" name="phone" value="<?php echo escape($user->data()->phone) ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" type="button" class="btn btn-default" value="update">
                            <input type="hidden" name="token" value="<?php echo token::generate() ?>"/>
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