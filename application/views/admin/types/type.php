<div id="page-content" style="min-height: 894px;">
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo (!empty($type)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
            </div>
            <!-- END Horizontal Form Title -->
            <!-- Horizontal Form Content -->
            <?php $attrs = array('id' => 'form-type', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($type)) ? 'update' : 'create'; ?>
            <?php echo (!empty($type)) ? form_open('admin/types/update/'.$type->id, $attrs) : form_open('admin/types/store', $attrs); ?>
                <div class="col-sm-offset-3 col-sm-6 messages"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('name') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_name')) ?>
                        <?php echo form_input('name', set_value('name', (!empty($type)) ? $type->name : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('type_details') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_type_details')) ?>
                        <?php echo form_textarea('type_details', set_value('type_details', (!empty($type)) ? $type->type_details : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('sourcing') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_sourcing')) ?>
                        <?php echo form_textarea('sourcing', set_value('sourcing', (!empty($type)) ? $type->sourcing : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('characteristics') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_characteristics')) ?>
                        <?php echo form_input('characteristics', set_value('characteristics', (!empty($type)) ? $type->characteristics : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('storage_temp') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_storage_temp')) ?>
                        <?php echo form_input('storage_temp', set_value('storage_temp', (!empty($type)) ? $type->storage_temp : ''), $attrs); ?>
                    </div>
                    <div class='col-sm-3 control-label' style='text-align: left'><span><?php echo $this->lang->line('for_ex_storage_temp')?></span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('country') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_country')) ?>
                        <?php echo form_input('country', set_value('country', (!empty($type)) ? $type->country : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('category') ?></label>
                    <div class="col-sm-3">
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
                            $attrs = array('class' => 'form-control');
                        ?>
                        <?php echo form_dropdown('category', $options, set_value('category', (!empty($type)) ? $type->category_id : $first_element), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-6 col-sm-offset-3">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            $attrs_reset = array( 'class' => 'btn btn-sm btn-warning');
                            echo form_submit($attrs_submit, (!empty($type)) ? $this->lang->line('update') : $this->lang->line('create'));
                            echo form_reset($attrs_reset, $this->lang->line('reset'));
                        ?>
                    </div>
                </div>
            <?php echo form_close() ?>
            <!-- END Horizontal Form Content -->
        </div>
</div>
<!-- END Page Content -->
