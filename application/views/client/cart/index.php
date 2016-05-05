<!-- Main Content -->
<div id="page-content" class="container" style='padding-top:10px'>
    <div class="row">
        <div class='col-sm-offset-1 col-sm-10'>
            <?php if($carts): ?>
            <div class="messages"></div>
            <div class="table-responsive">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th class="col-xs-1"><?php echo $this->lang->line('id') ?></th>
                            <th class="col-xs-4"><?php echo $this->lang->line('type_info') ?></th>
                            <th class="col-xs-1"><?php echo $this->lang->line('quantity') ?></th>
                            <th class="col-xs-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $offset = $this->uri->segment(3, 0) + 1; ?>
                         <?php foreach($carts as $key => $cart ):
                        ?>
                        <tr class='cart-item' id="cart-item-<?php echo (!empty($cart->id)) ? $cart->id : $cart->type_id ?>">
                            <td class="col-xs-1"><?php echo $key + 1; ?></td>
                            <td class="col-xs-4">
                                <div class="">
                                    <img class='img-thumbnail' width=200 height=200 src="<?php if (!empty($cart->type_image)) { echo $cart->type_image;} else { echo base_url(LINK_TO_GET_TYPES_IMAGE.(($cart->image_file_name) ? $cart->image_file_name : DEFAULT_IMAGE)); } ?>" alt="">
                                        <h4 class='text-right'>
                                            <div class='row'>
                                            <div class='text-left col-sm-8'>
                                                <a href="javascript:void(0)" class='type-name' data-toggle='tooltip' title="<?php echo $cart->type_name ?>"><?php echo character_limiter($cart->type_name, 20) ?></a>
                                            </div>
                                            <div class='text-right col-sm-4'>
                                                <span class="price"><?php echo $cart->price ?></span> US<i class='fa fa-dollar'></i></h4>
                                            </div>
                                            </div>
                                        </h4>
                                </div>
                            </td>
                            <td class="col-xs-1">
                                <div class='form-group'>
                                    <input type='number' class='form-control' name='quantity' min="1" value='<?php echo $cart->quantity ?>'>
                                </div>
                            </td>
                            <td class="col-xs-1">
                                <div class='form-group'>
                                    <button class='btn btn-sm btn-raised btn-danger btn-remove-cart' data-cart-item='<?php echo (!empty($cart->id)) ? $cart->id : $cart->type_id ?>' data-toggle="modal" data-target = '#removeCartModal'><i class='fa fa-remove'></i></button></td>
                                </div>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="col-xs-1"></td>
                            <td class="col-xs-4">
                                <h4 class='text-right'>
                                    <div class='row'>
                                    <div class='text-left col-sm-8'>
                                        <?php echo $this->lang->line('total_money') ?>
                                    </div>
                                    <div class='text-right col-sm-4'>
                                        <span class='total-money'>0</span> US<i class='fa fa-dollar'></i>
                                    </div>
                                    </div>
                                </h4>
                            </td>
                            <td class="col-xs-1"></td>
                            <td class="col-xs-1"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class='text-right'>
                    <button class='btn btn-success btn-raised btn-lg btn-order' data-toggle="modal" data-target = '#contactModal'><?php echo $this->lang->line('order') ?></button>
                    <!-- <a href="<?php echo base_url('client/shopping_cart/checkout') ?>" class='btn btn-lg btn-default'><?php echo $this->lang->line('checkout') ?></a> -->
                </div>
        <?php else: ?>
        <p class='alert alert-warning'><?php echo $this->lang->line('not_found') ?></p>
        <?php endif; ?>
        </div>
    </div>
</div>
<!--Confirm deleting -->
<div class="modal fade" id="removeCartModal" role="dialog">
    <div class="modal-dialog">
      <!-- confirm sectionn-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('confirm_remove_cart_title') ?></h4>
        </div>
        <div class="modal-body">
            <p><?php echo $this->lang->line('confirm_remove_cart_content') ?></p>
          <input type='hidden' name='cart-item' value=''>
        </div>
        <div class="modal-footer">
          <button type="button" data-remove-cart-url = '<?php echo base_url('client/shopping_cart/remove_cart'); ?>' class="btn btn-lg btn-default btn-confirm-remove" data-dismiss="modal"><?php echo $this->lang->line('ok') ?></button>
        </div>
      </div>
    </div>
</div>
    <!-- end confirm section -->
<div class="modal fade" id="contactModal" role="dialog">
    <div class="modal-dialog">
        <!-- confirm sectionn-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('order') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="messages"></div>
                        <?php
                            $attrs = array('class' => 'form-bordered', 'id' => 'form-send-order');
                            $session_user = session_logged_in();
                        ?>
                        <?php echo form_open('client/shopping_cart/order', $attrs); ?>
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
                                    <label class='control-label'><?php echo $this->lang->line('phone_number') ?></label>
                                    <?php $data = array('id' => 'phone_number', 'class' => 'form-control', 'placeholder' => $this->lang->line('phone_number')); ?>
                                    <?php echo form_input('phone_number', set_value('phone_number', $session_user['phone']), $data); ?>
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
                            <br>
                            <div id="success"></div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-raised btn-primary btn-confirm-order"><?php echo $this->lang->line('ok') ?></button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>