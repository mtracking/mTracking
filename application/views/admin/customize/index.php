<div id="page-content" style="min-height: 894px;">
        <div class='block' style='overflow:hidden'>
            <div class="col-sm-offset-1 col-sm-11 messages"></div>
            <?php $attrs = array('id' => 'form-upload-header', 'class' => 'form-horizontal form-bordered') ?>
                <?php echo form_open_multipart('admin/customize/upload_header', $attrs) ?>
                <div class='form-group'>
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('site_background_header') ?></label>
                    <div class='col-sm-9'>
                        <input type="file" id='file' name="file" size="20" />
                    </div>
                </div>
                <div class='form-group'>
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('current_site_background_header') ?></label>
                    <div class='col-sm-6'>
                        <img class='bg-header' src="<?php echo base_url(LINK_TO_GET_TEMPLATE_IMAGE.((!empty($customize->background_file_name)) ? $customize->background_file_name : DEFAULT_IMAGE)) ?>" width='100%' height=200>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
        <div class="block">
            <?php $attrs = array('id' => 'form-customize', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($customize)) ? 'update' : 'create'; ?>
            <?php echo (!empty($customize)) ? form_open('admin/customize/update', $attrs) : form_open('admin/customize/store', $attrs); ?>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('site_title') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_site_title')) ?>
                        <?php echo form_input('site_title', set_value('site_title', (!empty($customize)) ? $customize->site_title : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('footer') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('id' => 'summernote', 'class' => 'form-control', 'placeholder' => $this->lang->line('hint_footer')) ?>
                        <?php echo form_textarea('footer', set_value('footer', (!empty($customize)) ? $customize->footer : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-11 col-sm-offset-1">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            echo form_submit($attrs_submit, (!empty($customize)) ? $this->lang->line('update') : $this->lang->line('create'));
                        ?>
                        <!-- <a href="javascript:void(0)" data-url='<?php echo base_url('admin/customize/'.PREVIEW) ?>' target="_blank" class='btn btn-sm btn-default btn-preview'>Preview</a> -->
                    </div>
                </div>
            <?php echo form_close() ?>
            <!-- END Horizontal Form footer -->
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("textarea[name='footer']").html($("textarea[name='footer']").text());
        });</script>
</div>
<!-- END customize Content -->
