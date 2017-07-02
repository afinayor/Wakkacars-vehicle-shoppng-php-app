<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 28/11/2015
 * Time: 15:43
 */
require_once'core/init.php';

if(input::exists()){
    $id = input::get('id');
    $user = new user();
    if($user->isLoggedIn()){
        $user_id = session::get(config::get('session/session_name'));
    }
    $data = db::getInstance()->get('new_vehicles',array('id','=',$id));

    if(($data->count() > 0) ){
        $send = db::getInstance()->delete('wishlist',array('vehicle_id','=',$id));

        if($send){
            echo "Success";
        }else{
            echo "Error1";
        }
    }else{
        echo "Error2";
    }

}else{
    echo "Error3";
}