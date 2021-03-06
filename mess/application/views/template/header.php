<!DOCTYPE html>
<html lang="en" ng-app = "myApp">

<head>
    <meta charset="UTF-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo site_url('style/bootstrap.min.css'); ?>">

    <!-- MetisMenu CSS -->
    <link rel="stylesheet" href="<?php echo site_url('style/plugins/metisMenu/metisMenu.min.css'); ?>">

    <!-- Timeline CSS -->
    <link rel="stylesheet" href="<?php echo site_url('style/plugins/timeline.css'); ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo site_url('style/sb-admin-2.css'); ?>">

    <!-- Morris Charts CSS -->
    <link rel="stylesheet" href="<?php echo site_url('style/plugins/morris.css'); ?>">

    <link rel="stylesheet" href="<?php echo site_url('css/custom-bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('css/AdminLTE.min.css'); ?>">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="<?php echo site_url('font-awesome-4.3.0/css/font-awesome.min.css'); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo site_url('js/angular.min.js');?>"></script>
    <script src="<?php echo site_url('js/jquery.js');?>"></script>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">Dashboard</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">


            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href=""><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <?php include_once 'navigation.php'; ?>
        <?php include_once 'main.php'; ?>
<?php include_once 'footer.php'; ?>