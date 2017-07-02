<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 01/10/2015
 * Time: 15:49
 */

class mymail {

    public $admin,$error;

    public function __construct(){
        require_once "Mail.php"; // PEAR Mail package
        require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
        $this->admin = new admin();
        return $this;
    }

    public function sendmail($subject,$message,$from,$to,$others=array()){
        $headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
        $text = ''; // text versions of email.
        $html = $message; // html versions of email.
        $crlf = "\n";

        $recipients = $to;
        foreach($others as $email){
            $recipients .= ','.$email;
        }
        $mime = new Mail_mime($crlf);
        $mime->setTXTBody($text);
        $mime->setHTMLBody($html);

        //do not ever try to call these lines in reverse order
        $body = $mime->get();
        $headers = $mime->headers($headers);
        $host = "localhost"; // all scripts must use localhost
        $username = $this->admin->detail()->webmail_username; //  your email address (same as webmail username)
        $password = $this->admin->detail()->webmail_password; // your password (same as webmail password)

        $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true,
            'username' => $username,'password' => $password));

        $mail = $smtp->send($recipients, $headers, $body);


        if (PEAR::isError($mail)) {
            return "<p>" . $mail->getMessage() . "</p>";
        }else {
            return true;
        }

    }

}