<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 14/10/2015
 * Time: 18:38
 */
use \Curl\Curl;
class sms {


    public $response,$error,$curl,$admin;


    public function __construct(){
        require_once'Curl.php';
        $this->curl = new Curl();
        $this->admin = new admin();

    }

    public function sendSms($sender,$recipient,$message){
        $this->curl->get('http://www.estoresms.com/smsapi.php',array('username'=>$this->admin->detail()->smsUsername,
            'password'=>$this->admin->detail()->smsPassword,'sender'=>$sender,'recipient'=>$recipient,
            'message'=>$message));

        if($this->curl->error){
            $this->error = 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage;
        }else{
            $this->response = $this->curl->response;
        }
        return $this;
    }

    public function sms_balance(){
        $this->curl->get('http://www.estoresms.com/smsapi.php',array('username'=>$this->admin->detail()->smsUsername,
            'password'=>$this->admin->detail()->smsPassword,'balance'=>'true'));



        if($this->curl->error){

//            return 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage;
            return "";
        }else{

            return $this->curl->response;
        }

    }



    public function error(){
        return $this->error;
    }

    public function response(){
        return $this->response;
    }

}