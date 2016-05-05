<div id="page-content" style="min-height: 894px;">
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo (!empty($post)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
            </div>
            <!-- END Horizontal Form Title -->
            <!-- Horizontal Form Content -->
            <?php $attrs = array('id' => 'form-post', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($post)) ? 'update' : 'create'; ?>
            <?php echo (!empty($post)) ? form_open('admin/posts/update/'.$post->id, $attrs) : form_open('admin/posts/store', $attrs); ?>
                <div class="col-sm-offset-1 col-sm-11 messages"></div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('post_title') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_title')) ?>
                        <?php echo form_input('post_title', set_value('post_title', (!empty($post)) ? $post->title : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('category') ?></label>
                    <div class="col-sm-5">
                    <?php
                            $options = array();
                            $first_element = '';
                            if (!empty($categories))
                            {
                                $first_element = $categories[0]->id;
                                foreach ($categories as $key => $category)
                                {
                                    $options[$category->id] = $category->name;
                                }
                            }
                            $attrs = array('class' => 'form-control', 'data-category-get-types-url' => base_url('ajax/types/category'));
                         ?>
                        <?php echo form_dropdown('category', $options, set_value('category', (!empty($post)) ? $post->category_id : $first_element), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('type') ?></label>
                    <div class="col-sm-5">
                    <?php
                            $options = array();
                            $first_element = '';
                            if (!empty($types))
                            {
                                $first_element = $types[0]->id;
                                foreach ($types as $key => $type)
                                {
                                    $options[$type->id] = $type->name;
                                }
                            }
                            $attrs = array('class' => 'form-control');
                         ?>
                        <?php echo form_dropdown('type', $options, set_value('type', (!empty($post)) ? $post->type_id : $first_element), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label"><?php echo $this->lang->line('content') ?></label>
                    <div class="col-sm-11">
                        <?php $attrs = array('id' => 'summernote', 'class' => 'form-control', 'placeholder' => $this->lang->line('hint_content')) ?>
                        <?php echo form_textarea('content', set_value('content', (!empty($post)) ? $post->content : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-11 col-sm-offset-1">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            echo form_submit($attrs_submit, (!empty($post)) ? $this->lang->line('update') : $this->lang->line('create'));
                        ?>
                        <a href="javascript:void(0)" data-url='<?php echo base_url('admin/posts/'.PREVIEW) ?>' target="_blank" class='btn btn-sm btn-default btn-preview'>Preview</a>
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
