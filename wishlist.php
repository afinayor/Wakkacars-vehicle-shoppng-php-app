<?php
require_once'core/init.php';
$title = "My Wishlist";
$admin = new admin();
$user = new user();

if(!$user->isLoggedIn()){
    redirect::to('index.php');
}

$meta1 = "<meta name='title' content='Search Vehicles | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='wishlist page of ".$admin->detail()->website_name."'>";
$meta3 = "<meta name='keywords' content='".$admin->detail()->website_name.", For Sale,search for cars, list of cars,search for vehicles, latest cars for sale in nigeria, affordable price, no1 car website'>";

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

    <div class="col-lg-offset-1 col-lg-10 ">
        <div class="row search-grid">
            <h2>My Wishlist</h2>

            <?php
            $wishSql = "SELECT  `vehicle_id` FROM `wishlist` WHERE `user_id`=?";
            $values[] = session::get(config::get('session/session_name'));

            $sql_Query = db::getInstance()->query($wishSql, $values);
            $sql_results = $sql_Query->results();
            $list = "";
            foreach($sql_results as $vehicle_info){
                $list .= 'id = '.$vehicle_info->vehicle_id.' OR ';
            }

            $list = substr($list,0,-3);

            $sql = "SELECT * FROM `new_vehicles` WHERE $list";



                $queryno = db::getInstance()->query($sql, $values);
                $num_rows = $queryno->count();

                if ($num_rows > 0){

                    $pages = new paginator($num_rows, 9, array(15, 3, 6, 9, 12, 25, 50, 100, 250, 'All'));
                    $sql .= " LIMIT $pages->limit_start , $pages->limit_end ";

//                   echo $sql;
//                   echo $num_rows;
//                   print_r($values);
                    $query = db::getInstance()->query($sql, $values);

//               echo $query->get_error();

                    echo "<span class=\"\">" . $pages->display_jump_menu() . $pages->display_items_per_page() . "</span>";







//echo "<br>".$sql;

                    $results = $query->results();

                    foreach ($results as $value) {
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
    <table id='table-$value->id' class='table table-striped table-hover'>
        <tbody>
            <tr>
                <td>
                    <div class='col-md-2'>
                        <a href='details.php?no=".hash::encode($value->id)."'>$image</a>
                    </div>
                    <div class='col-md-9 search'>
                        <div style='width:100%'>
                            <h4 style='display:inline-block;width:80%'>
                                <a href='details.php?no=".hash::encode($value->id)."'>$value->title</a>
                            </h4>
                            <div style='width:10% ;display: inline;'>
                                <button class='btn btn-danger' id='$value->id'>Remove</button>
                            </div>
                        </div>
                        <h5>$value->type</h5>
                        <p class='price'>&#8358;".clean_money($value->price)."</p>
                    </div>

                </td>
            </tr>
        </tbody>
    </table>";
                    }
                    echo "<ul class='pagination'>";
                    echo $pages->display_pages();
                    echo "</ul>";
//                   echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";
//                   echo "<p class=\"paginate\">SELECT * FROM table LIMIT $pages->limit_start,$pages->limit_end (retrieve records $pages->limit_start-".($pages->limit_start+$pages->limit_end)." from table - $pages->total_items item total / $pages->items_per_page items per page)";
                }else{
                    echo "<div class='alert alert-warning'>

	You dont have any wishlist
</div>";
                }
//            echo '<pre>',print_r($results),'</pre>';

//           }




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
<script src="js/jquery.scrolly.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        $('table').on('click','button',function(){
            var id = $(this).attr('id');
            content = 'id='+id;

            $.post('remove_wishlist.php',content,processResult);

            function processResult(data){
                if(data == "Success") {
                    var table = '#table-'+id;

                    $(table).fadeOut(1000);
                }else{
                    alert("Error removing vehicle from wishlist. Please try again later");
                }
            }

        });
    });

</script>
</body>
</html>