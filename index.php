<?php
require_once'core/init.php';
$title = "Home";
$admin = new admin();

$meta1 = "<meta name='title' content='Home | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='Index page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.",nigerian vehicles for sale, For Sale,search for cars, list of cars,search for vehicles, latest cars for sale in nigeria, affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);

$getClick = db::getInstance()->get('pageclick',array('page_name','=','home'))->first();

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
//include_once'top.php';
include_once'nav.php';
?>
<!--<div id="owl-demo" class="owl-carousel owl-theme">-->
<!--    <div class="item"><img src="img/ford_raptor-1920x12001.jpg"></div>-->
<!--    <div class="item"><img src="img/2012_chevrolet_camaro-1920x1200.jpg"></div>-->
<!--    <div class="item"><img src="img/2012_range_rover_sport-1920x1200.jpg"></div>-->
<!--    <div class="item"><img src="img/chevrolet_camaro_ssx-1920x1200.jpg"></div>-->
<!--    <div class="item"><img src="img/dodge_charger_mopar_2011-1920x1200.jpg"></div>-->
<!---->
<!---->
<!---->
<!--</div>-->
<header>

        <span class="logo icon fa fa-automobile"></span>
        <h1>Welcome To <?php echo $admin->detail()->website_name; ?></h1>
        <p><?php echo $admin->detail()->discription; ?></p>
        <div style="width: 100%">
            <a href="#search" class="scrolly">
                 <button class="btn btn-search">SEARCH FOR CARS</button>
            </a>
        </div>
    <a href="#cars" class="btn btn-circle scrolly">
        <i class="fa fa-angle-double-down animated"></i>
    </a>

</header>




<section id="cars" class="container content">
     <div class="row">

                <div class="col-lg-12">
                    <h3 class="thumb">New Cars</h3>

                </div>
         <?php

         $datas = db::getInstance()->query('SELECT * FROM new_vehicles WHERE publish = 1 ORDER BY  id DESC LIMIT 0,8 ',array())->results();

         foreach($datas as $data) {


             $images = db::getInstance()->get('gallery',array('vehicle_id','=',$data->id))->count();
             if($images>0){
                 $image = db::getInstance()->get('gallery',array('vehicle_id','=',$data->id))->first();
                 $image = $image->name;

             }else{
                 $image = "Noimage.png";
             }

             ?>
             <div class="col-sm-5 col-md-6 col-lg-3">
                 <div class="thumbnail full-list">
                     <?php
                        if($data->condition == "new") {
                            ?>
                            <div class="imagepath">
                                <img src="img/new.png" width="50px">
                            </div>
                        <?php
                        }
                     ?>
                     <a href="details.php?no=<?php echo hash::encode($data->id); ?>"><img data-src="3" style='height:200px' src="admin/images/uploads/<?php echo $image ;?>" alt="img1"></a>

                     <div class="caption">
                         <h3><?php //echo $data->title ;?></h3>

                         <p><?php echo $data->manufacturer ;?></p>

                         <div style="clear:both">
                             <span class="left1">Type</span>
                             <span class="left2"><?php echo $data->type ;?></span>
                         </div>
                         <div style="clear:both">
                             <span class="left1">Transmission</span>
                             <span class="left2"><?php echo $data->transmission ;?></span>
                         </div>
                         <div style="clear:both">
                             <span class="left1">Year</span>
                             <span class="left2"><?php echo $data->model_year ;?></span>
                         </div>
                         <div style="clear:both">
                             <span class="left1">Price</span>
                             <span class="left2">&#8358;<?php echo clean_money($data->price) ?></span>
                         </div>
                         <hr>
                         <a href="details.php?no=<?php echo hash::encode($data->id); ?>" style="width: 100%" class="btn btn-success">View Details</a>

                     </div>
                 </div>
             </div>
         <?php

         }

?>
     </div>
    <div class="clearfix"></div>
    <div class="row">
         <a href="search.php?brand=&type=&condition=&model=&from=&to=&transmission=&pricefrom=&priceto=&token=1dfa11ce3406d75580846d0b97d9775d" class="p-button" >View All</a>

    </div>
</section>
<?php
include_once'search_cars.php'
?>
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
<script src="js/jquery.scrolly.min.js"></script>
<script src="js/myscript.js"></script>

</body>
</html>
