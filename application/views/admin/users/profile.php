<!-- Page content -->
<div id="page-content" style="min-height: 894px;">
    <div class="block">
        <div class="block-title">
            <h2><strong><?php echo $this->lang->line('profile_view_name'); ?></strong></h2>
        </div>
        <div class="row">
            <div class="col-sm-3 col-xs-6 col-sm-offset-0 col-xs-offset-3 site-block">
                <div class="site-block text-center">
                    <?php $img_url = ($data['user'] ? base_url('assets/img/users') . '/' . $data['user']->avatar_file_name : ''); ?>
                    <div class="profile-picture">
                        <img class="img-thumbnail img-responsive" src = "<?php echo $img_url; ?>"></img>
                    </div>
                    <div class = 'profile-action'>
                        <a data-toggle="modal"
                            data-target = '#myModal'
                            class="btn btn-primary"><i class="fa fa-key"></i></a>
                        <?php $attrs = array('id' => 'form-upload-avatar', 'style' => 'display:inline') ?>
                        <?php echo form_open_multipart('client/user/upload_avatar', $attrs) ?>
                            <span class="btn-file"> <i class="fa fa-picture-o"></i>
                                <input type="file" id='file' name="file" size="20" />
                            </span>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 col-xs-12">
                <?php $user_form_attr =
                    [
                        'name' => 'update_profile_form',
                        'id' => 'update-profile-form',
                        'data-action-url' => base_url('admin/users/update_profile_of_user'),
                        'method' => 'post',
                        'class' => 'form-horizontal block hidden-lt-ie9',
                        'data-request' => 'update',
                    ];

                    $update_profile_url = base_url('admin/users/update');
                ?>
                <?php echo form_open($update_profile_url, $user_form_attr); ?>
                    <div id = 'profile-messages' class="col-md-offset-3 col-md-6"></div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="form-label" for = "user_name"><?php echo $this->lang->line('name_text') . ':';?></label>
                        <?php
                            $input_name_attr =
                                        [
                                            'id' => 'user_name',
                                            'name' => 'user_name',
                                            'class' => 'form-control',
                                            'placeholder' => $this->lang->line('name_text'),
                                        ];
                            echo form_input($input_name_attr, set_value('user_name', ($data['user'] ? $data['user']->full_name : '')));
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for = "user_name"><?php echo $this->lang->line('email_text') . ':';?></label>
                        <?php
                            $input_email_attr =
                                        [
                                            'id' => 'user_email',
                                            'name' => 'user_email',
                                            'class' => 'form-control',
                                            'placeholder' => $this->lang->line('email_text'),
                                        ];
                            echo form_input($input_email_attr, set_value('user_email', ($data['user'] ? $data['user']->email: '')));
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for = "user_name"><?php echo $this->lang->line('phone_text') . ':';?></label>
                        <?php
                            $input_phone_attr =
                                        [
                                            'id' => 'phone_number',
                                            'name' => 'phone_number',
                                            'class' => 'form-control',
                                            'placeholder' => $this->lang->line('phone_text'),
                                        ];
                            echo form_input($input_phone_attr, set_value('phone_number', ($data['user'] ? $data['user']->phone : '')));
                        ?>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button id = 'update_profile_btn' type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i><?php echo $this->lang->line('txt_update_btn'); ?></button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> <?php echo $this->lang->line('txt_reset_btn'); ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <!--Change password section -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                  <!-- confirm sectionn-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><?php echo $this->lang->line('change_password_text'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-offset-3 col-md-6 pwd-messages"></div>
                        <div class="clearfix"></div>
                            <?php
                            $change_pwd_url = base_url('admin/users/change_password');
                            $user_form_attr =
                                [
                                    'id' => 'change-pwd-form',
                                    'method' => 'post',
                                    'class' => 'form-vertical hidden-lt-ie9',
                                    'data-action-url' => $change_pwd_url,
                                    'data-request' => 'change_pwd',
                                ];
                            ?>
                            <?php echo form_open('', $user_form_attr); ?>
                            <div class="form-group">
                                <label for = 'pwd_old'><?php echo $this->lang->line('old_password_text'); ?></label>
                                <?php
                                    $old_password_input =
                                    [
                                        'id' => 'pwd_old',
                                        'class' => 'form-control',
                                        'name' => 'pwd_old',
                                        'type' =>'password'
                                    ];
                                    echo form_input($old_password_input);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for = 'pwd_old'><?php echo $this->lang->line('new_password_text'); ?></label>
                                <?php
                                    $new_password_text =
                                    [
                                        'id' => 'pwd_new',
                                        'class' => 'form-control',
                                        'name' => 'pwd_new',
                                        'type' =>'password'
                                    ];
                                    echo form_input($new_password_text);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for = 'pwd_old'><?php echo $this->lang->line('new_password_confirm_text'); ?></label>
                                <?php
                                    $new_password_confirm_text =
                                    [
                                        'id' => 'pwd_new_confirm',
                                        'class' => 'form-control',
                                        'name' => 'pwd_new_confirm',
                                        'type' =>'password'
                                    ];
                                    echo form_input($new_password_confirm_text);
                                ?>
                            </div>
                            <?php
                                $send_btn_attr =
                                [
                                    'class' => 'btn btn-danger',
                                    // 'data-dismiss' => 'modal',
                                    'data-action-url' => base_url('admin/categories/delete'),
                                    'id' => 'change_pwd_btn'
                                ];

                                echo form_submit('change_pwd_btn', $this->lang->line('change_password_text'), $send_btn_attr);
                             ?>
                            <?php echo form_close(); ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" data-action-url = '<?php echo base_url('admin/categories/delete'); ?>' class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('close_text'); ?></button>
                    </div>
                  </div>

                </div>
            </div>
            <!-- end change password section -->
        </div>

    </div>
</div>
<!-- END Page Content -->
