<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<script src="js/redactor.min.js"></script>

<script type="text/javascript">
    $(document).ready(
        function()
        {
            $('#redactor_content').redactor({
                imageUpload: 'image_upload.php'
            });
        }
    );
</script>

<?php
if(!empty($datatable) && $datatable=="true"){

    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });

    </script>

    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>


<?php
}

?>

<!--Text editor-->


<script type="text/javascript">
    $(document).ready(function(){
//        $(".btn").addClass("disabled");
        $(".btn").click(function(){
//            alert("Not allowed");
//            event.preventDefault();
        });
    });
</script>

</body>

</html>
