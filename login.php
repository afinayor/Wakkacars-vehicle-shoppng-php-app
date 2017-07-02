<?php
require_once'core/init.php';
$title = "Login";
$user = new user();
if($user->isLoggedIn()){
    redirect::to('index.php');
}
$admin = new admin();

$getClick = db::getInstance()->get('pageclick',array('page_name','=','login'))->first();
$new = $getClick->no + 1;
$pageclick = db::getInstance()->update('pageclick',$getClick->id,array('no'=>$new));

$meta1 = "<meta name='title' content='Sign In | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='Sign In or Login page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale,contact us, affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);


//login logic

if(input::exists()){

    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST,array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));
        if($validate->passed()){

            //log in
            $user = new user();
            $remember = (input::get('remember')==='on') ? true : false;
            $login = $user->login(input::get('username'),input::get('password'),$remember);

            if($login){
//                  session::flash('home','You logged in successfully!');
                redirect::to('index.php');

            }else{
                $errors[] = "Wrong Username or Password";
            }

        }else{
            foreach($validate->errors() as $error){
                $errors[] = $error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once'head.php';
?>

<body>

<?php
include_once'nav.php';

?>

    <header style="padding: 6em 0 0 0;">
        <div class="container">

                    <div class="signup">
                                <h2>Login</h2>
                        <?php

                        if(session::exists('login')){
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert" style="background-color: greenyellow">

                                        <?php
                                        echo '<p style="font-size: 15px;"><i class="fa fa-check-square"></i> '.session::flash('login').'</p>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        <?php
                        }
                        ?>
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
                                    <?php
                                    if(isset($errors) && count($errors)>0){
                                        foreach($errors as $err) {
                                            $err = str_replace('_',' ',$err);
                                            $err = ucwords($err);
                                            ?>
                                            <div class="alert alert-danger">
                                                <strong><?php echo $err; ?></strong>
                                            </div>

                                        <?php
                                        }
                                    }

                                    ?>

                                   <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="">
                                    </div>


                                    <div class="form-group" >
                                        <span> <input type="checkbox" name="remember" id="remember" style="height: 14px">Remember me</span>
                                    </div>

                                    <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">



                                    <button type="submit" class="btn btn-primary submit">Submit</button>
                                </form>
                        <div class="forgot">
                            Dont have an account yet? <a href="register.php" class="register">Register</a>
                        </div>
                   </div>

            <div class="copy" class="row">
                <p>&copy; All right reserved. Built by <a href="http://www.developer.wakkacars.com">Demayor</a></p>
            </div>
        </div>

    </header>
<?php
//include_once'footer.php';
?>

<!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/ct-navbar.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="js/myscript.js"></script>
</body>
</html>
