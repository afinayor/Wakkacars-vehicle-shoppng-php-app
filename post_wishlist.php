<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 27/11/2015
 * Time: 17:26
 */
require_once'core/init.php';

if(input::exists()){
    $id = input::get('id');
    $user_id = input::get('user_id');
    $user = new user();

    $data = db::getInstance()->get('new_vehicles',array('id','=',$id));

    if(($data->count() > 0) ){
        $send = db::getInstance()->insert('wishlist',array('user_id'=>$user_id,'vehicle_id'=>$id));

        if($send){
            echo "Success";
        }else{
            echo "Error";
        }
    }else{
        echo "Error";
    }

}else{
    echo "Error";
}