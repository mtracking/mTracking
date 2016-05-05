<div id="page-content" style="min-height: 894px;">
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo (!empty($user)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
            </div>
            <!-- END Horizontal Form Title -->
            <!-- Horizontal Form Content -->
            <div class="col-sm-offset-3 col-sm-9 messages"></div>
            <?php if (!empty($user)): ?>
                <div class='row'>
                    <div class='form-group'>
                        <div class="col-sm-offset-3 col-sm-6 text-center" style='padding: 0 0 20px 20px;'>
                            <img class='img-responsive img-circle img-thumbnail img-avatar' height=150 width=150 src='<?php echo (!is_null($user->avatar_file_name)) ? base_url(LINK_TO_GET_USERS_IMAGE.$user->avatar_file_name) : base_url(LINK_TO_GET_USERS_IMAGE. DEFAULT_IMAGE) ?>'>
                            <?php $attrs = array('id' => 'form-upload-avatar') ?>
                            <?php echo form_open_multipart('admin/users/upload_avatar/'.$user->id, $attrs) ?>
                                <span class="btn-file"> <i class="fa fa-file-image-o"></i>
                                    <input type="file" id='file' name="file" size="20" />
                                </span>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php $attrs = array('id' => 'form-user', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($user)) ? 'update' : 'create'; ?>
            <?php echo (!empty($user)) ? form_open('admin/users/update/'.$user->id, $attrs) : form_open('admin/users/store', $attrs); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('name_text') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_name')) ?>
                        <?php echo form_input('full_name', set_value('full_name', (!empty($user)) ? $user->full_name : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('email_text') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_email')) ?>
                        <?php if (!empty($user)) $attrs['disabled'] = 'disabled'; ?>
                        <?php echo form_input('email', set_value('email', (!empty($user)) ? $user->email : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('phone_text') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_phone')) ?>
                        <?php echo form_input('phone', set_value('phone', (!empty($user)) ? $user->phone : ''), $attrs); ?>
                    </div>
                </div>
                <?php if (!empty($user)): ?>
                    <div class='form-group'>
                        <label class="col-sm-3 control-label"></label>
                        <div class='col-sm-6'>
                            <div class='checkbox'>
                                <label class="">
                                    <?php $attrs = array('class' => 'form-control') ?>
                                    <?php echo form_checkbox('want_to_change_password', '', FALSE); ?>
                                    <?php echo $this->lang->line('want_to_change_password') ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group change-password-field" style="<?php echo (!empty($user)) ? 'display:none' : '' ?>">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('password_text') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_password')) ?>
                        <?php echo form_password('password',NULL, $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('address_text') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_address')) ?>
                        <?php echo form_input('address', set_value('address', (!empty($user)) ? $user->address : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('role') ?></label>
                    <div class="col-sm-3">
                        <?php
                            $options = array(
                                ADMIN => $this->lang->line('admin'),
                                CUSTOMER => $this->lang->line('customer'),
                                DISTRIBUTOR => $this->lang->line('distributor'));
                            $attrs = array('class' => 'form-control');
                         ?>
                        <?php echo form_dropdown('role', $options, set_value('role', (!empty($user)) ? $user->role_id : $options[0]), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-6 col-sm-offset-3">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            $attrs_reset = array( 'class' => 'btn btn-sm btn-warning');
                            echo form_submit($attrs_submit, (!empty($user)) ? $this->lang->line('update') : $this->lang->line('create'));
                            echo form_reset($attrs_reset, $this->lang->line('reset'));
                        ?>
                    </div>
                </div>
            <?php echo form_close() ?>
            <!-- END Horizontal Form Content -->
        </div>
        <!-- Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="galleryModalLabel"><?php echo $this->lang->line('add_images') ?></h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/users/upload') ?>" class="dropzone needsclick dz-clickable" id="images-upload">
                    <div class="dz-message needsclick">
                        <?php echo $this->lang->line('image_upload') ?><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editGalleryModal" tabindex="-1" role="dialog" aria-labelledby="editGalleryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editGalleryModalLabel"><?php echo $this->lang->line('remove_images') ?></h4>
            </div>
            <div class="modal-body">
                 <?php if (!empty($pictures)): ?>
                    <div class="row">
                            <div class="gallery" data-toggle="lightbox-gallery">
                                <div class="row">
                                <?php foreach ($pictures as $picture) : ?>
                                    <div class="col-sm-4">
                                        <a href="javascript:void(0)" class="remove-image" title="Image Info">
                                            <i class="fa fa-times" ></i>
                                            <img class="" src="<?php echo base_url(LINK_TO_GET_userS_IMAGE.$picture->image_file_name) ?>"  />
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-primary"><?php echo $this->lang->line('remove_images') ?></button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END Page Content -->
