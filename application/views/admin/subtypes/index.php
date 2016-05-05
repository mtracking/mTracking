<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
            <?php $attrs = array('id' => 'form-search-subtypes', 'method' => 'get', 'class' => '') ?>
            <?php echo form_open('admin/subtypes', $attrs); ?>
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
                <h2><?php echo $this->lang->line('list_of_subtypes') ?></h2>
                <div class="block-options pull-right">
                    <a href="<?php echo base_url('admin/subtypes/add'); ?>" type="submit" class="btn btn-sm btn-primary"><?php echo $this->lang->line('heading_create') ?></a>
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
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('subtype') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('factory') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $offset = $this->uri->segment(3, 0) +1; ?>
                     <?php foreach($subtypes as $subtype ):
                    ?>
                    <tr id="subtypes-<?php echo $subtype->id ?>">
                        <td class="text-center col-sm-1"><?php echo $offset++; ?></td>
                        <td class="text-center col-sm-2"><a href="<?php echo base_url('admin/batches?search='.$subtype->id) ?>" ><?php echo $subtype->type_name. ' - '.$subtype->producing_year; ?></a></td>
                        <td class="text-center col-sm-2"><?php echo $subtype->factory; ?></td>
                        <td class="text-center col-sm-2">
                            <div class="btn-group btn-group-xs">
                                <a href="<?php echo base_url('admin/subtypes/edit/'.$subtype->id); ?>" data-toggle="modal" title="<?php echo $this->lang->line('edit_hint'); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo base_url('admin/subtypes/update_status/'.$subtype->id.'?is_active='.NOT_ACTIVE) ?>" title="Remove" class="btn btn-xs btn-danger btn-remove" ><i class='fa fa-trash'></i></a>
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
    <!--Confirm deleting -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <!-- confirm sectionn-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><?php echo $this->lang->line('delete_title');?></h4>
            </div>
            <div class="modal-body">
              <div id="deleting-confirm"></div>
            </div>
            <div class="modal-footer">
              <button type="button" id = 'deleted-confirm-btn' data-action-url = '<?php echo base_url('admin/subtypes/delete'); ?>' class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('confirm');?></button>
            </div>
          </div>
        </div>
    </div>
    <!-- end confirm section -->
</div>