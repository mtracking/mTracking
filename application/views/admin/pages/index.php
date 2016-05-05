<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
            <?php $attrs = array('id' => 'form-search-pages', 'method' => 'get', 'class' => '') ?>
            <?php echo form_open('admin/pages', $attrs); ?>
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
                <h2><?php echo $this->lang->line('list_of_pages') ?></h2>
                <div class="block-options pull-right">
                    <a href="<?php echo base_url('admin/pages/add'); ?>" type="submit" class="btn btn-sm btn-primary"><?php echo $this->lang->line('heading_create') ?></a>
                </div>
            </div>
        </div>
        <!-- END Responsive Full Title -->
        <!-- Responsive Full Content -->
        <div class="table-responsive">
            <div class="messages"></div>
            <table class="table table-vcenter table-striped">
                <thead>
                    <tr class='row'>
                        <th class="text-center col-xs-1">
                            <div>
                                <?php echo form_checkbox('select-all', 'accept', FALSE, ""); ?>
                            </div>
                        </th>
                        <th class="text-center col-xs-1"><?php echo $this->lang->line('id') ?></th>
                        <th class="text-center col-xs-4"><?php echo $this->lang->line('title') ?></th>
                        <th class="text-center col-xs-2"><?php echo $this->lang->line('created_at') ?></th>
                        <th class="text-center col-xs-2"><?php echo $this->lang->line('page_view') ?></th>
                        <th class="text-center col-xs-2"><?php echo $this->lang->line('author') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $offset = $this->uri->segment(3, 0) + 1; ?>
                    <?php foreach($pages as $page ):
                    ?>
                    <tr id="page-<?php echo $page->id ?>" data-page-id=<?php echo $page->id ?> class='page-row row'>
                        <td class="text-center col-xs-1">
                            <div>
                                <?php $data = array(
                                    'name' => 'select-pages[]',
                                    'value' => 'accept',
                                    'checked' => FALSE,
                                    'data-page-id' => $page->id)
                                ?>
                                <?php echo form_checkbox($data); ?>
                            </div>
                        </td>
                        <td class="text-center col-xs-1"><?php echo $offset++; ?></td>
                        <td class="text-center col-xs-4" style="padding-top:30px">
                            <?php echo $page->title; ?> <span class='check-draft <?php echo ($page->is_available == ACTIVE) ? '' : 'is-draft' ?>'> — <?php echo $this->lang->line('draft') ?></span>
                            <div class='action'>
                                <a href="<?php echo base_url('client/pages/detail/'.$page->id) ?>" data-toggle="tooltip" title="View" class="label label-success" >View</a>
                                <a href="<?php echo base_url('admin/pages/edit/'.$page->id) ?>" data-toggle="tooltip" title="Edit" class="label label-default" >Edit</a>
                                <a href="<?php echo base_url('admin/pages/update_status/'.$page->id.'?is_active='.NOT_ACTIVE) ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('remove') ?>" class="label label-danger btn-remove" ><?php echo $this->lang->line('remove') ?></a>
                                    <?php
                                        $attrs = array('data-update-status-url' => base_url('admin/pages/update_status/'.$page->id));
                                        $options = array(
                                            PUBLISHED => $this->lang->line('published'),
                                            DRAFT => $this->lang->line('draft'));
                                        echo form_dropdown('is_available', $options, set_value('is_available', $page->is_available), $attrs);
                                    ?>
                            </div>
                        </td>
                        <td class="text-center col-xs-2"><?php echo date('m-d-Y H:i:s', strtotime($page->created_at)); ?></td>
                        <td class="text-center col-xs-2"><?php echo $page->view; ?></td>
                        <td class="text-center col-xs-2"><?php echo $page->full_name; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php if (!empty($pages)): ?>
                    <tfoot>
                        <tr>
                            <td colspan=9>
                                <div class='form-group'>
                                    <div class="col-xs-6 col-sm-offset-8 col-sm-3">
                                    <?php
                                        $attrs = array('class' => 'form-control');
                                        $options = array(
                                            PUBLISHED => $this->lang->line('published'),
                                            DRAFT => $this->lang->line('draft'),
                                            REMOVE => $this->lang->line('remove'));
                                        echo form_dropdown('update_status', $options, set_value('update_status', ''), $attrs);
                                    ?>
                                    </div>
                                    <div class='col-xs-6 col-sm-1'>
                                        <button class='btn btn-sm btn-primary btn-apply' data-update-status-url = <?php echo base_url('admin/pages/update_status_mutilple') ?>><?php echo $this->lang->line('apply') ?></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
            <?php echo $page_links; ?>
        </div>
        <!-- END Responsive Full Content -->
    </div>
</div>