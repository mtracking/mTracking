<div id="page-content" style="min-height: 894px;">
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo (!empty($subtype)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
            </div>
            <!-- END Horizontal Form Title -->
            <!-- Horizontal Form Content -->
            <?php $attrs = array('id' => 'form-subtype', 'class' => 'form-horizontal form-bordered'); ?>
            <?php $attrs['data-request'] = (!empty($subtype)) ? 'update' : 'create'; ?>
            <?php echo (!empty($subtype)) ? form_open('admin/subtypes/update/'.$subtype->id, $attrs) : form_open('admin/subtypes/store', $attrs); ?>
                <div class="col-sm-offset-3 col-sm-6 messages"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('category') ?></label>
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
                        <?php echo form_dropdown('category', $options, set_value('category', (!empty($subtype)) ? $subtype->category_id : $first_element), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('type') ?></label>
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
                        <?php echo form_dropdown('type', $options, set_value('type', (!empty($subtype)) ? $subtype->type_id : $first_element), $attrs); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('producing_year') ?></label>
                    <div class="col-sm-3">
                        <input type="number" name="producing_year" value="<?php echo (!empty($subtype)) ? $subtype->producing_year : date('Y') ?>" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $this->lang->line('factory') ?></label>
                    <div class="col-sm-6">
                        <?php $attrs = array('class' => 'form-control', 'placeholder' => $this->lang->line('hint_factory')) ?>
                        <?php echo form_input('factory', set_value('factory', (!empty($subtype)) ? $subtype->factory : ''), $attrs); ?>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-sm-6 col-sm-offset-3">
                        <?php
                            $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                            $attrs_reset = array( 'class' => 'btn btn-sm btn-warning');
                            echo form_submit($attrs_submit, (!empty($subtype)) ? $this->lang->line('update') : $this->lang->line('create'));
                            echo form_reset($attrs_reset, $this->lang->line('reset'));
                        ?>
                    </div>
                </div>
            <?php echo form_close() ?>
            <!-- END Horizontal Form Content -->
        </div>
</div>
<!-- END Page Content -->
