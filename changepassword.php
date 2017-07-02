<?php
require_once'core/init.php';
$title = "Change Password";
$user = new user();
if(!$user->isLoggedIn()){
    redirect::to('index.php');
}
$admin = new admin();

$meta1 = "<meta name='title' content='Change Password | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='Chage Password of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale,contact us, affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);


//login logic
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
                session::flash('changePword','Your password has been updated');
                redirect::to('changepassword.php');
            }
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

        <div class="signup">
            <h2>Change Password</h2>
            <?php

            if(session::exists('changePword')){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert" style="background-color: greenyellow">

                            <?php
                            echo '<p style="font-size: 15px;"><i class="fa fa-check-square"></i> '.session::flash('changePword').'</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            <?php
            }
            ?>
            <form id="changePword" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
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
                    <label for="current_password">Current Paasword</label>
                    <input type="password" class="form-control" name="password_current" id="current_password" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password_new">New Password</label>
                    <input type="password" class="form-control" name="password_new" id="password_new" placeholder="">
                </div>


                <div class="form-group">
                    <label for="password_new_again">New Password Again</label>
                    <input class="form-control" type="password" name="password_new_again" id="password_new_again">
                </div>

                <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">



                <button type="submit" class="btn btn-primary submit">Submit</button>
            </form>

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
