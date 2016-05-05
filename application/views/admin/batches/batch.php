<div id="page-content" class='store' style="min-height: 894px;">
    <div class="block">
        <!-- Horizontal Form Title -->
        <div class="block-title">
            <h2><?php echo (!empty($batch)) ? $this->lang->line('heading_update') : $this->lang->line('heading_create') ?></h2>
        </div>
        <!-- END Horizontal Form Title -->
        <!-- Horizontal Form Content -->
        <div class="loading-progress"></div>
        <?php $attrs = array('id' => 'form-batches', 'class' => 'form-horizontal form-bordered'); ?>
        <?php $attrs['data-request'] = (!empty($batch)) ? 'update' : 'create'; ?>
        <?php echo (!empty($batch)) ? form_open('admin/batches/update/'.$batch->id, $attrs) : form_open('admin/batches/store', $attrs); ?>
            <div class="col-sm-offset-3 col-sm-6 messages"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('producing_date') ?></label>
                <div class="col-sm-3">
                    <?php $disabled = (!empty($batch)) ? 'disabled' : ''; ?>
                    <input type="date" name="producing_date" <?php echo $disabled ?> value="<?php echo (!empty($batch)) ? date('Y-m-d', strtotime($batch->producing_date)) : date('Y-m-d') ?>" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('expiry_date') ?></label>
                <div class="col-sm-3">
                    <input type="date" name="expiry_date" <?php echo $disabled ?> value="<?php echo (!empty($batch)) ? date('Y-m-d', strtotime($batch->expiry_date)) : '' ?>" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('quantity') ?></label>
                <div class="col-sm-3">
                    <input type="number" name="quantity" <?php echo $disabled ?> min="1" value="<?php echo (!empty($batch)) ? $batch->quantity : '' ?>" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('volume') ?></label>
                <div class="col-sm-3">
                    <input type="number" name="volume" <?php echo $disabled ?> min="1" value="<?php echo (!empty($batch)) ? $batch->volume : '' ?>" class="form-control" >
                </div>
            </div>
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
                    <?php echo form_dropdown('category', $options, set_value('category', (!empty($batch)) ? $batch->category_id : $first_element), $attrs); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('type') ?></label>
                <div class="col-sm-6">
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
                        $attrs = array('class' => 'form-control', 'data-type-get-subtypes-url' => base_url('ajax/subtypes/type'));
                     ?>
                    <?php echo form_dropdown('type', $options, set_value('type', (!empty($batch)) ? $batch->type_id : $first_element), $attrs); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $this->lang->line('subtype') ?></label>
                <div class="col-sm-6">
                    <?php
                        $options = array();
                        $first_element = '';
                        if (!empty($subtypes))
                        {
                            $first_element = $subtypes[0]->id;
                            foreach ($subtypes as $key => $subtype)
                            {
                                $options[$subtype->id] = $subtype->type_name. ' - '. $subtype->producing_year;
                            }
                        }
                        $attrs = array('class' => 'form-control');
                     ?>
                    <?php echo form_dropdown('subtype', $options, set_value('subtype', (!empty($batch)) ? $batch->subtype_id : $first_element), $attrs); ?>
                </div>
            </div>
            <div class="type-label" style="display:none">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr class="row">
                            <th class="col-sm-3 text-center hidden-xs"><?php echo $this->lang->line('image') ?></th>
                            <th class="col-sm-3 text-center hidden-xs"><?php echo $this->lang->line('type_label') ?></th>
                            <th class="col-sm-3 text-center hidden-xs"><?php echo $this->lang->line('storage_temp') ?></th>
                            <th class="col-sm-3 text-center hidden-xs"><?php echo $this->lang->line('characteristics') ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row">
                            <td class="col-sm-3 text-center hidden-xs">
                                <img class="image" src="<?php echo base_url('assets/img/login_background.jpg') ?>" class="animation-pullDown img-thumbnail" width="150" height="150">
                            </td>
                            <td class="col-sm-3 text-center hidden-xs">
                                <h3 class="animation-pullDown name"></h3>
                            </td>
                            <td class="col-sm-3 text-center hidden-xs">
                                <h3 class="animation-pullDown storage-temp"></h3>
                            </td>
                            <td class="col-sm-3 text-center">
                                <h3 class="animation-pullDown characteristics"></h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group form-actions">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                        $attrs_submit = array( 'class' => 'btn btn-sm btn-primary');
                        $attrs_reset = array( 'class' => 'btn btn-sm btn-warning');
                        echo form_submit($attrs_submit, (!empty($batch)) ? $this->lang->line('update') : $this->lang->line('create'));
                        echo form_reset($attrs_reset, $this->lang->line('reset'));
                    ?>
                    <img class="icon-loading" src="<?php echo base_url('assets/img/loading.gif') ?>" style='display: none' >
                </div>
            </div>
        <?php echo form_close() ?>
        <!-- END Horizontal Form Content -->
    </div>
</div>
<!-- END Page Content -->