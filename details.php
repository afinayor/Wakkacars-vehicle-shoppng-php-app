<?php
require_once'core/init.php';

$admin = new admin();


$fancybox = "yes";
if($_GET){
    if(!empty($_GET['no'])){
        $id = hash::decode($_GET['no']);
        $check = db::getInstance()->query("SELECT * FROM new_vehicles WHERE id = ? and publish = 1",array($id))->count();
        if($check>0) {

            $gallery = db::getInstance()->get('gallery', array('vehicle_id', '=', $id))->results();
            $data = db::getInstance()->get('new_vehicles', array('id', '=', $id))->first();
            $title = "$data->title";

            $meta1 = "<meta name='title' content='$data->title'>";
            $meta2 = "<meta name='description' content='$data->title, $data->manufacturer $data->model $data->model_year for sale on ".$admin->detail()->website_name."'>";
            $meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", $data->type , $data->manufacturer, $data->model, $data->model_year, $data->transmission, For Sale, affordable price.'>";

            $metaDatas = array($meta1,$meta2,$meta3);

        }else{
            redirect::to(404);
        }



    }else{
        redirect::to('index.php');
    }


}else{
    redirect::to('index.php');
}

$getClick = db::getInstance()->get('pageclick',array('page_name','=','details'))->first();

$new = $getClick->no + 1;
$pageclick = db::getInstance()->update('pageclick',$getClick->id,array('no'=>$new));

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

    <style type="text/css">
        #owl-demo .item img{
            display: block;
            width: 100%;
            height: auto;
        }
    </style>


