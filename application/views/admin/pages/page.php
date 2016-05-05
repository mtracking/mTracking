<div id="page-content" style="min-height: 894px;">
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo (!empty($page)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
            </div>
            <!-- END Horizontal Form Title -->
            <!-- Horizontal Form Content -->
            <?php $attrs = array('id' => 'form-page', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($page)) ? 'update' : 'create'; ?>
            <?php echo (!empty($page)) ? form_open('admin/pages/update/'.$page->id, $attrs) : form_open('admin/pages/store', $attrs); ?>
                <div class="col-sm-offset-1 col-sm-11 messages"></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('page_title') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_title')) ?>
                        <?php echo form_input('page_title', set_value('page_title', (!empty($page)) ? $page->title : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('content') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('id' => 'summernote', 'class' => 'form-control', 'placeholder' => $this->lang->line('hint_content')) ?>
                        <?php echo form_textarea('content', set_value('content', (!empty($page)) ? $page->content : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-11 col-sm-offset-1">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            echo form_submit($attrs_submit, (!empty($page)) ? $this->lang->line('update') : $this->lang->line('create'));
                        ?>
                        <a href="javascript:void(0)" data-url='<?php echo base_url('admin/pages/'.PREVIEW) ?>' target="_blank" class='btn btn-sm btn-default btn-preview'>Preview</a>
                    </div>
                </div>
            <?php echo form_close() ?>
            <!-- END Horizontal Form Content -->
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("textarea[name='content']").html($("textarea[name='content']").text());
        });</script>
</div>
<!-- END Page Content -->
