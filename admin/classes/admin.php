<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 27/07/2015
 * Time: 22:48
 */

class admin {


    public  $website_name,
        $website_url,
        $discription,
        $email,
        $phone,
        $facebook,
        $twitter,
        $google_plus,
        $webmail_username,
        $webmail_password,
        $smsUsername,
        $smsPassword;


    public function detail()
    {
        $data = db::getInstance()->query('SELECT * FROM overview WHERE id = 1',array())->first();
        $this->website_name = $data->name;
        $this->website_url = $data->url;
        $this->discription = $data->discription;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->facebook = $data->facebook;
        $this->twitter = $data->twitter;
        $this->google_plus = $data->googleplus;
        $this->webmail_username = $data->webmail_username;
        $this->webmail_password = $data->webmail_password;
        $this->smsUsername = $data->sms_username;
        $this->smsPassword = $data->sms_password;
        return $this;
    }



}