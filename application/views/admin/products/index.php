<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
            <?php $attrs = array('id' => 'form-search-posts', 'method' => 'get', 'class' => '') ?>
            <?php echo form_open('admin/products', $attrs); ?>
                <div class="form-group">
                <?php $attrs = array("id" => 'top-search', 'class' =>'form-control', 'placeholder' => 'Search...') ?>
                <?php echo form_input('search', set_value('search', $this->input->get('search')), $attrs); ?>
                </div>
            <?php echo form_close() ?>
            </div>
            <h1>
            <?php echo $this->lang->line('title') ?>
            </h1>
        </div>
    </div>
    <div class="block">
    <!-- Responsive Full Title -->
        <div class="block-title">
            <div>
                <h2><strong><?php echo $this->lang->line('list') ?></strong> <?php echo $this->lang->line('title') ?></h2>
                <div class="block-options">
                    <div class='row'>
                        <?php $attrs = array('id' => 'form-get-products', 'method' => 'get'); ?>
                        <?php echo form_open('admin/products/index', $attrs); ?>
                        <div class='row' style='margin:0px'>
                            <div class="form-group col-sm-5" style="margin-bottom: 5px">
                                <label class="col-sm-4 control-label" for="example-select"> <?php echo $this->lang->line('category') ?></label>
                                <div class="col-sm-8">
                                    <?php
                                        $options = array('0' => $this->lang->line('all'));
                                        $first_element = '';
                                        if (!empty($categories))
                                        {
                                            $first_element = (!is_null($this->input->get('category'))) ? $this->input->get('category') : '0';
                                            foreach ($categories as $key => $category)
                                            {
                                                $options[$category->id] = $category->name;
                                            }
                                        }
                                        $attrs = array('class' => 'form-control');
                                    ?>
                                    <?php echo form_dropdown('category', $options, set_value('category', $first_element), $attrs); ?>
                                </div>
                            </div>
                            <div class="form-group col-sm-5" style="margin-bottom: 5px">
                                <label class="col-sm-4 control-label" for="example-select"> <?php echo $this->lang->line('type') ?></label>
                                <div class="col-sm-8">
                                    <?php if(sizeof($types) > 0): ?>
                                        <select class="form-control" name="type">
                                            <option value="0" data-category="0">All</option>
                                            <?php foreach($types as $key => $type): ?>
                                             <?php
                                                $selected = '';
                                                if ($this->input->get('type') == $type->id) $selected = 'selected';
                                             ?>
                                                <option value="<?php echo $type->id ?>" <?php echo $selected ?> data-category="<?php echo $type->category_id ?>"><?php echo $type->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin:0px'>
                            <div class="form-group col-sm-5" style="margin-bottom: 5px">
                                <label class="col-sm-4 control-label" for="example-select"> <?php echo $this->lang->line('subtype') ?></label>
                                <div class="col-sm-8">
                                    <?php if(sizeof($subtypes) > 0): ?>
                                        <select class="form-control" name="subtype">
                                            <option value="0" selected data-type="0">All</option>
                                            <?php foreach($subtypes as $subtype): ?>
                                                <?php
                                                    $selected = '';
                                                    if ($this->input->get('subtype') == $subtype->id) $selected = 'selected';
                                                 ?>
                                                <option value="<?php echo $subtype->id ?>" <?php echo $selected ?> data-type="<?php echo $subtype->type_id ?>"><?php echo $subtype->type_name. ' - '. $subtype->producing_year ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group col-sm-5" style="margin-bottom: 5px">
                                <label class="col-sm-4 control-label" for="example-select"> <?php echo $this->lang->line('batch') ?></label>
                                <div class="col-sm-8">
                                    <?php if(sizeof($batches) > 0): ?>
                                        <select class="form-control" name="batch">
                                            <option value="0" selected data-subtype="0">All</option>
                                            <?php foreach($batches as $batch): ?>
                                                <?php
                                                    $selected = '';
                                                    if ($this->input->get('batch') == $batch->id) $selected = 'selected';
                                                 ?>
                                                <option value="<?php echo $batch->id ?>" <?php echo $selected ?> data-subtype="<?php echo $batch->subtype_id ?>"><?php echo $batch->lot ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group col-sm-2 text-center" style="margin-bottom: 5px">
                                <button class='btn btn-info btn-search'>Search <i class='fa fa-search'></i></button>
                            </div>
                        </div>
                        <script type="text/javascript">
                                var category_id = $("select[name='category']").val();
                                if (category_id != 0)
                                {
                                    $.each($("select[name='type']").find('option'), function(index, val) {
                                        if ($(this).data('category') != category_id)
                                        {
                                        $(this).css('display', 'none');
                                        }
                                    });
                                }
                                var type_id = $("select[name='type']").val();
                                if (type_id !=0)
                                {
                                    $.each($("select[name='subtype']").find('option'), function(index, val) {
                                        if ($(this).data('type') != type_id)
                                        {
                                        $(this).css('display', 'none');
                                        }
                                    });
                                }
                                var subtype_id = $("select[name='subtype']").val();
                                if (subtype_id !=0)
                                {
                                    $.each($("select[name='batch']").find('option'), function(index, val) {
                                        if ($(this).data('subtype') != subtype_id)
                                        {
                                            $(this).css('display', 'none');
                                        }
                                    });
                                }
                        </script>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Responsive Full Title -->
        <!-- Responsive Full Content -->
        <div class="table-responsive table-products">
            <div class="messages"></div>
            <table class="table table-vcenter table-striped">
                <thead>
                    <tr>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('id') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('serial_no') ?></th>
                        <th class="text-center col-sm-4"><?php echo $this->lang->line('bottle') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('producing_date') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('status_product') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $offset = $this->uri->segment(3, 0) + 1; ?>
                     <?php foreach($products as $product ):
                    ?>
                    <tr>
                        <td class="text-center col-sm-1"><?php echo $offset++; ?></td>
                        <td class="text-center col-sm-2"><a href="<?php echo base_url('admin/products/details/'.$product->serial_no) ?>"><?php echo $product->serial_no; ?></a></td>
                        <td class="text-center col-sm-4"><?php echo $product->type_name; ?></td>
                        <td class="text-center col-sm-2"><?php echo date("m-d-Y", strtotime($product->producing_date)); ?></td>
                        <td class="text-center col-sm-2">
                            <?php if ($product->status_product_id == PRODUCT_OPENED_STATUS): ?>
                                <span class="label label-danger">
                            <?php else: ?>
                                <span class="label label-success">
                            <?php endif; ?>
                                <?php echo $product->status_product_name; ?>
                                <span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $page_links; ?>
        </div>
        <!-- END Responsive Full Content -->
    </div>
    <!--Confirm deleting -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <!-- confirm sectionn-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <div id="deleting-confirm"></div>
            </div>
            <div class="modal-footer">
              <button type="button" id = 'deleted-confirm-btn' data-action-url = '<?php echo base_url('admin/types/delete'); ?>' class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
    </div>
    <!-- end confirm section -->
</div>