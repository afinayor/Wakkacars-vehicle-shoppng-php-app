<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="INDEX, FOLLOW">
    <?php
    if(isset($metaDatas)){
        foreach($metaDatas as $meta){
            echo $meta;
        }
    }
    ?>

    <title><?php if(!empty($title)){echo $title; }else{ echo "" ;} ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link href="css/ct-navbar.css" rel="stylesheet" />


    <link href="css/style.css" rel="stylesheet">
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="css/owl.carousel.css">

    <!-- Default Theme -->
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<!--    <link rel="stylesheet" href="css/normalize.css">-->

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 50px;
        }

        .starter-template {
            padding: 40px 15px;
            text-align: center;
        }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
    if(isset($fancybox) && $fancybox == "yes" ){

        ?>

        <link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />

        <!-- Add Button helper (this is optional) -->
        <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <style type="text/css">

            .fancybox-custom .fancybox-skin {
                box-shadow: 0 0 50px #222;
            }
        </style>


    <?php
    }
    ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
    </head>