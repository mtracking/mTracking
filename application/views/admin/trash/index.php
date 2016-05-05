<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
           <div class="block-options pull-right">
                <?php $attrs = array('id' => 'form-search-item', 'method' => 'get', 'class' => '') ?>
                <?php echo form_open('admin/trash', $attrs); ?>
                    <div class="form-group">
                        <?php $attrs = array("id" => 'top-search', 'class' =>'form-control', 'placeholder' => 'Search...') ?>
                        <?php echo form_hidden('sort_by', set_value('sort_by', $kind_of_items), $attrs); ?>
                        <?php echo form_input('search_item', set_value('search_item', $this->input->get('search_item')), $attrs); ?>
                    </div>
                <?php echo form_close() ?>
            </div>
            <h1>
                <?php echo $this->lang->line('title') ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
                    <h2><strong><?php echo $this->lang->line('items') ?></strong></h2>
                </div>
                <div class='block-content'>
                    <div class='row'>
                        <div class='col-sm-4 col-lg-3'>
                            <!-- Menu Content -->
                            <ul class="nav nav-pills nav-stacked" style="margin-bottom: 10px;">
                                <li class="<?php echo ($kind_of_items == CATEGORIES) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. CATEGORIES) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('categories') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($kind_of_items == TYPES) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. TYPES) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('types') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($kind_of_items == SUBTYPES) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. SUBTYPES) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('subtypes') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($kind_of_items == BATCHES) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. BATCHES) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('batches') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($kind_of_items == PAGES) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. PAGES) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('pages') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($kind_of_items == POSTS) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/trash?sort_by='. POSTS) ?>" class='sort-by'>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('posts') ?></strong>
                                    </a>
                                </li>
                            </ul>
                            <!-- END Menu Content -->
                        </div>
                        <div class='col-sm-8 col-lg-9'>
                            <?php if ($items): ?>
                                <div class='messages'></div>
                                <div class='table-responsive'>
                                    <table class="table table-borderless table-striped">
                                        <thead>
                                            <tr class='row'>
                                                <th class='col-sm-1'><?php echo $this->lang->line('no') ?></th>
                                                <th class='col-sm-8'><?php echo $this->lang->line('name') ?></th>
                                                <?php switch ($kind_of_items):
                                                    case BATCHES: ?>
                                                        <th class='col-sm-3'><?php echo $this->lang->line('subtype') ?></th>
                                                    <?php break; ?>
                                                    <?php case POSTS: ?>
                                                        <th class='col-sm-3'><?php echo $this->lang->line('type') ?></th>
                                                    <?php break; ?>
                                                <?php endswitch; ?>

                                                <th class='col-sm-1 text-center'><?php echo $this->lang->line('action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $offset = $this->uri->segment(3, 0) + 1; ?>
                                            <?php foreach ($items as $key => $item): ?>
                                                <tr class='row' id='item-<?php echo $item->id ?>'>
                                                    <td class='col-sm-1'><?php echo $offset++ ?></td>
                                                    <td class='col-sm-8'>
                                                        <?php
                                                            switch ($kind_of_items)
                                                            {
                                                                case CATEGORIES:
                                                                    echo $item->name;
                                                                    $the_base_url = base_url('admin/categories/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                    break;
                                                                case TYPES:
                                                                    echo $item->name;
                                                                    $the_base_url = base_url('admin/types/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                    break;
                                                                case SUBTYPES:
                                                                    echo $item->type_name.' - '.$item->producing_year;
                                                                    $the_base_url = base_url('admin/subtypes/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                    break;
                                                                case BATCHES:
                                                                    echo $item->lot;
                                                                    $the_base_url = base_url('admin/batches/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                    break;
                                                                case PAGES:
                                                                    echo $item->title;
                                                                    $the_base_url = base_url('admin/pages/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                    break;
                                                                case POSTS:
                                                                    echo $item->title;
                                                                    $the_base_url = base_url('admin/posts/update_status/'.$item->id.'?is_active='.ACTIVE);
                                                                default:
                                                                    # code...
                                                                    break;
                                                            }
                                                         ?>
                                                    </td>
                                                    <?php if ($kind_of_items == BATCHES): ?>
                                                    <td class='col-sm-3'><?php echo $item->type_name.' - '.$item->producing_year; ?></td>
                                                    <?php elseif($kind_of_items == POSTS): ?>
                                                    <td class='col-sm-3'><?php echo $item->type_name ?></td>
                                                    <?php endif ?>
                                                    <td class='col-sm-1 text-center'>
                                                        <a href="<?php echo $the_base_url ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('restore') ?>" class="btn btn-block btn-xs btn-success btn-restore" ><?php echo $this->lang->line('restore') ?> <i class='fa fa-undo'></i></a>
                                                        <?php switch ($kind_of_items):
                                                                case BATCHES: ?>
                                                                    <a href="#myModal"
                                                                        data-action-url = '<?php echo base_url('admin/batches/delete'); ?>'
                                                                        data-toggle="modal"
                                                                        data-target='#myModal'
                                                                        data-item="<?php echo $item->lot; ?>"
                                                                        data-item-id= "<?php echo $item->id ?>"
                                                                        data-toggle="tooltip"
                                                                        title="<?php echo $this->lang->line('delete') ?>"
                                                                        class="btn btn-block btn-xs btn-danger item-delete"
                                                                        data-inform-delete="<?php echo $this->lang->line('inform_delete_types'); ?>">
                                                                            <?php echo $this->lang->line('delete') ?> <i class='fa fa-times'></i>
                                                                    </a>
                                                                <?php break; ?>
                                                                <?php case PAGES: ?>
                                                                    <a href="#myModal"
                                                                        data-action-url = '<?php echo base_url('admin/pages/delete'); ?>'
                                                                        data-toggle="modal"
                                                                        data-target='#myModal'
                                                                        data-item="<?php echo $item->title; ?>"
                                                                        data-item-id= "<?php echo $item->id ?>"
                                                                        data-toggle="tooltip"
                                                                        title="<?php echo $this->lang->line('delete') ?>"
                                                                        class="btn btn-block btn-xs btn-danger item-delete"
                                                                        data-inform-delete="<?php echo $this->lang->line('inform_delete_types'); ?>">
                                                                        <?php echo $this->lang->line('delete') ?> <i class='fa fa-times'></i>
                                                                    </a>
                                                                <?php break; ?>
                                                                <?php case POSTS: ?>
                                                                    <a href="#myModal"
                                                                        data-action-url = '<?php echo base_url('admin/posts/delete'); ?>'
                                                                        data-toggle="modal"
                                                                        data-target='#myModal'
                                                                        data-item="<?php echo $item->title; ?>"
                                                                        data-item-id= "<?php echo $item->id ?>"
                                                                        data-toggle="tooltip"
                                                                        title="<?php echo $this->lang->line('delete') ?>"
                                                                        class="btn btn-block btn-xs btn-danger item-delete"
                                                                        data-inform-delete="<?php echo $this->lang->line('inform_delete_types'); ?>">
                                                                        <?php echo $this->lang->line('delete') ?> <i class='fa fa-times'></i>
                                                                    </a>
                                                                <?php break; ?>
                                                        <?php endswitch; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php echo $page_links; ?>
                                </div>
                            <?php else: ?>
                                <p class='alert alert-warning'><?php echo $this->lang->line('item_not_found') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Basic Form Elements Block -->
        </div>
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
                <?php echo form_hidden('item-id', ''); ?>
              <div id="deleting-confirm">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id = 'deleted-confirm-btn' data-action-url = "" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('confirm');?></button>
            </div>
          </div>
        </div>
    </div>
    <!-- end confirm section -->
    <script type="text/javascript"> var kind_of_items = <?php echo $kind_of_items ?></script>
</div>
