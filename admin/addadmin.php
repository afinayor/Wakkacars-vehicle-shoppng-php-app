
<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:05
 */
require_once 'core/init.php';




if (input::exists()) {
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'adminusers'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => true,
                'min' => 3,
                'max' => 50,
                'mail' => true,
                'unique' => 'adminusers'
            ),
            'phone' => array(
                'required' => true,
                'min' => 5,
                'max' => 15
            )
        ));
        if ($validate->passed()) {
            //register user
            $user = new user();

            $salt = hash::salt(32);

            try{
                $user->create(array(
                    'username' => input::get('username'),
                    'password' => hash::make(input::get('password'),$salt),
                    'salt' => $salt,
                    'name' => input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1,
                    'email' => input::get('email'),
                    'phone' => input::get('phone')
                ));
            }catch(Exception $e){
                die($e->getMessage());
            }
            session::flash('home','You registered succesfully. You can now login!');
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

<?php
$title="Add New Admin";
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
                        Add New Admin
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-user"></i> Add New Admin
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">

                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" id="username" value="<?php echo escape(input::get('username')); ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="password">Choose a password</label>
                            <input class="form-control" type="password" name="password"  id="password" >
                        </div>
                        <div class="form-group">
                            <label for="password_again">Enter your password again</label>
                            <input class="form-control" type="password" name="password_again"  id="password_again" >
                        </div>
                        <div class="form-group">
                            <label for="name">Choose a name</label>
                            <input class="form-control" type="text" name="name" value="<?php echo escape(input::get('name')); ?>" id="name" >
                        </div>
                        <div class="form-group">
                            <label for="email">Choose an Email</label>
                            <input class="form-control" type="text" name="email" value="<?php echo escape(input::get('email')); ?>" id="email" >
                        </div>
                        <div class="form-group">
                            <label for="phone">Choose a Phone No</label>
                            <input class="form-control" type="text" name="phone" value="<?php echo escape(input::get('phone')); ?>" id="phone" >
                        </div>
                        <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input class="btn btn-default" type="submit" value="Register">
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





<html>
<head></head>
<body>

</body>
</html>