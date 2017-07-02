<?php
$title="Add Gallery";
require_once'includes/head.php';
if($_GET){
    if(!empty($_GET['id'])){
        $id = $_GET['id'];

    }else{
        redirect::to('index.php');
    }
}else{
    redirect::to('index.php');
}
//
//if (input::exists()) {
//    if(token::check(input::get('token'))){
//
//            echo "<script>alert('".$_FILES['file_upload']."')</script>";
//
//
//        }
//    }

$title = db::getInstance()->get('new_vehicles',array('id','=',$id))->first();



?>
<link rel="stylesheet" href="uploadscript/css/jquery.fileupload.css">
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
                        Add Images To Gallery
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Page
                        </li>
                    </ol>

                    <?php

                    if(session::exists('gallery')){
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php
                                    echo '<p><i class="fa fa-check-square"></i> '.session::flash('gallery').'</p>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    <?php
                    }
                    ?>
                    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                    <br>
                    <br>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <div id="files" class="files"></div>
                    <br>


                <p class="text-danger"><strong>Note:</strong> Only files with image format of 'jpg','jpeg','gif','png' would be uploaded</p>

                </div>
            </div>
            <!-- /.row -->

<div id="test"></div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<?php
require_once'includes/scripts.php';
?>
<script src="uploadscript/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="uploadscript/js/vendor/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="uploadscript/js/vendor/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->

<script src="uploadscript/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="uploadscript/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="uploadscript/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="uploadscript/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="uploadscript/js/jquery.fileupload-validate.js"></script>
<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
//
        var url = 'uploadscript/server/php/',

            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                        data = $this.data();
                    $this
                        .off('click')
                        .text('Abort')
                        .on('click', function () {
                            $this.remove();
                            data.abort();
                        });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                    $.post('sendtodb.php','id=<?php echo $_GET['id'] ;?>&name='+file.name,process);



                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

        function process(data){
            if(data == 'error'){
                $('#test').html('Error uplaoding, please try again later.');
            }else{
                $('#test').html('');
            }
        }
    });
</script>
