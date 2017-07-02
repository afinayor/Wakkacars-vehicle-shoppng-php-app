<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:05
 */
require_once 'core/init.php';
$admin = new admin();
$errors = array();
if(input::exists()){
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST,array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
        if($validation->passed()){
            //log in
            $user = new user();
            $remember = (input::get('remember')==='on') ? true : false;
            $login = $user->login(input::get('username'),input::get('password'),$remember);

            if($login){
                session::flash('home','You logged in successfully!');
                redirect::to('index.php');

            }else{
                $errors[] = "Wrong Username or Password";
            }
        }else{
            foreach($validation->errors() as $error){
                $errors[] = $error;
            }
        }
    }
}

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title>Login Admin</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/templatemo_main.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="main-wrapper">
    <div class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <div class="logo"><h1><?php echo $admin->detail()->website_name; ?></h1></div>
        </div>
    </div>
    <div class="template-page-wrapper">
        <h2 style="text-align: center">ADMIN LOGIN</h2>
        <form class="form-horizontal templatemo-signin-form" role="form" action="" method="POST">
            <?php
            if(!empty($errors)) {
                foreach($errors as $err) {
                    ?>

                    <div class="alert alert-danger">
                        <?php echo $err; ?>
                    </div>

                <?php
                }

            }

            ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input  type="text" placeholder="Username"  class="form-control" name="username" id="username" autocomplete="off"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit"  value="Login" name="login" />
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
</body>
</html>