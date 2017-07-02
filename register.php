<?php
require_once'core/init.php';
$user = new user();
if($user->isLoggedIn()){
    redirect::to('index.php');
}
$title = "Register";
$admin = new admin();

$meta1 = "<meta name='title' content='Register| ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='register or signup page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale,contact us, affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);

//coding the register page.

if(input::exists()){//checking if a form has been submitted

    //checking for token
    if(token::check(input::get('token'))){
        $validate = new validate();

        $validation = $validate->check($_POST,array(
           'username' => array(
               'required' => true,
               'min' => 2,
               'max' => 25,
               'unique' => 'users'
           ),
            'email' => array(
                'required' => true,
                'min' => 3,
                'max' => 50,
                'mail' => true,
                'unique' => 'users'
            ),
            'phone' => array(
                'required' => true,
                'min' => 5,
                'max' => 15
            ),
            'password' => array(
                'required' => true,
                'min' => 3,
                'max' => 30
            ),'retype_password'=>array(
                'required' => true,
                'min' => 3,
                'max' => 30,
                'matches' => 'password'
            )
        ));

        if($validate->passed()){
            //after validation of input fields is passed. we proceed to sending to the database
            $user = new user();

            $salt = hash::salt(32);

            try{
                $user->create(array(
                    'username' => input::get('username'),
                    'email' => input::get('email'),
                    'phone' => input::get('phone'),
                    'password' => hash::make(input::get('password'),$salt),
                    'salt' => $salt,
                    'joined' => date('Y-m-d H:i:s')

                ));
            }catch(Exception $e){
                die($e->getMessage());
            }
            session::flash('login','You registered successfully. You can now login!');
            redirect::to('login.php');




        }else{
            foreach ($validate->errors() as $error) {
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

        <div class="signup" style="margin-top: 10px">
            <h2>Register</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
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
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="">
                </div>
                <div class="form-group">
                    <label for="retype_password" >Retype Password</label>
                    <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="">
                </div>


                <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">




                <button type="submit" class="btn btn-primary submit">Submit</button>
            </form>
            <div class="forgot">
                Already have an account? <a href="login.php" class="register">Login</a>
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
