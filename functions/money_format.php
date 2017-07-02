<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 26/07/2015
 * Time: 15:58
 */

function clean_money($no){
//    $no = money_format("",$no);
//    $no = substr($no,3);
//    $data = explode('.',$no);
    $no = number_format($no);
    return $no;
}
?>
