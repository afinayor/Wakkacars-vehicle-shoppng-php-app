<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 13/10/2015
 * Time: 06:17
 */
require_once'core/init.php';
if($_POST){
    if(isset($_POST['id']) && isset($_POST['name'])){


        $id = $_POST['id'];
        $name = $_POST['name'];

        $dquery = db::getInstance()->insert('gallery', array('name'=>$name,'vehicle_id'=>$id));

        if($dquery){
            echo "inserted";
        }else{
            echo "error";
        }

    }else{
        echo "error";
    }
}