<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:07
 */

class config {
    public static function get($path=null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/',$path);

            foreach($path as $bit){
               if(isset($config[$bit])){
                    $config = $config[$bit];
               }
            }
        return $config;
        }
        return false;
    }
}