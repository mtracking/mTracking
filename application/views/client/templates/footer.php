    </div>
<!-- Footer -->
    <footer class='site-footer'>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class=''>
                        <?php echo (!empty($footer)) ? $footer : '' ?>
                    </div>
                    <div class=''>
                        Language:
                        <a href="<?php echo base_url('language/switch_language/vietnamese') ?>" id="link-reminder-login"><small>Vietnamese</small></a> -
                        <a href="<?php echo base_url('language/switch_language/english') ?>" id="link-reminder-login"><small>English</small></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="modal fade" id="LoginModal" role="dialog">
        <div class="modal-dialog">
            <!-- confirm sectionn-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('connect_to_website') ?></h4>
                </div>
                <div class="modal-body">
                    <div class='messages'></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id='login' class='row form'>
                                <div class='col-sm-8 right-form'>
                                    <?php $attrs = array('class' => 'form-update-status form-bordered', 'id' => 'form-login', 'data-update-user-url' => base_url('client/products/update_user')); ?>
                                    <?php echo form_open('client/login', $attrs); ?>
                                        <h2 class='text-center'><?php echo $this->lang->line('login') ?></h2>
                                        <div class="row">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('email')); ?>
                                                <?php echo form_input('email', '', $data); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'password', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('password')); ?>
                                                <?php echo form_password('password', '', $data); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" class="btn btn-lg btn-raised btn-block btn-success"><?php echo $this->lang->line('send') ?></button>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                                <div class='col-sm-4'>
                                    <div class='row multi-choose'>
                                        <div class="form-group col-xs-12">
                                            <button class='btn btn-block btn-sm btn-primary link-to-register'><?php echo $this->lang->line('register') ?></button>
                                            <button class='btn btn-block btn-sm btn-danger link-to-forgot-password'><?php echo $this->lang->line('forgot_password') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Register form -->
                            <div id='register' class='row form' style='display:none'>
                                <div class='col-xs-12'>
                                    <?php $attrs = array('class' => 'form-update-status form-bordered', 'id' => 'form-register', 'data-update-user-url' => base_url('client/products/update_user')); ?>
                                    <?php echo form_open('client/register', $attrs); ?>
                                        <h2 class='text-center'><?php echo $this->lang->line('register') ?></h2>
                                        <div class="row">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'full_name', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('full_name')); ?>
                                                <?php echo form_input('full_name', '', $data); ?>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('email')); ?>
                                                <?php echo form_input('email', '', $data); ?>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'address', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('address')); ?>
                                                <?php echo form_input('address', '', $data); ?>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-6 form-group controls">
                                                <?php $data = array('id' => 'phone', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('phone')); ?>
                                                <?php echo form_input('phone', '', $data); ?>
                                            </div>
                                            <div class="form-group col-xs-6 form-group controls">
                                                <?php $data = array('id' => 'postal_code', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('postal_code')); ?>
                                                <?php echo form_input('postal_code', '', $data); ?>
                                            </div>
                                        </div>
                                        <div class="row control-group">
                                            <div class="form-group col-sm-6 form-group controls">
                                                <?php $data = array('id' => 'password', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('password')); ?>
                                                <?php echo form_password('password', '', $data); ?>
                                            </div>
                                            <div class="form-group col-sm-6 form-group controls">
                                                <?php $data = array('id' => 'confirm_password', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('confirm_password')); ?>
                                                <?php echo form_password('confirm_password', '', $data); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" class="btn btn-lg btn-raised btn-block btn-primary"><?php echo $this->lang->line('send') ?></button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <button class='btn btn-sm btn-block btn-success link-to-login'><?php echo $this->lang->line('login') ?></button>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <button class='btn btn-sm btn-block btn-danger link-to-forgot-password'><?php echo $this->lang->line('forgot_password') ?></button>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <!--Forgot password form -->
                            <div id='forgot-password' class='row form' style='display:none'>
                                <div class='col-xs-12'>
                                    <h2 class='text-center'><?php echo $this->lang->line('forgot_password') ?></h2>
                                    <?php $attrs = array('class' => 'form-bordered', 'id' => 'form-forgot-password'); ?>
                                    <?php echo form_open('client/forgot_password', $attrs); ?>
                                        <div class="row control-group">
                                            <div class="form-group col-xs-12 form-group controls">
                                                <?php $data = array('id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => $this->lang->line('email')); ?>
                                                <?php echo form_input('email', '', $data); ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group col-xs-12">
                                                <button type="submit" class="btn btn-lg btn-raised btn-block btn-danger"><?php echo $this->lang->line('send') ?></button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <button class='btn btn-sm btn-block btn-success link-to-login'><?php echo $this->lang->line('login') ?></button>
                                            </div>
                                            <div class="form-group col-xs-6">
                                                <button class='btn btn-sm btn-block btn-primary link-to-register'><?php echo $this->lang->line('register') ?></button>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" id="to-top" style="display: none;"><i class="fa fa-angle-double-up"></i></a>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/client/js/bootstrap.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.material-design/0.5.9/js/material.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.material-design/0.5.9/js/ripples.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/client/js/main.js') ?>"></script>
    <script src="<?php echo base_url('assets/client/js/notie.js') ?>"></script>
    <?php
        $this->load->helpers('common');
        $link_to_css_file = base_url('assets/client/js/pages/'.$this->router->class.'.js');
        if (is_url_exist($link_to_css_file))
        {
            echo "<script src='".$link_to_css_file."'></script>";
        }
    ?>
    <script src="<?php echo base_url('assets/client/js/pages/js.js') ?>"></script>
</body>

</html>