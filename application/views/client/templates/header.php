<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo (!is_null($title)) ? $title : $this->lang->line('title'); ?></title>
      <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/client/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/bootstrap.material-design/0.5.9/css/bootstrap-material-design.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/bootstrap.material-design/0.5.9/css/ripples.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/client/css/style.css'); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class='page-wrap'>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-logo" href="<?php echo base_url('client/store') ?>"><?php echo (!empty($site_title) ? strtoupper($site_title) : '') ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right sidebar-nav">
                    <?php foreach ($pages as $key => $page): ?>
                        <li>
                            <a href="<?php echo base_url('client/pages/detail/'. $page->id) ?>"><?php echo $page->title ?></a>
                        </li>
                    <?php endforeach; ?>
                    <?php if (is_logged_in()): ?>
                        <?php if (is_distributor()): ?>
                        <li>
                            <a href="<?php echo base_url('client/orders') ?>"><?php echo $this->lang->line('orders') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('client/history') ?>"><?php echo $this->lang->line('history') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('client/shopping_cart') ?>"><?php echo $this->lang->line('shopping_cart') ?></a>
                        </li>
                        <?php elseif (is_admin()): ?>
                        <li>
                            <a href="<?php echo base_url('admin/home') ?>"><?php echo $this->lang->line('manage') ?></a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="<?php echo base_url('client/history') ?>"><?php echo $this->lang->line('history') ?></a>
                        </li>
                        <?php endif; ?>
                    <li>
                        <a href="<?php echo base_url('client/user') ?>"><?php echo $this->lang->line('user_profile') ?></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('client/logout') ?>"><?php echo $this->lang->line('log_out') ?></a>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="#" data-toggle="modal" data-target = '#LoginModal'><?php echo $this->lang->line('login') ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo base_url(LINK_TO_GET_TEMPLATE_IMAGE.((!empty($background_file_name)) ? $background_file_name : DEFAULT_IMAGE)) ?>');">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1><?php echo (!empty($site_title) ? strtoupper($site_title) : '') ?></h1>
                        <hr class="small">
                        <span class="subheading">
                            <?php $attrs = array('id' => 'form-search-type', 'method' => 'get') ?>
                            <?php echo form_open('client/store', $attrs); ?>
                            <div class='form-group col-xs-8 col-sm-10'>
                                <?php $data = array('id' => 'search-type', 'class' => 'form-control input-lg', 'placeholder' => strtoupper($this->lang->line('search_type'))); ?>
                                <?php echo form_input('search_type', set_value('search_type', $this->input->get('search_type')), $data); ?>
                            </div>
                                <div class='form-group col-xs-4 col-sm-2'>
                                    <?php $data = array('class' => 'btn btn-raised btn-info') ?>
                                    <?php echo form_submit('submit', $this->lang->line('find'), $data); ?>
                                </div>
                            <?php echo form_close(); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
<!--     <div class="container">
        <div class="row">

        </div>
    </div>

    <hr> -->

