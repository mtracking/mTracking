<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <h1>
                <?php echo $this->lang->line('bottle') ?>
            </h1>
        </div>
    </div>
    <div class="block block-alt-noborder gallery" data-toggle="lightbox-gallery">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-3 col-lg-offset-1">
                <div class="block-section" >
                    <a href="<?php echo $product->picture_url; ?>" class="gallery-link" title="Image Info">
                        <img class="img-thumbnail img-responsive" src="<?php echo $product->picture_url; ?>" alt="image">
                    </a>
                </div>
                <div class="block-section">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="<?php echo $product->qrcode1; ?>" class="gallery-link" title="Image Info">
                                <img src="<?php echo $product->qrcode1; ?>" alt="image">
                            </a>
                            <div class='text-center'>QR-CODE 1</div>
                        </div>
                        <div class="col-xs-6">
                            <a href="<?php echo $product->qrcode2; ?>" class="gallery-link" title="Image Info">
                                <img src="<?php echo $product->qrcode2; ?>" alt="image">
                            </a>
                            <div class='text-center'>QR-CODE 2</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-lg-offset-1">
                <h3 class="sub-header">
                    <strong><?php echo $product->type_name; ?></strong>
                </h3>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('serial_no') ?>
                                :</strong>
                                <?php echo $product->serial_no; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('status_product'); ?>
                                :</strong>
                                <?php if ($product->status_product_id == PRODUCT_OPENED_STATUS): ?>
                                <span class="label label-danger">
                                <?php else: ?>
                                <span class="label label-success">
                                <?php endif; ?>
                                <?php echo $product->status_product_name; ?>
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('batch'); ?>
                                :</strong>
                                <?php echo $product->batch_lot; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('subtype') ?>
                                :</strong>
                                <?php echo $product->type_name. ' - '.$product->producing_year; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('category'); ?>
                                    :</strong>
                                <?php echo $product->category_name; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('factory') ?>
                                :</strong>
                                <?php echo $product->factory; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php if (!empty($product->last_location)) : ?>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('open_by'); ?>
                                    :</strong>
                                    <?php if (!is_null($product->email)): ?>
                                        <a href="<?php echo base_url('admin/users?search='.$product->email) ?>" style="color: #1bbae1"><?php echo $product->email ?></a>
                                    <?php else: ?>
                                        <?php echo $this->lang->line('unknown') ?>
                                    <?php endif; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('open_where'); ?>
                                    :</strong>
                                    <a href="<?php echo 'https://www.google.com/maps/@'. $product->last_location->latitude. ','.$product->last_location->longitude.',8z'; ?>" target="_blank" style="color: #1bbae1">
                                    <?php echo $product->last_location->area. ' ('. $product->last_location->latitude.', '.$product->last_location->longitude.')'; ?>
                                    </a>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($product->last_location)) : ?>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('open_in_time'); ?>
                                    :</strong>
                                    <?php echo date('m-d-Y H:i:s', strtotime($product->last_location->time)); ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('producing_date'); ?>
                                        :</strong>
                                <?php echo date('m-d-Y', strtotime($product->producing_date)); ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('expiry_date'); ?>
                                        :</strong>
                                <?php echo (strtotime($product->expiry_date) > 0) ? date('m-d-Y', strtotime($product->expiry_date)) : 'None'; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('characteristics'); ?>
                                :</strong>
                                <?php echo $product->characteristics; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('storage_temp'); ?>
                                    :</strong>
                                <?php echo $product->storage_temp; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-angle-right"></i>
                                <strong>
                                <?php echo $this->lang->line('sourcing'); ?>
                                :</strong>
                                <?php echo $product->sourcing; ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>