<!-- Main Content -->
<div id="page-content" class="container">
    <div class="row">
        <div class='col-md-8'>
            <div class='row'>
                <div class='col-md-6'>
                    <h2>Billing address</h2>
                    <?php
                        $attrs = array('class' => 'form-bordered', 'id' => 'form-send-order');
                        $session_user = session_logged_in();
                    ?>
                    <?php echo form_open('client/shopping_cart/order', $attrs); ?>
                        <div class="row">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('name') ?> (*) </label>
                                <?php $data = array('id' => 'name', 'class' => 'form-control', 'placeholder' => $this->lang->line('name')); ?>
                                <?php echo form_input('name', set_value('name', $session_user['full_name']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('email') ?> (*) </label>
                                <?php $data = array('id' => 'email', 'class' => 'form-control', 'placeholder' => $this->lang->line('email')); ?>
                                <?php echo form_input('email', set_value('email', $session_user['email']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('phone_number') ?></label>
                                <?php $data = array('id' => 'phone_number', 'class' => 'form-control', 'placeholder' => $this->lang->line('phone_number')); ?>
                                <?php echo form_input('phone_number', set_value('phone_number', $session_user['phone']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('address') ?></label>
                                <?php $data = array('id' => 'address', 'class' => 'form-control', 'placeholder' => $this->lang->line('address')); ?>
                                <?php echo form_input('address', set_value('address', $session_user['address']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('postal_code') ?></label>
                                <?php $data = array('id' => 'postal_code', 'class' => 'form-control', 'placeholder' => $this->lang->line('postal_code')); ?>
                                <?php echo form_input('postal_code', set_value('postal_code', $session_user['postal_code']), $data); ?>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                <div class='col-md-6'>
                    <h2>Shipping address</h2>
                    <?php echo form_open('client/shopping_cart/order', $attrs); ?>
                        <div class="row">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('name') ?> (*) </label>
                                <?php $data = array('id' => 'name', 'class' => 'form-control', 'placeholder' => $this->lang->line('name')); ?>
                                <?php echo form_input('name', set_value('name', $session_user['full_name']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('email') ?> (*) </label>
                                <?php $data = array('id' => 'email', 'class' => 'form-control', 'placeholder' => $this->lang->line('email')); ?>
                                <?php echo form_input('email', set_value('email', $session_user['email']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('phone_number') ?></label>
                                <?php $data = array('id' => 'phone_number', 'class' => 'form-control', 'placeholder' => $this->lang->line('phone_number')); ?>
                                <?php echo form_input('phone_number', set_value('phone_number', $session_user['phone']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('address') ?></label>
                                <?php $data = array('id' => 'address', 'class' => 'form-control', 'placeholder' => $this->lang->line('address')); ?>
                                <?php echo form_input('address', set_value('address', $session_user['address']), $data); ?>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 form-group controls">
                                <label><?php echo $this->lang->line('postal_code') ?></label>
                                <?php $data = array('id' => 'postal_code', 'class' => 'form-control', 'placeholder' => $this->lang->line('postal_code')); ?>
                                <?php echo form_input('postal_code', set_value('postal_code', $session_user['postal_code']), $data); ?>
                            </div>
                        </div>
                        <div>Use billing address <input type='checkbox' name='use_billing_address'></div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>
                    <h2>Use a Coupon Code</h2>
                    <?php
                        $attrs = array('class' => 'form-bordered', 'id' => 'form-send-order');
                        $session_user = session_logged_in();
                    ?>
                    <?php echo form_open('client/shopping_cart/order', $attrs); ?>
                        <div class="row">
                            <div class="form-group col-xs-12 form-group controls">
                                <label>Coupon</label>
                                <?php $data = array('id' => 'coupon', 'class' => 'form-control'); ?>
                                <?php echo form_input('coupon', '', $data); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-default btn-confirm-order"><?php echo $this->lang->line('ok') ?></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <h2>Order notification</h2>
                    <div class="row">
                        <div class="checkbox">
                            <label>
                              <input type='checkbox' name='receive_email'>I would like to receive up-to-the-minute order and shipping status information and Email Specials.
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <h2>Order Summary</h2>
            <p>For new customers who have not previously purchased with the Guide</p>
            <button class='btn btn-sm btn-primary'>Place order</button>
        </div>
    </div>
</div>
