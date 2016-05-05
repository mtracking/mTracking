<div id="page-content" class="container" style='padding-top:10px'>
    <div class="row">
        <div class='col-sm-offset-1 col-sm-10'>
            <div class="table-responsive">
                <div class="messages"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1"><?php echo $this->lang->line('number') ?></th>
                                <th class="text-center col-sm-2"><?php echo $this->lang->line('serial_no') ?></th>
                                <th class="text-center col-sm-3"><?php echo $this->lang->line('type_name') ?></th>
                                <th class="text-center col-sm-2"><?php echo $this->lang->line('producing_date') ?></th>
                                <th class="text-center col-sm-2"><?php echo $this->lang->line('expiry_date') ?></th>
                                <th class="text-center col-sm-2"><?php echo $this->lang->line('time_opened') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $offset = $this->uri->segment(3, 0) + 1; ?>
                             <?php foreach($products as $product ):
                            ?>
                            <tr>
                                <td class="text-center col-sm-1"><?php echo $offset++; ?></td>
                                <td class="text-center col-sm-2"><a class='text-info' href="<?php echo base_url('client/products/view/'.$product->serial_no) ?>"><?php echo $product->serial_no; ?></a></td>
                                <td class="text-center col-sm-3"><?php echo $product->type_name; ?></td>
                                <td class="text-center col-sm-2"><?php echo date("m-d-Y", strtotime($product->producing_date)); ?></td>
                                <td class="text-center col-sm-2"><?php echo (strtotime($product->expiry_date) > 0 ? strtotime($product->expiry_date) : 'None' ); ?></td>
                                <td class="text-center col-sm-2"><?php echo date("m-d-Y", strtotime(get_last_location(json_decode($product->location))->time)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo $page_links; ?>
            </div>
        </div>
    </div>
</div>
