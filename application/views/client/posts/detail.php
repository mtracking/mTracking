<div id="page-content">
    <?php if (!empty($post)): ?>
    <div class='container post'>
        <div class='row'>
            <div class='col-xs-12 col-sm-offset-1 col-sm-10 text-center'>
                <h1 class='post-title'><?php echo $post->title ?></h1>
                <hr class="star-primary">
                <?php if (!empty($post->full_name)): ?>
                    <div class='post-by'>
                        <i>Post by</i> <strong><?php echo $post->full_name ?></strong> <i>on</i>
                        <?php echo date('m-d-Y H:i:s', strtotime($post->created_at)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class='col-xs-12 col-sm-offset-1 col-sm-10 post-content'>
                <?php echo $post->content ?>
            </div>
        </div>
        <hr>
    </div>
    <?php endif; ?>
    <?php if (!empty($type)): ?>
        <div class='container'>
            <div class="row">
                <div class='text-center'>
                    <h1 class='type-info'><?php echo $this->lang->line('type_infomations') ?></h1>
                    <hr class="star-primary">
                </div>
                <div class="col-xs-12 col-sm-4" style="margin-top:23px">
                    <a href="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.$type->picture_url); ?>" class="gallery-link" title="Image Info">
                        <img class="img-thumbnail img-responsive" src="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.$type->image_file_name); ?>" alt="image">
                    </a>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <h3 class="sub-header">
                        <strong><?php echo $type->name; ?> </strong>
                    </h3>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('type_details') ?>
                                    :</strong>
                                    <?php echo $type->type_details; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('country') ?>
                                    :</strong>
                                    <?php echo $type->country; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('characteristics'); ?>
                                    :</strong>
                                    <?php echo $type->characteristics; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('storage_temp'); ?>
                                        :</strong>
                                    <?php echo $type->storage_temp; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('sourcing'); ?>
                                    :</strong>
                                    <?php echo $type->sourcing; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-angle-right"></i>
                                    <strong>
                                    <?php echo $this->lang->line('category'); ?>
                                        :</strong>
                                    <?php echo $type->category_name; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>