<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 18/08/2015
 * Time: 01:21
 */

class model {


    public function manufacturers(){

        $data = db::getInstance()->query("SELECT * FROM addon_makes ")->results();

        $volume = array();

        foreach($data as $dat){
            $val = "<option value='$dat->makes_id' id='$dat->makes_id'>$dat->makes_name</option>";

            $volume[] = $val;

        }
        return $volume;
    }

    public function models(){

        $data = db::getInstance()->query("SELECT * FROM addon_models ")->results();

        $volume = array();

        foreach($data as $dat){
            $val = "<option value='$dat->models_name' class='model-$dat->makes_id'>$dat->models_name</option>";

            $volume[] = $val;

        }
        return $volume;
    }



}