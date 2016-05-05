<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
            <?php $attrs = array('id' => 'form-search-batches', 'method' => 'get', 'class' => '') ?>
            <?php echo form_open('admin/batches', $attrs); ?>
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
                <h2><?php echo $this->lang->line('list_of_batches') ?></h2>
                <div class="block-options pull-right">
                    <a href="<?php echo base_url('admin/batches/add'); ?>" type="submit" class="btn btn-sm btn-primary"><?php echo $this->lang->line('heading_create') ?></a>
                </div>
            </div>
        </div>
        <!-- END Responsive Full Title -->
        <!-- Responsive Full Content -->
        <div class="table-responsive">
            <div class="messages"></div>
            <table class="table table-vcenter table-striped">
                <thead>
                    <tr>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('id') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('lot#') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('producing_date') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('expiry_date') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('subtype') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('volume') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('tally') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $offset = $this->uri->segment(3, 0) +1; ?>
                     <?php foreach($batches as $batch ):
                    ?>
                    <tr id="batch-<?php echo $batch->id ?>">
                        <td class="text-center col-sm-1"><?php echo $offset++; ?></td>
                        <td class="text-center col-sm-2"><a href="<?php echo base_url('admin/products?batch='.$batch->id.'&category='.$batch->category_id.'&type='.$batch->type_id.'&subtype='. $batch->subtype_id) ?>" ><?php echo $batch->lot; ?></a></td>
                        <td class="text-center col-sm-2"><?php echo date("m-d-Y", strtotime($batch->producing_date)); ?></td>
                        <td class="text-center col-sm-2"><?php echo (strtotime($batch->expiry_date) > 0) ? date("m-d-Y", strtotime($batch->expiry_date)): 'None'; ?></td>
                        <td class="text-center col-sm-2"><?php echo $batch->type_name. ' - '.$batch->producing_year; ?></td>
                        <td class="text-center col-sm-1"><?php echo $batch->volume; ?></td>
                        <td class="text-center col-sm-1"><?php echo $batch->products_opened.' / '.$batch->quantity; ?></td>
                        <td class="text-center col-sm-1">
                            <div class="btn-group-xs">
                                <a href="<?php echo base_url('admin/batches/label/'.$batch->id); ?>" data-toggle="tooltip" title="Print Label" class="btn btn-block btn-success">Label <i class="fa fa-picture-o"></i></a>
                                <a href="<?php echo base_url('admin/batches/export/'.$batch->id); ?>" data-toggle="tooltip" title="Print QrCode" class="btn btn-block btn-primary">Qrcode <i class="fa fa-qrcode"></i></a>
                                <a href="<?php echo base_url('admin/batches/update_status/'.$batch->id.'?is_active='.NOT_ACTIVE) ?>" data-toggle="tooltip" title="Remove" class="btn btn-block btn-xs btn-danger btn-remove" >Remove <i class='fa fa-trash'></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $page_links; ?>
        </div>
        <!-- END Responsive Full Content -->
    </div>
</div>