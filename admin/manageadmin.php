<?php
$title="Manage Admin";
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
                        Manage Admin
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-wrench"></i> Manage Admin
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-12">
                    <a href="addadmin.php" style="margin-bottom: 5px" class="btn btn-success">Add Admin</a>
                    <?php
                    if(db::getInstance()->get('adminusers',array('id','>',0))->count()){
                       $admins = db::getInstance()->query('SELECT * FROM adminusers',array())->results();

                        ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                    <?php
                    $i=1;
                        foreach($admins as $admin){
                            if($admin->group == 1){
                                $delete= "<a href='delete.php?adm={$admin->id}'><i class='fa fa-remove'></i> Delete</a>";
                            }else{
                                $delete = "<i class='fa fa-lock'></i> Delete";
                            }

                            echo "<tr>
                                        <td>{$i}</td>
                                        <td>{$admin->username}</td>
                                        <td>{$admin->name}</td>
                                        <td>{$admin->email}</td>
                                        <td>{$admin->phone}</td>
                                        <td>$delete</td>
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
