<?php
$title="About-us Page";
require_once'includes/head.php';

$query = db::getInstance()->query('SELECT * FROM pages WHERE id = 1',array());
$data = $query->first();


if(input::exists()){
    if(token::check(input::get('token'))){
        $validate = new validate();
        $validation = $validate->check($_POST,array(
            'content' =>array(
                'required' => true,
                'min' => 0
            )
        ));
        if($validation->passed()){
            $update = db::getInstance()->update('pages','1',array('content'=>input::get('content')));
            if($update){
                session::flash('about','The About us page has been updated');
                redirect::to('about-us.php');
            }else{
                echo "<script>alert('error')</script>>";
            }
        }else{
            foreach ($validate->errors() as $error) {
                $errors[] = $error;
            }
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
                        About Us Page
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-key"></i> Page
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <?php

            if(session::exists('about')){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php
                            echo '<p><i class="fa fa-check-square"></i> '.session::flash('about').'</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            <?php
            }
            ?>


            <div class="row">

        <!-- /.container-fluid -->
                <form action="" method="post" role="form">

                    <div class="form-group">
                        <h1 for="redactor_content" >Content</h1>
                                    <textarea id="redactor_content" name="content">
<?php echo $data->content; ?>
                                    </textarea>
                    </div>

                    <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

    </div>
    <!-- /#page-wrapper -->

</div>
<?php
require_once'includes/scripts.php';
?>
