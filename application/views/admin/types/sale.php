<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
                <?php $attrs = array('id' => 'form-search-type', 'method' => 'get', 'class' => 'navbar-form-custom') ?>
                <?php echo form_open('admin/sale', $attrs); ?>
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
            </div>
        </div>
        <div class="row">
        <div class="col-sm-12">
            <div class="row all-types">
                <?php foreach ($types as $key => $type): ?>
                    <div class="col-xs-12 col-sm-4 col-md-3 type-item">
                        <div class="thumbnail">
                            <a href="<?php echo base_url('client/posts/detail/'.$type->id.'?type=true') ?>">
                                <img src="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.(($type->image_file_name) ? $type->image_file_name : DEFAULT_IMAGE)) ?>" alt="">
                            </a>
                            <table class="table table-borderless table-striped">
                                <tbody>
                                    <tr>
                                        <td style='width: 30%'><strong><?php echo $this->lang->line('name') ?></strong></td>
                                        <td>
                                            <a href="javascript:void(0)" class='type-name' data-toggle='tooltip' title="<?php echo $type->name ?>"><?php echo character_limiter($type->name, 10) ?></a>
                                            <?php $attrs = array('class' => 'form-upload-picture', 'style' => 'display:inline') ?>
                                            <?php echo form_open_multipart('admin/sale/upload_pictures/'. $type->id, $attrs) ?>
                                                <span class="btn-file"> <i class="fa fa-file-image-o"></i>
                                                    <input type="file" id='file' name="file" size="20" />
                                                </span>
                                            <?php echo form_close(); ?>
                                            <span class='messages'></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding-top:17px'><strong><?php echo $this->lang->line('price') ?> US<i class="fa fa-dollar"></i></strong></td>
                                        <td>
                                            <div class="col-xs-12" style='padding-left:0px'>
                                                <?php echo form_open('admin/sale/update_type_price/'.$type->id, "id='form-update-price'") ?>
                                                <input type="number" name='price' class='form-control' data-type-id='<?php echo $type->id ?>' placeholder="<?php echo $this->lang->line('hint_price') ?>" value="<?php echo $type->price ?>" min='0.00' step="0.1">
                                                <?php echo form_close(); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding-top:17px'><strong><?php echo $this->lang->line('status') ?></strong></td>
                                        <td>
                                            <div class="col-xs-12" style='padding-left:0px'>
                                                <?php
                                                    $data = array('class' => 'form-control', 'data-type-id' => $type->id);
                                                    $options = array(
                                                        ACTIVE => $this->lang->line('sale'),
                                                        NOT_ACTIVE => $this->lang->line('not_sale'));
                                                    echo form_dropdown('select-status-type', $options, set_value('select-status-type', $type->is_available), $data);
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center">
                <?php echo $page_links; ?>
            </div>
        </div>
    </div>
    </div>
</div>