<!-- Page content -->
<div id="page-content" style="min-height: 894px;">
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <!-- Widget -->
            <a href="<?php echo base_url('admin/batches') ?>" class="widget widget-hover-effect1">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                        <i class="fa fa-archive"></i>
                    </div>
                    <h3 class="widget-content text-right animation-pullDown">
                        <?php echo $number_of_batches ?> <strong><?php echo $this->lang->line('batches') ?></strong><br>
                        <small><?php echo $number_of_products ?> <?php echo $this->lang->line('bottles') ?></small>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-3">
            <!-- Widget -->
            <a href="<?php echo base_url('admin/categories') ?>" class="widget widget-hover-effect1">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-spring animation-fadeIn">
                        <i class="fa fa-book"></i>
                    </div>
                    <h3 class="widget-content text-right animation-pullDown">
                        <?php echo $number_of_categories ?><strong> <?php echo $this->lang->line('categories') ?></strong><br>
                        <small><?php echo $number_of_types ?> <?php echo $this->lang->line('types') ?></small>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-3">
            <!-- Widget -->
            <a href="<?php echo base_url('admin/users') ?>" class="widget widget-hover-effect1">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-fire animation-fadeIn">
                        <i class="fa fa-users"></i>
                    </div>
                    <h3 class="widget-content text-right animation-pullDown">
                        <?php echo $number_of_users ?> <strong><?php echo $this->lang->line('users') ?></strong>
                        <small> <?php echo $this->lang->line('locations') ?></small>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-3">
            <!-- Widget -->
            <a href="<?php echo base_url('admin/orders') ?>" class="widget widget-hover-effect1">
                <div class="widget-simple">
                    <div class="widget-icon pull-left themed-background-amethyst animation-fadeIn">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <h3 class="widget-content text-right animation-pullDown">
                        <?php echo $number_of_orders ?> <strong><?php echo $this->lang->line('orders') ?></strong>
                        <small><?php echo $this->lang->line('email') ?></small>
                    </h3>
                </div>
            </a>
            <!-- END Widget -->
        </div>
    </div>
     <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <div class="widget-options">
                    </div>
                    <h3 class="widget-content-light">
                        <?php echo $this->lang->line('location_of_customer') ?>
                    </h3>
                </div>
                <div class="widget-extra-full">
                    <div id="googleMap" style="width:100%;height:580px;"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var locations = <?php echo (!is_null($locations)) ? json_encode($locations) : NULL; ?>;
    </script>
    <!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps (Remove 'http:' if you have SSL) -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBFBav7HuJJn1WgZJB8PmuWYegqDHu_4aQ"></script>
</div>
<!-- END Page Content -->
