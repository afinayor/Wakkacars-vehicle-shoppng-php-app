<?php
require_once'core/init.php';
$title = "About Us";
$admin = new admin();

$meta1 = "<meta name='title' content='About Us | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='About us page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale, affordable price, no1 car website'>";

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
        <div class="col-sm-8  col-md-8 col-lg-offset-1 col-lg-7" id="rightside">
                <h1>About Us</h1>
                <?php
                    $query = db::getInstance()->query('SELECT * FROM pages WHERE id = 1',array());
                    if($query){
                        $data = $query->first();
                        $content = $data->content;
                    }else{
                        $content = "";
                    }
                echo $content;
                ?>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-3" id="leftside" style='padding: 10px'>
<h4 class="underline">Latest Cars</h4>
            <?php

                $query1 = db::getInstance()->query('SELECT * FROM new_vehicles WHERE publish = 1 limit 0,3',array());
                $volume = $query1->results();
                shuffle($volume);
            foreach ($volume as $value) {
//                       echo $value->id;
                $images = db::getInstance()->query('SELECT * FROM gallery WHERE vehicle_id = ?',array($value->id))->count();
//                       var_dump($images);
                if ($images > 0) {
                    $image = db::getInstance()->query('SELECT * FROM gallery WHERE vehicle_id = ?',array($value->id))->first();
                    $image = $image->name;
                    $image = "<img src='admin/images/uploads/" . $image . "' class='' style='width:99%;margin-bottom:0px;' >";
                } else {
                    $image = "<img src='admin/images/uploads/Noimage.png' class='' style='width:99%;margin-bottom:0px;' >";
                }
                echo "

                    <div class='row left-low'>
                        <div class='col-xs-6 col-sm-6 col-md-6'>
                                <a href='details.php?no=".hash::encode($value->id)."'>$image</a>
                        </div>
                         <div class='col-xs-6 col-sm-6 col-md-6'>
                            <a  class='title' href='details.php?no=".hash::encode($value->id)."'>$value->title</a>
                            <h5>$value->type</h5>
                            <p class='price'>&#8358;".clean_money($value->price)."</p>
                        </div>
                    </div>


            ";
            }


            ?>

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
<script src="js/myscript.js"></script>
<script src="js/jquery.scrolly.min.js"></script>
</body>
</html>
