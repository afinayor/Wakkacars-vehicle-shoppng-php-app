<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:08
 */

class input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }
    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        }elseif(isset($_GET[$item])){
            return $_GET[$item];
        }
        return '';
    }
}
