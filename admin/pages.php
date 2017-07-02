<?php
$title="Pages";
require_once'includes/head.php';
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
                        Manage Pages
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-wrench"></i>Pages
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">

                    <?php
                    if(db::getInstance()->get('pages',array('id','>',0))->count()){
                    $pages = db::getInstance()->query('SELECT * FROM pages',array())->results();

                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Edit</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $i=1;
                            foreach($pages as $page){

                                echo "<tr>
                                        <td>{$i}</td>
                                        <td>{$page->name}</td>
                                        <td><a href='{$page->name}.php' class='btn btn-default'>Edit</a></td>
                                    </tr>";
                                $i++;
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
