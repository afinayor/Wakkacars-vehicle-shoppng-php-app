<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 09/10/2015
 * Time: 05:14
 */

class years {
    public static function listYears($no=2,$from = 1990){
       $current_year = date('Y');
        $to = $current_year + $no;

        $list_years = array();

        for($to ; $to >= $from ; $to--){
            $list_years[] = "<option value='$to' >$to</option>";
        }

        return $list_years;

    }
}