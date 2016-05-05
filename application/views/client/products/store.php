<div id="page-content" class="container-fluid store">
            <div class="row all-types">
                <?php foreach ($types as $key => $type): ?>
                <div class="col-sm-4 col-lg-4 col-sm-4 type-item">
                    <a href="<?php echo base_url('client/posts/detail/'.$type->id.'?type=true') ?>">
                        <img src="<?php echo base_url(LINK_TO_GET_TYPES_IMAGE.(($type->image_file_name) ? $type->image_file_name : DEFAULT_IMAGE)) ?>" alt="">
                        <div class="caption">
                            <div class='h4 type-name' data-toggle='tooltip' title="<?php echo $type->name ?>">
                                <span class='type-name' data-toggle='tooltip' title="<?php echo $type->name ?>"><?php echo character_limiter($type->name, 40) ?></span>
                            </div>
                        </div>
                        <div class='details'>
                            <div class='h4'><?php echo $this->lang->line('more_details') ?></div>
                        </div>
                    </a>
                    <div class='cart' style="<?php echo (is_distributor()) ? '' : 'display:none;' ?>">
                        <button class='btn btn-sm btn-raised btn-info btn-add-cart' data-type-id='<?php echo $type->id ?>' data-add-cart-url='<?php echo base_url('client/shopping_cart/add_cart') ?>'><i class='fa fa-cart-plus'></i></button>
                        <button class='btn btn-sm btn-raised btn-success btn-buy' data-buy-now-url='<?php echo base_url('client/shopping_cart/buy_now') ?>'><?php echo strtoupper($this->lang->line('buy')) ?></button>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (!$types): ?>
                    <div class="col-sm-12">
                        <p class='alert alert-warning'><?php echo $this->lang->line('not_found') ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row text-center">
                <?php echo $page_links; ?>
            </div>
    <a style="<?php echo (is_distributor()) ? '' : 'display:none;' ?>" href="<?php echo base_url('client/shopping_cart') ?>" id="shopping-cart"><i class="fa fa-shopping-cart"></i> <small class='number-order'><?php echo $number_of_shopping_cart ?></small></a>
</div>