<section class="container content">
    <div class="row">
        <div class="col-sm-8  col-md-8 col-lg-offset-1 col-lg-7">
            <div class="panel main-panel">
            	  <div class="panel-heading">
            			<h3 class="panel-title"><h1> <?php echo $data->title; ?> </h1></h3>
            	  </div>
            	  <div class="panel-body">


                      <div id="owl-demo" class="owl-carousel owl-theme">


                          <?php
                          foreach($gallery as $image) {
                              if(!empty($image->name)) {


                                  if(!file_exists("admin/images/uploads/thumbs/$image->name")){
                                      // *** 1) Initialize / load image
                                      $resizeObj = new resizeclass("admin/images/uploads/$image->name");

                                      // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                                      $resizeObj -> resizeImage(200, 200, 'exact');

                                      // *** 3) Save image
                                      $resizeObj -> saveImage("admin/images/uploads/thumbs/$image->name", 100);

                                  }
                                  ?>

                                  <div class="item"><img src="admin/images/uploads/<?php echo $image->name; ?>" alt="Image"></div>

                              <?php
                              }else{
                                  echo "<h1>No Image</h1>";
                              }
                          }
                          ?>

                      </div>

                      <!--                <div class="col-xs-3 "><a class="fancybox"-->
                      <!--                                          href="admin/images/uploads/--><?php //echo $image->name; ?><!--"><div class="thumbnail"><img-->
                      <!--                                style="width: 150px;" src="admin/images/uploads/thumbs/--><?php //echo $image->name; ?><!--" alt=""/></div></a>-->
                      <!--                </div>-->
                      <!--            <li style="margin-right: 3px; width: 100px;">-->
                      <!--                <a href="#">-->
                      <!--                    <img src="admin/images/uploads/thumbs/--><?php //echo $image->name; ?><!--" data-large="admin/images/uploads/--><?php //echo $image->name; ?><!--" alt="image01" data-description="Some description" />-->
                      <!--                </a>-->
                      <!--            </li>-->
                      <h3 class="price">&#8358;<?php echo clean_money($data->price); ?></h3>
                      <?php
                      $user = new user();
                      if($user->isLoggedIn()) {
                          $user_id = session::get(config::get('session/session_name'));

                          if (db::getInstance()->query("SELECT * FROM `wishlist` WHERE vehicle_id=$id AND user_id = $user_id")->count() == 0) {
                              ?>
                              <div class="wishlist">
                                  <button id="like" class="btn btn-success">
                                      <span class="pe-7s-like"></span> Add to wishlist
                                  </button>
                              </div>
                          <?php
                          } else {
                              ?>
                              <div class="wishlist">
                                  <button class="btn btn-success">
                                      <span class='pe-7s-check'></span> Added to wishlist
                                  </button>
                              </div>
                          <?php
                          }
                      }
                      ?>
                      <div class="row">
                          <div class="accordion" >
                              <span >
                                  <h4>Details</h4><i class="fa fa-plus-circle"></i>
                              </span>
                          </div>
                          <div class="accordion-desc" style="display: block">
                             <table class="table table-striped table-hover">
                                  <tbody>

                                  <tr>
                                      <td><strong >Manufacturer</strong></td><td><span><?php echo $data->manufacturer; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Model</strong></td><td><span><?php echo $data->model; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Transmission</strong></td><td><span><?php echo $data->transmission; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Condition</strong></td><td><span><?php echo $data->condition; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Year</strong></td><td><span><?php echo $data->model_year; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Mileage</strong></td><td><span><?php echo $data->mileage; ?></span></td>
                                  </tr>
                                  <tr>
                                      <td><strong >Price</strong></td><td><span>&#8358;<?php echo clean_money($data->price); ?></span></td>
                                  </tr>

                                  </tbody>
                              </table>
                          </div>
                          <div class="accordion">
                              <span><h4>Discription</h4><i class="fa fa-plus-circle"></i></span>
                          </div>
                          <div class="accordion-desc">
                              <?php



                              $discription = str_replace('src="','src="admin/',$data->discription);

                              echo $discription;
                              ?>
                          </div>

                          <div class="accordion">
                              <span><h4>Gallery</h4><i class="fa fa-plus-circle"></i></span>
                          </div>
                          <div class="accordion-desc">
                              <div class="row">
                                  <?php

                                  foreach($gallery as $image) {

                                      ?>
                                      <div class="col-sm-6 col-md-4"><a class="fancybox" href="admin/images/uploads/<?php echo $image->name; ?>">
                                              <div class="thumbnail"><img
                                                      style="width: 150px;"
                                                      src="admin/images/uploads/thumbs/<?php echo $image->name; ?>" alt=""/></div>
                                          </a>
                                      </div>

                                  <?php

                                  }
                                  ?>
                              </div>
                          </div>

                      </div>
                       <span class='st_sharethis_large' displayText='ShareThis'></span>
                      <span class='st_facebook_large' displayText='Facebook'></span>
                      <span class='st_twitter_large' displayText='Tweet'></span>
                      <span class='st_linkedin_large' displayText='LinkedIn'></span>
                      <span class='st_pinterest_large' displayText='Pinterest'></span>
                      <span class='st_email_large' displayText='Email'></span>



       </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-3">
            <div class="panel sidebar">
            	  <div class="panel-heading">
            			<h2 class="panel-title">Contact Us</h2>
            	  </div>
            	  <div class="panel-body">
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

                                        $mailer = new mymail();

                                        $inputName = input::get('name');
                                        $inputMessage = addslashes(input::get('message')."<br>From "."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."'>$data->title</a>");
                                        $inputEmail = input::get('email');
                                        $inputPhone = input::get('phone_number');
                                        $time = strtotime("now");
                                        db::getInstance()->query("INSERT INTO messages
                                                  (id,name,messages,email,phone,time)
                                                  VALUES  ('','$inputName','$inputMessage','$inputEmail',
                                                  '$inputPhone','$time')");


                                        $name = input::get('name');
                                        $email = input::get('email');
                                        $number = input::get('phone_number');

                                        $message = input::get('message') . "<br>Request email came from $name, $email And Phone number On $number";
                                        $message = $message.addslashes("<br>This Email came from the post "."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."'>$data->title</a>");


                                        $subject = 'New Car Request on '.$admin->detail()->website_name;

                                        $bcc = 'afotrick2011@gmail.com';
                                        $recipients[] = $bcc;


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


                        <form action="" method="post" role="form">
                            <?php
                            if(isset($errors) && count($errors)>0){
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
                            if(!empty($success)){

                                    ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">&times;</button>
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
                      <button class="btn btn-success mid" style="width:100%"><i class="fa fa-phone small"></i> <?php echo $admin->detail()->phone?></button>
            	  </div>
            </div>

        </div>
        <div class="col-sm-4 col-md-4 col-lg-3">
            <?php
                $query = "SELECT * FROM new_vehicles WHERE manufacturer = ? AND id <> ? LIMIT 0,10 ";
            $sideCars = db::getInstance()->query($query,array($data->manufacturer,$data->id));
            if($sideCars->count() > 0)
            {

                $resultCars = $sideCars->results();
                foreach($resultCars as $car){

                    $logoQuery = db::getInstance()->get('gallery',array('vehicle_id','=',$car->id))->first();

            ?>      <a href='details.php?no=<?php echo hash::encode($car->id) ;?>'>
                        <div class="row left-low">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <img src="admin/images/uploads/<?php echo $logoQuery->name ;?>" style="width: 100%; height: 70px" alt="image"/>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <p style="color: #82b440 ; font-weight: 700"><?php echo $car->title ;?></p>
                                <p style="color: #F36519">&#8358;<?php echo clean_money($car->price) ;?></p>
                            </div>

                        </div>
                    </a>


                <?php
                }
            }
            ?>
            </div>
    </div>
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
<script src="js/myscript.js"></script>
<script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<script type="text/javascript">
    $(document).ready(function() {
        /*
         *  Simple image gallery. Uses default settings
         */

        $('.fancybox').fancybox();


        $('#like').on('click',function(){
            $.post('post_wishlist.php','id=<?php echo $id;?>&user_id=<?php echo $user_id; ?>',processResult);

            function processResult(data){
                if(data == "Success") {
                    $('#like').html("<span class='pe-7s-check' ></span> Added to wishlist");
                }else{
                    alert("Error adding vehicle to wishlist. Please try again later");
                }
            }

        })


    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
//        $(".accordion-desc").fadeOut(0);
        $(".accordion").click(function() {
            $(".accordion-desc").not($(this).next()).slideUp('fast');
            $(this).next().slideToggle(400);

        });
//        $("#like").popover();
    });
</script>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b143291a-2d86-46a5-ad01-f11db7c1394e", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script src="js/jquery.scrolly.min.js"></script>

        </body>
</html>
