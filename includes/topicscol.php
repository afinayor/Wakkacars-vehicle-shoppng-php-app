<?php
$topic_list = db::getInstance()->query('SELECT id,name_of_subject FROM subjects limit 0,15',array())->results();
?>
<div class="well">
    <h4>Topics</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php
                foreach($topic_list as $topics) {
                    $link = hash::encode($topics->id);
                  echo "<li ><a style='color: #2c3e50' href = 'topic.php?tp=".$link."' >$topics->name_of_subject </a ></li >";
                }
?>
                <li><a style='color: #2c3e50' href = 'viewall.php' >View All Topics</a ></li>
            </ul>
        </div>
    </div>
    <!-- /.row -->
</div>