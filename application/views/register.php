<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $this->lang->line('title') ?></title>

        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins.css'); ?>">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
        <style type="text/css">
            .errors {
                margin: 10px;
            }
        </style>
        <!-- END Stylesheets -->

<!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        <script src="<?php echo base_url('assets/js/vendor/modernizr-2.7.1-respond-1.4.2.min.js'); ?>"></script>
    </head>
    <body>
        <img src="<?php echo base_url('assets/img/login_background.jpg') ?>" alt="register Background" class="full-bg animation-pulseSlow">
        <!-- register Container -->
        <div id="login-container" class="animation-fadeIn">
            <!-- register Title -->
            <div class="login-title text-center">
                <h1><?php echo $this->lang->line('title') ?></h1>
            </div>
            <!-- END register Title -->

            <!-- register Block -->
            <div class="block push-bit">
                <!-- register Form -->
                <?php $attributes = array('class' => 'form-horizontal form-control-borderless', 'id' => 'form-register'); ?>
                <?php echo form_open('register/check', $attributes); ?>
                    <div class="errors"></div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <?php $data = array('id' => 'email', 'name' => 'email', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('email')) ?>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <?php $data = array('id' => 'full_name', 'name' => 'full_name', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('full_name')) ?>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <?php $data = array('id' => 'phone', 'name' => 'phone', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('phone')) ?>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <?php $data = array('id' => 'address', 'name' => 'address', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('address')) ?>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <?php $data = array('id' => 'password', 'name' => 'password', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('password')) ?>
                                <?php echo form_password($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <?php $data = array('id' => 'confirm_password', 'name' => 'confirm_password', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('confirm_password')) ?>
                                <?php echo form_password($data); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8 text-right">
                            <?php $data = array( 'class' => 'btn btn-sm btn-primary') ?>
                            <?php echo form_submit($data, $this->lang->line('login_to_dashboard')) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <a href="<?php echo base_url('language/switch_language/vietnamese') ?>" id="link-reminder-register"><small><?php echo $this->lang->line('vietnamese') ?></small></a> - 
                            <a href="<?php echo base_url('language/switch_language/english') ?>" id="link-reminder-register"><small><?php echo $this->lang->line('english') ?></small></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <a href="javascript:void(0)" id="link-reminder-register"><small><?php echo $this->lang->line('forgot_password') ?></small></a>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                <!-- END register Form -->
            </div>
            <!-- END register Block -->

        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-1.11.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="<?php echo base_url('assets/js/vendor/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/pages/register.js'); ?>"></script>
    </body>
</html>