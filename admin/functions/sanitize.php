<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:06
 */
function escape($string){
    return htmlentities($string,ENT_QUOTES,'UTF-8');
}