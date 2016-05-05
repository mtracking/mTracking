<div id="page-content">
    <div class='container' style='padding-top:10px'>
        <div class='row'>
            <div class='col-sm-4 col-lg-3'>
                <!-- Menu Content -->
                <ul class="nav nav-pills nav-stacked" style="margin-bottom: 10px;">
                    <li class="<?php echo ($status_order == ORDER) ? 'active' : '' ?>">
                        <a href="<?php echo base_url('client/orders?sort_by='. ORDER) ?>" class='sort-by'>
                            <span class="badge pull-right number-orders"><?php echo $total_sort_by_order ?></span>
                            <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('new') ?></strong>
                        </a>
                    </li>
                    <li class="<?php echo ($status_order == PROCESSING) ? 'active' : '' ?>">
                        <a href="<?php echo base_url('client/orders?sort_by='. PROCESSING) ?>" class='sort-by'>
                            <span class="badge pull-right number-orders"><?php echo $total_sort_by_processing ?></span>
                            <i class="fa fa-angle-right fa-fw"></i> <strong><?php echo $this->lang->line('processing') ?></strong>
                        </a>
                    </li>
                    <li class="<?php echo ($status_order == DELIVERED) ? 'active' : '' ?>">
                        <a href="<?php echo base_url('client/orders?sort_by='. DELIVERED) ?>" class='sort-by'>
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
                            <li id='order-item-<?php echo $order->id ?>' class="order-item" style=''>
                                <div class="media-body">
                                    <span class="text-muted pull-right"><small><em><?php echo date('m-d-Y H:i:s', strtotime($order->created_at)) ?></em></small></span>
                                    <a href="page_ready_user_profile.html"><strong><?php echo $order->email ?></strong></a>
                                    <p>
                                        <table class="table table-striped table-hover">
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
                                                    <td style=''><strong><?php echo $this->lang->line('status') ?></strong></td>
                                                    <td>
                                                         <?php
                                                            if ($order->status_order == ORDER)
                                                            {
                                                                echo $this->lang->line('new');
                                                            }
                                                            elseif($order->status_order == PROCESSING)
                                                            {
                                                                echo $this->lang->line('processing');
                                                            }
                                                            elseif($order->status_order == DELIVERED)
                                                            {
                                                                echo $this->lang->line('delivered');
                                                            }
                                                         ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php if($status_order == ORDER): ?>
                                            <div class='pull-right' style='margin:5px'>
                                                <button class="btn btn-raised btn-sm btn-danger btn-delete-order" data-order-id="<?php echo $order->id ?>"><?php echo $this->lang->line('remove') ?></button>
                                            </div>
                                        <?php endif; ?>
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
    <script type="text/javascript">var status_order = <?php echo $status_order ?></script>
</div>