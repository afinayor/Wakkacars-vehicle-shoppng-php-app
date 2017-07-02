<?php
$title="Contact Messages";
require_once'includes/head.php';
function checkId($id){
    $check = db::getInstance()->get('messages',array('id' , '=' , $id));
    if($check->count() > 0 ){
        return true;
    }else{
        return false;
    }
}
$sms = new sms;
?>
<body>

<div id="wrapper">

<?php
require_once'includes/navigation.php';
?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Contact Messages
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-wrench"></i> Contact Messages
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">

                    <?php
                    if(input::exists() && input::get('sendemail')){

                        $validate = new validate();
                        $validation = $validate->check($_POST,array('subject'=>array('required'=> true,'max'=>200),
                            'message'=>array('required'=> true)));
                        if($validation->passed()){
                            $email = input::get('email');
                            $id = input::get('id');
                            $subject = input::get('subject');

                            $message = input::get('message')."<br><br> This email came from ".$admin->detail()->website_name;

                            $from = $admin->detail()->email; //enter your email address
                            $to = $email; //enter the email address of the contact your sending to

                            $bcc = "afotrick2011@gmail.com";
                            $recipients[] = $bcc;

                            $mailing = new mymail();

                            $sent = $mailing->sendmail($subject,$message,$from,$email,$recipients);

                            if ($sent === true) {
                                $success = 'Message has been sent';
                                db::getInstance()->update('messages', $id, array('unread' => '1'));
                            }
                            else {
                                $errors[] = $sent;

                             }

                        }else{
                            foreach ($validate->errors() as $error) {
                                $errors[] = $error;
                            }
                        }
                    }
                    if(input::exists() && input::get('sms')){
                        $validate = new validate();
                        $validation = $validate->check($_POST,array('sender'=>array('required'=> true,'max'=>200),
                            'message'=>array('required'=> true)));

                        if($validation->passed()){
                            $sender = input::get('sender');
                            $message = input::get('message');
                            $id = input::get('id');
                            $phone = input::get('phone');
                            $sms = new sms();

                            $sms->sendSms($sender,$phone,$message);

                            if($sms->error()){
                                $errors[] = $sms->error();
                            }else{
                                $success = "Text message has been sent successfully";
                            }




                        }else{
                            foreach ($validate->errors() as $error) {
                                $errors[] = $error;
                            }
                        }

                    }

                    if(input::get('id') && input::get('read')){
                        $id=(int)input::get('id');
                        $read = input::get('read');
                        if(checkId($id)){
                            if($read == 'yes') {
                                $update = db::getInstance()->update('messages', $id, array('unread' => '1'));
                                if($update) {
                                    redirect::to('messages.php');
                                }
                            }elseif($read == 'no'){
                                $update = db::getInstance()->update('messages', $id, array('unread' => '0'));
                                if($update) {
                                    redirect::to('messages.php');
                                }
                            }else{
                                redirect::to(404);
                            }

                        }else{
                            redirect::to(404);
                        }

                    }
                    if(db::getInstance()->get('messages',array('id','>',0))->count()){
                    $messages = db::getInstance()->query('SELECT * FROM messages ORDER BY id DESC');
                    $messages = db::getInstance()->results();
                    ?>
                    <?php
                    if(isset($errors) && count($errors)>0){
                        foreach($errors as $err) {
                            $err = str_replace('_',' ',$err);
                            $err = ucwords($err);
                            ?>
                            <div class="alert alert-danger">
                                <strong><?php echo $err; ?></strong>
                            </div>

                        <?php
                        }
                    }
                    if(!empty($success)){

                        ?>
                        <div class="alert alert-success">
                            <strong><?php echo $success; ?></strong>
                        </div>

                    <?php

                    }
                    if($admin->detail()->smsUsername && $admin->smsPassword) {
                        ?>

                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong> You have <?php echo ceil($sms->sms_balance());?> SMS units</strong>
                        </div>

                    <?php
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th id="big">No</th>
                                <th>Name</th>
                                <th>Message</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Time</th>
                                <th>Reply</th>
                                <th>Send SMS</th>
                                <th>Mark as Read</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $i=1;
                            foreach($messages as $message){
                                if($message->unread==0){
                                    $include = "success";
                                    $link = "<a class='btn btn-warning' href='".$_SERVER['PHP_SELF']."?read=yes&id=".$message->id."'>Not Read</a>";
                                }else{
                                    $include = "";
                                    $link = "<a class='btn btn-success' href='".$_SERVER['PHP_SELF']."?read=no&id=".$message->id."'>Read</a>";
                                }
                                echo"<tr class='$include'>";
                                echo "<td>$i</td>";
                                echo "<td>$message->name</td>";
                                echo "<td>$message->messages</td>";
                                echo "<td>$message->phone</td>";
                                echo "<td>$message->email</td>";
                                echo "<td>".date('d/m/Y H:i:s',$message->time)."</td>";
                                echo "<td><a data-toggle='modal' href='#modal-id-".$message->id."'><button class='btn btn-default'>Reply</button></a></td>";
                                echo "<td><a data-toggle='modal' href='#modal-sms-id-".$message->id."'><button class='btn btn-default'>SMS</button></a></td>";
                                echo "<td>$link</td>";
                                echo "</tr>";
                                $i++;

                                ?>

<!--                                beginning of modal for sms-->
                                <div class="modal fade" id="modal-sms-id-<?php echo $message->id ;?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Send <?php echo $message->name; ?> a text message</h4>
                                            </div>
                                            <div class="modal-body">

                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
                                                    <div class="form-group">
                                                        <label for="subject" >Sender Id</label>


                                                        <input type="text" name="sender" class="form-control" id=""
                                                               placeholder="" value="<?php echo $admin->detail()->website_name ?>">

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="message" >Message</label>
                                                        <textarea class="form-control" name="message" id="textfield" ></textarea>
                                                        <p id="data"></p>
                                                    </div>
                                                    <input name="id" value="<?php echo $message->id; ?>" type="hidden"/>
                                                    <input name="phone" value="<?php echo $message->phone; ?>" type="hidden"/>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <input type="submit" name="sms" class="btn btn-primary" value="Send" />
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
<!--                            end of modal for sms  -->




<!--                                Modal for email-->
                                <div class="modal fade" id="modal-id-<?php echo $message->id ;?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Reply <?php echo $message->name; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
                                                    <div class="form-group">
                                                        <label for="subject" >Subject</label>


                                                        <input type="text" name="subject" class="form-control" id=""
                                                               placeholder="Subject">

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="message" >Message</label>
                                                        <textarea class="form-control" name="message" id="" ></textarea>
                                                    </div>
                                                    <input name="id" value="<?php echo $message->id; ?>" type="hidden"/>
                                                    <input name="email" value="<?php echo $message->email; ?>" type="hidden"/>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary" value="Send" name="sendemail" />
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
<!--end of modal for email-->
                            <?php


                            }
                            echo "</tbody>
                            </table>
                     </div>";
                            }else{
                                echo 'No Messages Found';
                            }



                            ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>

<?php

require_once'includes/scripts.php';
?>
    <script type="text/javascript">
        $("#textfield").keydown(function (){

            $('#no').html('<p>'+$("#textfield").val()+'</p>');
            var content = $("#textfield").val();
            $('#digit').html('<p>'+content.length+'</p>');
            var no = content.length;
            //var pageno = 0;
            var rem = no%160;
            if(no>=160 && rem == 0)
            {
                pageno++;
            }
            if(no<160){
                pageno = 0;
            }
            var data = "<p>"+(160-rem)+" / "+pageno+"</p>";
            $('#data').html(data);

        });

    </script>