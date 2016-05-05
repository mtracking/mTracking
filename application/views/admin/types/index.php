<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
                <?php $attrs = array('id' => 'form-search-type', 'method' => 'get', 'class' => '') ?>
                <?php echo form_open('admin/types', $attrs); ?>
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
                <h2><?php echo $this->lang->line('list_of_types') ?></h2>
                <div class="block-options pull-right">
                    <a href="<?php echo base_url('admin/types/add'); ?>" class="btn btn-sm btn-primary"><?php echo $this->lang->line('heading_create') ?></a>
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
                        <!-- <th class="text-center col-sm-1"><input id = 'general-checkbox' type="checkbox"></th> -->
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('id') ?></th>
                        <th class="text-center col-sm-2"><?php echo $this->lang->line('name') ?></th>
                        <th class="text-center col-sm-6"><?php echo $this->lang->line('type_details') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('category') ?></th>
                        <th class="text-center col-sm-1"><?php echo $this->lang->line('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $offset = $this->uri->segment(3, 0) +1; ?>
                     <?php foreach($types as $type ):
                    ?>
                    <tr id = "<?php echo $type->id;?>">
                        <td class="text-center col-sm-1"><?php echo $offset++; ?></td>
                        <td class="text-center col-sm-2"><a href="<?php echo base_url('admin/subtypes'.'?search='.$type->id) ?>" ><?php echo $type->name; ?></a></td>
                        <td class="text-center col-sm-6"><?php echo $type->type_details; ?></td>
                        <td class="text-center col-sm-1"><?php echo $type->category_name; ?></td>
                        <td class="text-center col-sm-1">
                            <div class="btn-group btn-group-xs">
                                <a href="<?php echo base_url('admin/types/edit/'.$type->id); ?>" data-toggle="modal" title="<?php echo $this->lang->line('edit_hint'); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo base_url('admin/types/update_status/'.$type->id.'?is_active='.NOT_ACTIVE) ?>" title="Remove" class="btn btn-xs btn-danger btn-remove" ><i class='fa fa-trash'></i></a>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
               <!--  <tfoot>
                    <tr>
                        <td colspan="10">
                            <div class="btn-group btn-group-sm pull-right">
                                <a href="#myModal" id = 'delete-selected-btn' class="btn btn-danger" data-toggle="modal" data-target='#myModal' title="<?php echo $this->lang->line('delete_group_hint'); ?>" data-inform-delete="<?php echo $this->lang->line('inform_delete_types'); ?>" data-inform-error-delete="<?php echo $this->lang->line('inform_error_delete_types'); ?>"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                    </tr>
                </tfoot> -->
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
              <button type="button" id = 'deleted-confirm-btn' data-action-url = '<?php echo base_url('admin/types/delete'); ?>' class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('confirm');?></button>
            </div>
          </div>
        </div>
    </div>
    <!-- end confirm section -->
    <script>
        var listIdChecked = [];
        var listNameChecked = [];
    </script>
</div>