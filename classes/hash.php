<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:08
 */

class hash {
    public static  function make($string , $salt = ''){
        return hash('sha256',$string.$salt);
    }

    public static function salt($length){
        return mcrypt_create_iv($length);

    }
    public static function unique(){
        return self::make(uniqid());

    }
    public static function encode($string){
        return base64_encode($string);
    }
    public static function decode($string){
        return base64_decode($string);
    }
}