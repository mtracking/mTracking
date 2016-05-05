
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <style type="text/css">
    .col {
        float:left;
        position: relative;
        min-height: 1px;
        padding: 15px 15px;
    }
    .col-1 {
        width:16%;
    }
    .col-2 {
        width:24%;
        border-right: 1px solid #dfdfdf;
        border-left: 1px solid #dfdfdf;
    }
    .col-2-last {
        border-left: 1px solid #dfdfdf;
        width:24%;
    }
    .col-3 {
        width:16%;
    }
    .row {
        width:100%;
        clear:both;
        overflow:hidden;
    }
    .thead .row {
        border:1px solid #dfdfdf;
    }
    .tbody .row {
        border:1px solid #dfdfdf;
        border-top: none;
    }
    </style>
</head>
<body>
    <div style='width: 700px'>
        <div class='thead'>
            <div class='row'>
                <div class='col col-1'>Serial No.</div>
                <div class='col col-2'>Qrcode 1</div>
                <div class='col col-3'>Qrcode 2</div>
                <div class='col col-2-last'>Qrcode 3</div>
            </div>
        </div>
        <div class='tbody'>
            <?php foreach ($products as $key => $product): ?>
            <div class='row' style=''>
                <div class='col col-1'><?php echo $product->serial_no ?></div>
                <div class='col col-2'>
                    <img src="
                    <?php echo base_url(LINK_TO_GET_QRCODE.$product->serial_no.FILENAME_QRCODE1) ?>" height=80 width=80>
                    <div><?php echo $key ?></div>
                </div>
                <div class='col col-3'>
                    <img src="<?php echo base_url(LINK_TO_GET_QRCODE.$product->serial_no.FILENAME_QRCODE2) ?>" height=50 width=50>
                    <div><?php echo $key ?></div>
                </div>
                <div class='col col-2-last'>
                    <img src="<?php echo base_url(LINK_TO_GET_QRCODE.$product->serial_no.FILENAME_QRCODE1) ?>" height=80 width=80>
                    <div><?php echo $key ?></div>
                </div>
            </div>
             <?php endforeach; ?>
        </div>
    </div>
<!--     <div id="editor"></div>
    <button id='btn-print'>Print</button> -->
</body>
</html>