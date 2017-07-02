<?php
require_once'core/init.php';
$title = "Gallery";
$fancybox = "yes";
$admin = new admin();

$meta1 = "<meta name='title' content='Gallery | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='Gallery page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale, gallery of cars ,  affordable price, no1 car website'>";

$metaDatas = array($meta1,$meta2,$meta3);
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once'head.php';
?>
<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7">
<body>

<?php
include_once'nav.php';

?>
<section class="container content">
    <h1 class="text-center">Gallery</h1>
<hr>
    <div class="row">
        <?php
            $images = db::getInstance()->query("SELECT * FROM gallery ORDER BY id LIMIT 0,12",array())->results();
            shuffle($images);
            if(count($images)==0){
                echo "<p class='text-primary'>No Images At Present</p>";
            }else{

                foreach($images as $image){
                    $hash = hash::encode($image->vehicle_id);
                    echo "<div class='col-lg-3 col-md-4 col-sm-6'>
                            <div class='thumbnail'>
                                <a class='fancybox-thumbs' data-fancybox-group='thumb' href='admin/images/uploads/$image->name'><img class='img-responsive' src='admin/images/uploads/$image->name'></a>
                            <a href='details.php?no=$hash'><button type='button' class='btn btn-success' style='width: 100%;'>Details</button></a>
                            </div>
                        </div>";
                }
            }
        ?>
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
<script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript">

    $(document).ready(function() {
        /*
         *  Simple image gallery. Uses default settings
         */


        $('.fancybox-thumbs').fancybox({
            prevEffect : 'none',
            nextEffect : 'none',

            closeBtn  : false,
            arrows    : false,
            nextClick : true,

            helpers : {
                thumbs : {
                    width  : 50,
                    height : 50
                }
            }
        });


    });

</script>
<script src="js/jquery.scrolly.min.js"></script>
</body>
</html>
