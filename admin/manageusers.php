<?php
$title="Manage Users";
require_once'includes/head.php';
$admin = new admin();
$sms = new sms;
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
                    if(input::exists() && input::get('reset')){
                        $validate = new validate();
                        $validation = $validate->check($_POST,array('password'=>array('required'=> true,'max'=>'30')));

                        if($validation->passed()){
                            $id = input::get('id');
                            $password = input::get('password');
                            $salt = hash::salt(32);
                            $hashedPassword = hash::make($password,$salt);

                            $reset = db::getInstance()->update('users',$id,array('password'=>$hashedPassword,'salt'=>$salt));

                            if($reset){
                                $success = "User's password has been successfully updated to '$password'";
                            }else{
                                $errors[] = 'Error updating password';
                            }





                        }else{
                            foreach ($validate->errors() as $error) {
                                $errors[] = $error;
                            }
                        }

                    }


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
                        Manage Users
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-wrench"></i> Manage Users
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-12">
                     <?php
                    if(db::getInstance()->get('users',array('id','>',0))->count()){
                    $members = db::getInstance()->query('SELECT * FROM users',array())->results();

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
?>
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Send Sms</th>
                                <th>Send Email</th>
                                <th>Reset Password</th>
                                <th>Delete</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $i=1;
                            foreach($members as $member){

                                    $delete= "<a href='delete.php?user=".$member->id."'><button class='btn btn-danger'><i class='fa fa-remove'></i> Delete</button></a>";


                                echo "<tr>
                                        <td>{$i}</td>
                                        <td>{$member->username}</td>
                                        <td>{$member->email}</td>
                                        <td>{$member->phone}</td>
                                        <td><a data-toggle='modal' href='#modal-id-".$member->id."'><button class='btn btn-default'>Email</button></a></td>
                                        <td><a data-toggle='modal' href='#modal-sms-id-".$member->id."'><button class='btn btn-default'>SMS</button></a></td>
                                        <td><a data-toggle='modal' href='#modal-reset-id-".$member->id."'><button class='btn btn-success'><i class='fa fa-key'></i> Reset</button></a></td>
                                        <td>$delete</td>
                                    </tr>";
                                $i++;
?>
                            <!--                                beginning of modal for sms-->
                                <div class="modal fade" id="modal-sms-id-<?php echo $member->id ;?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Send <?php echo $member->username; ?> a text message</h4>
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
                            <input name="id" value="<?php echo $member->id; ?>" type="hidden"/>
                            <input name="phone" value="<?php echo $member->phone; ?>" type="hidden"/>

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
        <div class="modal fade" id="modal-id-<?php echo $member->id ;?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Reply <?php echo $member->username; ?></h4>
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
                            <input name="id" value="<?php echo $member->id; ?>" type="hidden"/>
                            <input name="email" value="<?php echo $member->email; ?>" type="hidden"/>

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

<!--                            modal for reseting password for users-->

                                <div class="modal fade" id="modal-reset-id-<?php echo $member->id ;?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Reset <?php echo $member->username; ?> password to</h4>
                                            </div>
                                            <div class="modal-body">

                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
                                                    <div class="form-group">
                                                        <label for="password" >Password</label>


                                                        <input type="text" name="password" class="form-control" id="password"
                                                               placeholder="" value="<?php echo $member->username; ?>">

                                                    </div>


                                                    <input name="id" value="<?php echo $member->id; ?>" type="hidden"/>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <input type="submit" name="reset" class="btn btn-primary" value="Reset" />
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!--                            end of modal for reseting password  -->




                            <?php

                            }
                            echo "</tbody>
                            </table>
                     </div>";

                            }else{
                                echo 'No Record Found';
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
