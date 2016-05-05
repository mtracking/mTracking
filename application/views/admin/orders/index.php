<div id="page-content" style="min-height: 894px;">
    <div class="content-header">
        <div class="header-section">
            <div class="block-options pull-right">
                <?php $attrs = array('id' => 'form-search-order', 'method' => 'get', 'class' => '') ?>
                <?php echo form_open('admin/orders', $attrs); ?>
                    <div class="form-group">
                        <?php $attrs = array("id" => 'top-search', 'class' =>'form-control', 'placeholder' => 'Search email...') ?>
                        <?php echo form_input('search_email', set_value('search_email', $this->input->get('search_email')), $attrs); ?>
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
                    <h2><strong><?php echo $this->lang->line('orders') ?></strong></h2>
                </div>
                <div class='block-content'>
                    <div class='row'>
                        <div class='col-sm-4 col-lg-3'>
                            <!-- Menu Content -->
                            <ul class="nav nav-pills nav-stacked" style="margin-bottom: 10px;">
                                <li class="<?php echo ($status_order == ORDER) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/orders?sort_by='. ORDER) ?>" class='sort-by'>
                                        <span class="badge pull-right number-orders"><?php echo $total_sort_by_order ?></span>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('new') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($status_order == PROCESSING) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/orders?sort_by='. PROCESSING) ?>" class='sort-by'>
                                        <span class="badge pull-right number-orders"><?php echo $total_sort_by_processing ?></span>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('processing') ?></strong>
                                    </a>
                                </li>
                                <li class="<?php echo ($status_order == DELIVERED) ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/orders?sort_by='. DELIVERED) ?>" class='sort-by'>
                                        <span class="badge pull-right number-delivered"><?php echo $total_sort_by_delivered ?></span>
                                        <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('delivered') ?></strong>
                                    </a>
                                </li>
                            </ul>
                            <!-- END Menu Content -->
                        </div>
                        <div class='col-sm-8 col-lg-9'>
                            <?php if ($orders): ?>
                                <ul class="media-list">
                                        <?php foreach ($orders as $key => $order): ?>
                                        <li id='order-item-<?php echo $order->id ?>' class="media block" style=''>
                                            <div class="media-body">
                                                <span class="text-muted pull-right"><small><em><?php echo date('m-d-Y H:i:s', strtotime($order->created_at)) ?></em></small></span>
                                                <a href="page_ready_user_profile.html"><strong><?php echo $order->email ?></strong></a>
                                                <p>
                                                    <table class="table table-borderless table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 20%;"><strong><?php echo $this->lang->line('name') ?></strong></td>
                                                                <td><?php echo $order->name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 20%;"><strong><?php echo $this->lang->line('total_money') ?></strong></td>
                                                                <td><?php echo $order->total_money ?> US<i class='fa fa-dollar'></i></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 20%;"><strong><?php echo $this->lang->line('phone') ?></strong></td>
                                                                <td><?php echo $order->phone_number ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong><?php echo $this->lang->line('address') ?></strong></td>
                                                                <td><a href="https://www.google.com/maps/place/<?php echo $order->address ?>,11z" target="_blank"><?php echo $order->address ?></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 20%;"><strong><?php echo $this->lang->line('postal_code') ?></strong></td>
                                                                <td><?php echo $order->postal_code ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong><?php echo $this->lang->line('content') ?></strong></td>
                                                                <td>
                                                                    <span class='order-content' data-content="<?php echo (nl2br($order->content)); ?>"><?php echo character_limiter($order->content, 40) ?></span>
                                                                    <?php if (strlen($order->content) > 40): ?>
                                                                        <a href="javascript:void(0)" class='read-more'><?php echo $this->lang->line('read_more') ?></a>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top:17px'><strong><?php echo $this->lang->line('status') ?></strong></td>
                                                                <td>
                                                                    <div class="col-sm-4" style='padding-left:0px'>
                                                                        <?php
                                                                            $data = array('class' => 'form-control', 'data-order-id' => $order->id);
                                                                            $options = array(
                                                                                ORDER => $this->lang->line('new'),
                                                                                PROCESSING => $this->lang->line('processing'),
                                                                                DELIVERED => $this->lang->line('delivered'));
                                                                            echo form_dropdown('select-status-order', $options, set_value('select-status-order', $status_order), $data);
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class='pull-right' style='margin:5px'>
                                                        <button class="btn btn-xs btn-danger btn-delete-order" data-order-id="<?php echo $order->id ?>"><?php echo $this->lang->line('remove') ?></button>
                                                    </div>
                                                </p>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                </ul>
                                <?php echo $page_links; ?>
                            <?php else: ?>
                                <p class='alert alert-warning'>Don't have the order</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Basic Form Elements Block -->
        </div>
    </div>
    <script type="text/javascript">var status_order = <?php echo $status_order ?></script>
</div>