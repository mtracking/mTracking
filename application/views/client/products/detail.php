<!-- Main Content -->
<div id="page-content" class="container">
    <div class="row" style='margin-top:10px;'>
        <div class="col-xs-12 col-sm-5">
            <a href="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.$product->picture_url); ?>" class="gallery-link" title="Image Info">
                <img class="img-thumbnail img-responsive" src="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.$product->image_file_name); ?>" alt="image">
            </a>
        </div>
        <div class="col-xs-12 col-sm-7">
            <h3 class="sub-header">
                <strong><?php echo $product->type_name; ?> </strong>
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
                            <span class="label label-danger"><?php echo $product->status_product_name; ?> </span>
                            <hr class='blue' >
                            <div class='text-warning'><?php echo $this->lang->line('status_opened') ?> <?php echo date("m-d-Y H:i:s", strtotime(get_last_location(json_decode($product->location))->time)); ?></div>
                            <?php else: ?>
                            <span class="label label-success"><?php echo $product->status_product_name; ?> </span>
                            <hr class='blue' />
                            <div class='text-warning'><?php echo $this->lang->line('status_not_open') ?></div>
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
                            <?php echo $this->lang->line('factory') ?>
                            :</strong>
                            <?php echo $product->factory; ?>
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
                            <?php echo (strtotime($product->expiry_date) > 0) ? date('m-d-Y', strtotime($product->expiry_date)): 'None'; ?>
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
            <!-- <div class="pull-right" style="<?php echo (is_admin()) ? 'display:none;' : '' ?>"><button class="btn btn-sm btn-success" data-toggle="modal" data-target = '#contactModal'><?php echo $this->lang->line('buy') ?></button></div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="contactModal" role="dialog">
    <div class="modal-dialog">
        <!-- confirm sectionn-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('shop_now') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="messages"></div>
                        <?php
                            $attrs = array('class' => 'form-bordered', 'id' => 'form-send-order');
                            $session_user = session_logged_in();
                        ?>
                        <?php echo form_open('client/orders/store', $attrs); ?>
                            <div class="row">
                                <div class="form-group col-xs-12 form-group controls">
                                    <label class='control-label'><?php echo $this->lang->line('name') ?> (*) </label>
                                    <?php $data = array('id' => 'name', 'class' => 'form-control', 'placeholder' => $this->lang->line('name')); ?>
                                    <?php echo form_input('name', set_value('name', $session_user['full_name']), $data); ?>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 form-group controls">
                                    <label class='control-label'><?php echo $this->lang->line('email') ?> (*) </label>
                                    <?php $data = array('id' => 'email', 'class' => 'form-control', 'placeholder' => $this->lang->line('email')); ?>
                                    <?php echo form_input('email', set_value('email', $session_user['email']), $data); ?>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 form-group controls">
                                    <label class='control-label'><?php echo $this->lang->line('address') ?></label>
                                    <?php $data = array('id' => 'address', 'class' => 'form-control', 'placeholder' => $this->lang->line('address')); ?>
                                    <?php echo form_input('address', set_value('address', $session_user['address']), $data); ?>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 form-group controls">
                                    <label class='control-label'><?php echo $this->lang->line('postal_code') ?></label>
                                    <?php $data = array('id' => 'postal_code', 'class' => 'form-control', 'placeholder' => $this->lang->line('postal_code')); ?>
                                    <?php echo form_input('postal_code', set_value('postal_code', $session_user['postal_code']), $data); ?>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 form-group controls">
                                    <label class='control-label'><?php echo $this->lang->line('phone_number') ?></label>
                                    <?php $data = array('id' => 'phone_number', 'class' => 'form-control', 'placeholder' => $this->lang->line('phone_number')); ?>
                                    <?php echo form_input('phone_number', set_value('phone_number', $session_user['phone']), $data); ?>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 form-group controls">
                                    <?php $data = array('id' => 'content', 'class' => 'form-control', 'rows' => '3', 'placeholder' => $this->lang->line('content')); ?>
                                    <?php echo form_hidden('content', ($this->lang->line('hint_content').' '. $product->type_label.', Quantity: 1'), $data); ?>
                                </div>
                            </div>
                            <br>
                            <div id="success"></div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-default"><?php echo $this->lang->line('send') ?></button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<script>var total_money = <?php echo $product->price ?></script>