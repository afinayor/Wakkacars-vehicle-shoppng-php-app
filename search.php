<?php
require_once'core/init.php';
$title = "Search ";
$admin = new admin();

$meta1 = "<meta name='title' content='Search Vehicles | ".$admin->detail()->website_name."'>";
$meta2 = "<meta name='description' content='search page of ".$admin->detail()->website_name."'>";
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
                <h2>Search</h2>
<button class="btn btn-send" id="search-btn">Click To Search</button>
                    <form action="search.php" id="search-form" class="<?php if(input::exists('get')){echo "form-hidden";}?>" method="get"  role="form">
                        <div class="row">
                            <div class="col-lg-6">
                                <select name="brand" id="brand" onchange="up()" class="form-control">
                                    <option value="">Manufacturer</option>
                                    <?php
                                    $makes = new model();

                                    foreach($makes->manufacturers() as $manuc){
                                        echo $manuc;
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <select name="model" id="model" class="form-control">
                                <option value="">Model</option>
                                <?php


                                foreach($makes->models() as $model2){
                                    echo $model2;
                                }
                                ?>

                            </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <select name="type" id="type" class="form-control">
                                    <option value="">Type</option>
                                    <option value="Sedan" >Sedan</option>
                                    <option value="Coupe" >Coupe</option>
                                    <option value="Sports Car" >Sports Car</option>
                                    <option value="Luxury Car" >Luxury Car</option>
                                    <option value="SUV" >SUV</option>
                                    <option value="Van" >Van</option>
                                    <option value="Truck" >Truck</option>


                                </select>
                            </div>
                            <div class="col-lg-6">
                                <select name="condition" id="condition" class="form-control">
                                    <option value="">condition</option>
                                    <option value="new">New</option>
                                    <option value="used">Used</option>
                                    <option value="pre_owned">Certified Pre Owned</option>
                                    <option value="recondition">Recondition</option>
                                    <option value="other">Other</option>
                                 </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-8 col-md-8">
                                        <select name="from" id="from" class="form-control">
                                            <option value="">Model Year(From)</option>
                                            <?php
                                            foreach(years::listYears() as $year){
                                                echo $year;
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">

                                        <select name="to" id="to" class="form-control">
                                            <option value="">To</option>
                                            <?php
                                            foreach(years::listYears() as $year){
                                                echo $year;
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <select name="transmission" id="transmission" class="form-control">
                                    <option value="">Transmission</option>
                                    <option value="Automatic">Automatic</option>
                                    <option value="Manual">Manual</option>
                                    <option value="Semi Automatic">Semi Automatic</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>
                        <div class="row">
                            <div class="col-lg-4">
                                    <div class="col-sm-8 col-md-8">
                                        <select name="pricefrom" id="pricefrom" class="form-control">
                                            <option value="">Price Range (From)</option>
                                            <option value="100000000">100000000</option>
                                            <option value="50000000">50000000</option>
                                            <option value="40000000">40000000</option>
                                            <option value="30000000">30000000</option>
                                            <option value="20000000">20000000</option>
                                            <option value="10000000">10000000</option>
                                            <option value="8000000">8000000</option>
                                            <option value="6000000">6000000</option>
                                            <option value="4000000">4000000</option>
                                            <option value="2000000">2000000</option>
                                            <option value="1000000">1000000</option>
                                            <option value="500000">500000</option>
                                            <option value="100000">100000</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <select name="priceto" id="priceto" class="form-control">
                                            <option value="">To</option>
                                            <option value="100000000">100000000</option>
                                            <option value="50000000">50000000</option>
                                            <option value="40000000">40000000</option>
                                            <option value="30000000">30000000</option>
                                            <option value="20000000">20000000</option>
                                            <option value="10000000">10000000</option>
                                            <option value="8000000">8000000</option>
                                            <option value="6000000">6000000</option>
                                            <option value="4000000">4000000</option>
                                            <option value="2000000">2000000</option>
                                            <option value="1000000">1000000</option>
                                            <option value="500000">500000</option>
                                            <option value="100000">100000</option>

                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <button type="submit" class="btn btn-success submit">Search</button>



                    </form>


                    <?php
                    if(input::exists('get')) {
                        echo "<h3>Search result</h3>";
//               if(token::check(input::get('token'))){
                        $sql = "SELECT * FROM new_vehicles WHERE";
                        $values = array();
                        $getvalues = $_GET; //pass the get values to an array
                        array_pop($getvalues); // remove the last array value which is token
                        $check = "";
                        foreach ($getvalues as $getval) { //testing if the query has a value or not
                            if(input::get('page') == $getval ){
                                continue;
                            }
                            if(input::get('ipp') == $getval ){
                                continue;
                            }
                            $check .= $getval;

                        }
//            echo $check;
//               if (!empty($check)) {
//                   $sql .= " WHERE";
//               }

                        function check($sql)
                        {
                            // function to check if the present query is with or without the where clause
                            $break_sql = explode(' ', $sql);
                            $no = count($break_sql);
                            if ($break_sql[$no - 1] == "WHERE") {
                                return true;
                            } else {
                                return false;
                            }
                        }

                        if (input::get('brand')) {
                            //$manufacturer = "Ford";
                            $manufacturer = db::getInstance()->query("SELECT * FROM addon_makes WHERE makes_id = ?", array(input::get('brand')));
                            if ($manufacturer->error() == false) {
                                $manufacturer = $manufacturer->first();
                                $manufacturer = $manufacturer->makes_name;
                                $sql .= " `manufacturer` = ?";
                                $values[] = $manufacturer;
                            } else {
                                $manufacturer = "";
                            }
                        } else {
                            $manufacturer = "";
                        }
                        if (input::get('model')) {
                            $model = input::get('model');
                            if (check($sql)) {
                                $sql .= " `model` = ?";

                            } else {
                                $sql .= " and `model` = ?";
                            }
                            $values[] = $model;
                        } else {
                            $model = "";
                        }
                        if (input::get('type')) {
                            $type = input::get('type');
                            if (check($sql)) {
                                $sql .= " `type` = ?";
                            } else {
                                $sql .= " and `type` = ?";
                            }

                            $values[] = $type;
                        } else {
                            $type = "";
                        }
                        if (input::get('condition')) {
                            $condition = input::get('condition');
                            if (check($sql)) {
                                $sql .= " `condition` = ?";
                            } else {
                                $sql .= " and `condition` = ?";
                            }

                            $values[] = $condition;
                        } else {
                            $condition = "";
                        }
                        if (input::get('from') && input::get('to')) {
                            $from = input::get('from');
                            $to = input::get('to');
                            if (check($sql)) {
                                $sql .= " `model_year` BETWEEN ? and ?";
                            } else {
                                $sql .= " and `model_year` BETWEEN ? and ?";
                            }

                            $values[] = $from;
                            $values[] = $to;
                        } else {
                            $from = "";
                            $to = "";
                        }

                        if (input::get('transmission')) {
                            $transmission = input::get('transmission');
                            if (check($sql)) {
                                $sql .= " `transmission` = ?";
                            } else {
                                $sql .= " and `transmission` = ?";
                            }

                            $values[] = $transmission;
                        } else {
                            $transmission = "";
                        }
                        if (input::get('priceto') && input::get('pricefrom')) {
                            $priceto = input::get('priceto');
                            $pricefrom = input::get('pricefrom');

                            if (check($sql)) {
                                $sql .= " `price` BETWEEN ? and ?";
                            } else {
                                $sql .= " and `price` BETWEEN ? and ?";
                            }

                            $values[] = $priceto;
                            $values[] = $pricefrom;
                        } else {
                            $priceto = "";
                            $pricefrom = "";
                        }


                        if (!empty($check)) {
                            $sql .= "and `publish` = 1 ";
                        }else{
                            $sql .= " `publish` = 1 ";
                        }


//               working on the pagination
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
    <table class='table table-striped table-hover'>
        <tbody>
            <tr>
                <td>
                    <div class='col-md-2'>
                        <a href='details.php?no=".hash::encode($value->id)."'>$image</a>
                    </div>
                    <div class='col-md-9 search'>
                        <h4><a href='details.php?no=".hash::encode($value->id)."'>$value->title</a></h4>
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

	Sorry, no result found.
</div>";
                        }
//            echo '<pre>',print_r($results),'</pre>';

//           }
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#search-btn').click(function(){
            $('#search-form').slideToggle();
        });

    });
</script>
<script src="js/jquery.scrolly.min.js"></script>
</body>
</html>