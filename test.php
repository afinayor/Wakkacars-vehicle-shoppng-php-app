<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 25/07/2015
 * Time: 00:15
 */

$con = mysql_connect('localhost','afrisoft','mayowa1995');
mysql_select_db('carwebsite',$con);

$sql = "SELECT * FROM new_vehicles WHERE /*manufacturer = 'Ford' and model = 'Mustang' and type_name = 'Luxury Car' and */ `condition` = 'new' ";// and model_year BETWEEN 1990 and 2015 and transmission = 230 and price BETWEEN 100 and 100000000";

//$sql = "SELECT * FROM new_vehicles";

$query = mysql_query($sql);
echo $sql;
if($query){
    while($row = mysql_fetch_assoc($query)){
        echo $row['manufacturer']."<br>";
    }
}else{
    echo mysql_error();
}
