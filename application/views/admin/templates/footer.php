<!-- Footer -->
                <footer class="clearfix">
                    <div class="pull-right">
                        <?php echo $this->lang->line('develop') ?> <i class="fa fa-heart text-danger"></i> <?php echo $this->lang->line('by') ?> <a href="javascript::void(0)">Enclave</a>
                    </div>
                    <div class="pull-left">
                        <?php echo $this->lang->line('language') ?>:
                        <a href="<?php echo base_url('language/switch_language/vietnamese') ?>" id="link-reminder-login"><small><?php echo $this->lang->line('vietnamese') ?></small></a> -
                        <a href="<?php echo base_url('language/switch_language/english') ?>" id="link-reminder-login"><small><?php echo $this->lang->line('english') ?></small></a>
                        <div><span id="year-copyx">2016</span> &trade; <a href="javascript:void(0)" ><?php echo $this->lang->line('type_tracking') ?></a></div>
                    </div>
                </footer>
                <!-- END Footer -->
            </div>
        </div>
        <a href="#" id="to-top" style="display: none;"><i class="fa fa-angle-double-up"></i></a>
        <!-- Remember to include excanvas for IE8 chart support -->
        <!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="<?php echo base_url('assets/js/vendor/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/js.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/summernote.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.progresstimer.min.js'); ?>"></script>
        <?php
            $this->load->helpers('common');
            $link_to_css_file = base_url('assets/js/pages/'.$this->router->class.'.js');
            if (is_url_exist($link_to_css_file))
            {
                echo "<script src='".$link_to_css_file."'></script>";
            }
        ?>
    </body>
</html>