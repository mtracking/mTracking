<!-- Page content -->
<div id="page-content" style="min-height: 894px;">
    <div class="block">
        <div class="block-title">
            <h2><strong><?php echo $this->lang->line('list_category_header'); ?></strong></h2>
            <div class="block-options pull-right">
                <a class="btn btn-primary" href = "<?php echo base_url('admin/categories/add'); ?>"><?php echo $this->lang->line('form_add_title'); ?></a>
            </div>
        </div>
        <div class="messages"></div>
        <table class="table table-striped table-vcenter">
            <thead>
                <th class='col-sm-1 text-center'></th>
                <th class="col-sm-10 text-center"><?php echo $this->lang->line('txt_add_cate_name'); ?></i></th>
                <th class = "col-sm-1 text-center"><?php echo $this->lang->line('txt_action'); ?></th>
            </thead>
            <tbody class = 'row'>
            <?php if ($categories)
                {
                    foreach($categories as $key => $category)
                    {
                        ?>
                        <tr id = "<?php echo $category->id;?>">
                            <td class='text-center col-sm-1'><?php echo ++$key ?></td>
                            <td class = "text-center col-sm-10"><a href="<?php echo base_url('admin/types?search='.$category->id) ?>"><?php echo $category->name; ?></a></td>
                            <td class = "text-center col-sm-1">
                                <div class="btn-group btn-group-xs">
                                    <a href="<?php echo base_url('admin/categories/edit/'.$category->id);?>" data-toggle="modal" title="<?php echo $this->lang->line('edit_hint');?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                                    <a href="<?php echo base_url('admin/categories/update_status/'.$category->id.'?is_active='.NOT_ACTIVE) ?>" title="Remove" class="btn btn-xs btn-danger btn-remove" ><i class='fa fa-trash'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>
        <!-- END Horizontal Form Content -->
    </div>
</div>
<!-- END Page Content -->
