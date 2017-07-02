<?php

            if(session::exists('home')){
?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php
                echo '<p><i class="fa fa-check-square"></i> '.session::flash('home').'</p>';
?>
                    </div>
                </div>
            </div>
            <!-- /.row -->
<?php
            }
?>

