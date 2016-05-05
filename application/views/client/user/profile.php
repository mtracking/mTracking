<div id="page-content" class="container" style='padding-top:10px'>
    <div class="row">
        <?php $user = session_logged_in() ?>
        <?php if($user): ?>
        <div class="col-sm-4 text-center profile">
            <img class='img-responsive img-circle img-thumbnail img-avatar' height=200 width=200 src='<?php echo (!is_null($user['avatar'])) ? $user['avatar'] : base_url(LINK_TO_GET_USERS_IMAGE. DEFAULT_IMAGE) ?>'>
            <div class='h3'>
                <strong class='profile-name'><?php echo $user['full_name'] ?></strong>
                <a href="#update-profile" class='btn-update-profile'> <i class="fa fa-pencil"></i></a>
                <?php $attrs = array('id' => 'form-upload-avatar', 'style' => 'display:inline') ?>
                <?php echo form_open_multipart('client/user/upload_avatar', $attrs) ?>
                    <span class="btn-file"> <i class="fa fa-file-image-o"></i>
                        <input type="file" id='file' name="file" size="20" />
                    </span>
                <?php echo form_close(); ?>
            </div>
            <hr class='hr-profile'>
            <div class='profile-email'><i class="fa fa-envelope"></i> <?php echo $user['email'] ?></div>
            <div class=''><i class="fa fa-mobile"></i> <span class='profile-phone'><?php echo $user['phone'] ?></span></div>
            <div class='profile-address'><i class="fa fa-map-marker"></i> <span class='profile-phone'><?php echo $user['address'] ?></span></div>
            <div class='profile-products'><?php echo $this->lang->line('bought') ?>: <a href="<?php echo base_url('client/history') ?>" alt="" target='_blank'><?php echo $products_bought ?></a> <i class="fa fa-product-hunt"></i></div>
            <p>
                <div><a class='btn btn-primary btn-sm btn-update-password'><?php echo $this->lang->line('change_password') ?></a></div>
            </p>
            <div class='clearfix'></div>
        </div>
        <div class='col-sm-8'>
            <div class='messages'></div>
            <div id='update-profile'>
                <h2><?php echo $this->lang->line('update_profile') ?></h2>
                <?php $attrs = array('class' => 'form-bordered', 'id' => 'form-update-profile'); ?>
                <?php echo form_open('client/user/edit/profile', $attrs); ?>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('full_name') ?></label>
                            <?php $data = array('id' => 'full_name', 'class' => 'form-control', 'placeholder' => $this->lang->line('full_name')); ?>
                            <?php echo form_input('full_name', set_value('full_name', $user['full_name']), $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('phone') ?></label>
                            <?php $data = array('id' => 'phone', 'class' => 'form-control', 'placeholder' => $this->lang->line('phone')); ?>
                            <?php echo form_input('phone', set_value('phone', $user['phone']), $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('address') ?></label>
                            <?php $data = array('id' => 'address', 'class' => 'form-control', 'placeholder' => $this->lang->line('address')); ?>
                            <?php echo form_input('address', set_value('address', $user['address']), $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('postal_code') ?></label>
                            <?php $data = array('id' => 'postal_code', 'class' => 'form-control', 'placeholder' => $this->lang->line('postal_code')); ?>
                            <?php echo form_input('postal_code', set_value('postal_code', $user['postal_code']), $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-raised btn-lg btn-success"><?php echo $this->lang->line('ok') ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div id='update-password' style='display: none'>
                <h2><?php echo $this->lang->line('update_password') ?></h2>
                <?php $attrs = array('class' => 'form-bordered', 'id' => 'form-update-password'); ?>
                <?php echo form_open('client/user/edit/password', $attrs); ?>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('current_password') ?></label>
                            <?php $data = array('id' => 'current_password', 'class' => 'form-control', 'placeholder' => $this->lang->line('current_password')); ?>
                            <?php echo form_password('current_password', '', $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('new_password') ?></label>
                            <?php $data = array('id' => 'new_password', 'class' => 'form-control', 'placeholder' => $this->lang->line('new_password')); ?>
                            <?php echo form_password('new_password', '', $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8 form-group controls">
                            <label class='control-label'><?php echo $this->lang->line('confirm_password') ?></label>
                            <?php $data = array('id' => 'password_confirm', 'class' => 'form-control', 'placeholder' => $this->lang->line('confirm_password')); ?>
                            <?php echo form_password('password_confirm', '', $data); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-raised btn-success"><?php echo $this->lang->line('ok') ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <?php else: ?>
            <div class='col-sm-12 text-center'>
                <p class='alert alert-info'>Login to use bla bla ...</p>
                <p><a href="<?php echo base_url('login') ?>" class='btn btn-primary btn-sm login'><?php echo $this->lang->line('login') ?></a></p>
            </div>
        <?php endif; ?>
    </div>
</div>