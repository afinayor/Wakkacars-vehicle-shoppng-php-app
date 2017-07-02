<?php
require_once'core/init.php';
$title = "Contact Us";
$admin = new admin();

$meta1 = "<meta name='title' content='contact us | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='Contact us page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale,contact us, affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);

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
<section class="container content">
    <article class="row">
        <div class=" col-sm-8  col-md-8 col-lg-offset-1 col-lg-7" id="rightside">
                <h1>Contact Us</h1>
                <?php
                $query = db::getInstance()->query('SELECT * FROM pages WHERE id = 2',array());
                if($query){
                    $data = $query->first();
                    $content = $data->content;
                }else{
                    $content = "";
                }
                echo $content;
                ?>
        </div>
        <div class=" col-sm-4 col-md-4 col-lg-3 contact-left" >
            <?php
            if(input::exists()) {
                if (token::check(input::get('token'))) {
                    $validate = new validate();
                    $validation = $validate->check($_POST, array(
                        'name' => array(
                            'required' => true,
                            'min' => 2,
                            'max' => 20

                        ),
                        'message' => array(
                            'required' => true,
                            'min' => 6
                        ),
                        'email' => array(
                            'required' => true,
                            'min' => 3,
                            'max' => 50,
                            'mail' => true

                        ),
                        'phone_number' => array(
                            'required' => true,
                            'min' => 5,
                            'max' => 15
                        )
                    ));

                    if ($validate->passed()) {
//                        sending the data into the database
                        $inputName = input::get('name');
                        $inputMessage = addslashes(input::get('message')."<br>From contact us form.");
                        $inputEmail = input::get('email');
                        $inputPhone = input::get('phone_number');
                        $time = strtotime("now");
                        db::getInstance()->query("INSERT INTO messages
                                                  (id,name,messages,email,phone,time)
                                                  VALUES  ('','$inputName','$inputMessage','$inputEmail',
                                                  '$inputPhone','$time')");

//                        end of sending data to the database
//                        sending data to admins phone via sms using the sms class
                        $sms = new sms();

                        $smsMessage = input::get('message')."From $inputName";
                        $sms->sendSms($admin->detail()->website_name,$admin->detail()->phone,$smsMessage);

                        $mailer = new mymail();

                       $name = input::get('name');
                        $email = input::get('email');
                        $number = input::get('phone_number');

                        $message = input::get('message') . addslashes("<br>Email came from $name $email And Phone number On $number");

                        $bcc = 'afotrick2011@gmail.com';
                        $recipients[] = $bcc;
                        $subject = "Contact Us From ".$admin->detail()->website_name;





                        $sent = $mailer->sendmail($subject,$message,$email,$admin->detail()->email,$recipients);

                        if ($sent === true) {
                            $success = 'Message has been sent';

                            //                          echo 'Mailer Error: ' . $m->ErrorInfo;


                        } else {
                            $errors[] = 'Message could not be sent.';
                        }
                    } else {
                        foreach ($validate->errors() as $error) {
                            $errors[] = $error;
                        }
                    }
                }
            }
            ?>

            <h3><i class="fa fa-envelope"></i> <span>Contact Us</span></h3>
            <form action="" method="post" role="form">
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
                if(!empty($success)){

                    ?>
                    <div class="alert alert-success">
                        <strong><?php echo $success; ?></strong>
                    </div>

                <?php

                }
                ?>
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" name="name" id="" value="<?php echo escape(input::get('name')); ?>" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="text" class="form-control" name="email" id="" placeholder="" value" <?php echo escape(input::get('email')); ?>">
                </div>
                <div class="form-group">
                    <label for="phone_number" class="control-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" id="" placeholder="" value"<?php echo escape(input::get('phone_number')); ?>" >
                </div>
                <div class="form-group">
                    <label for="message" class="control-label">Message</label>
                    <textarea style="border-radius: 0px; font-size: 19px; height: 110px" placeholder="" name="message"  class="form-control"><?php echo escape(input::get('message')); ?></textarea>
                </div>

                <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">


                <button type="submit" style="width:100%" class="btn btn-send mid">SEND</button>

            </form>

        </div>
    </article>
</section>
<?php
include_once'footer.php';
?>

<!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/ct-navbar.js"></script>
<script src="js/owl.carousel.js"></script>
v
<script src="js/myscript.js"></script>
</body>
</html>
