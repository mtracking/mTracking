<!-- Page content -->
<div id="page-content" style="min-height: 894px;">
	<div class="block">
        <div class="block-title">
            <h2><strong><?php echo $this->lang->line('form_add_title'); ?></strong></h2>
        </div>
        <?php  ?>
        <?php $form_attr = [
                        'id' => 'form-category',
						'method' => 'post',
						'class' => 'form-horizontal form-bordered block hidden-lt-ie9',
                        'data-request' => (!empty($data['category']))?'update':'create',
					];
		?>
        <?php echo form_open($data['url'], $form_attr); ?>
            <div class="messages col-sm-offset-3 col-sm-6"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="type_label"><?php echo $this->lang->line('txt_add_cate_name'); ?></label>
                <div class="col-sm-6">
                	<?php $type_label_attr = [
                				'name' => 'name',
                				'id' => 'type_label',
                				'class' => 'form-control',
                                'placeholder' => $this->lang->line('txt_add_cate_desc_hint'),
                			];
                            // echo $data->name;
                	?>
                	<?php echo form_input($type_label_attr, set_value('name',(empty($data['category'])) ? '' : $data['category']->name)); ?>

                </div>
            </div>
<!--             <div class="form-group">
                <label class="col-sm-3 control-label" for="type_details"><?php
                	echo $this->lang->line('txt_add_cate_desc');
                 ?></label>
                <div class="col-sm-6">
                    <?php $type_details_attr = [
                            'name' => 'type_details',
                            'id' => 'type_details',
                            'class' => 'form-control',
                            'rows' => '5',
                            'placeholder' => $this->lang->line('txt_add_cate_desc_hint'),

                        ]
                    ?>
                    <?php echo form_textarea($type_details_attr, set_value('type_label',(empty($data['category'])) ? '' : $data['category']->description)); ?>
                </div>
            </div> -->
            <div class="form-group form-actions">
                <div class="col-sm-9 col-sm-offset-3">
                    <button id = 'add_cate_btn' type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i><?php echo $data['label']; ?></button>
                    <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> <?php echo $this->lang->line('txt_reset_btn'); ?></button>
                </div>
            </div>
        <?php echo form_close(); ?>
        <!-- END Horizontal Form Content -->
    </div>
</div>
<!-- END Page Content -->
