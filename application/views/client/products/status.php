<!-- Main Content -->
<div id="page-content" class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1 class=""><?php echo $this->lang->line('welcome') ?></h1>
            <p class=" messages <?php echo ($result['status'] === TRUE) ? 'text-success' : 'text-warning' ?>"><?php echo $result['messages']." ".((!empty($result['time_opened'])) ? date('m-d-Y H:i:s', strtotime($result['time_opened'])) : ''); ?></p>
            <button class='btn btn-raised btn-success btn-login' style='<?php if ($result['need_to_login'] === FALSE) echo "display:none" ?>' data-toggle="modal" data-target = '#LoginModal'><?php echo $this->lang->line('login') ?></button>
            <a href='<?php echo base_url('client/store') ?>' class='btn btn-raised btn-success btn-shop-now' style='<?php if ($result['need_to_login'] === TRUE) echo "display:none" ?>'><?php echo $this->lang->line('shop_now') ?></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    var serial_no = <?php echo json_encode($product->serial_no); ?>;
    var p = {};
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            p = {
                lat : position.coords.latitude,
                lng : position.coords.longitude
            }
            alert(position.coords.latitude);
        },
        function(error) {
            alert(error.message);
        }, {
            enableHighAccuracy: false,
            timeout: 10000,
            maximumAge: 10000
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function showPosition(position) {
        
    }
    
</script>