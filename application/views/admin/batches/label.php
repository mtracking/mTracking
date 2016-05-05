
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js"></script>
    <style type="text/css">
        @import url('http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic');
        body {font-family: monospace;}
        #front-label {
            width:500px; border:1px solid #EEEEEE;
            margin-top: 50px;
            margin-left: 50px;
            background: #EEEEEE;
            font-size: 13px;
        }
        #back-label {
            width:500px; border:1px solid #EEEEEE;
            margin-top: 100px;
            margin-left: 50px;
            background: #EEEEEE;
            font-size: 11px;
        }
        img {
            margin: 5px;
        }
        #front-label img {
            margin-top: 50px;
            /*margin-left: 60px;*/
        }
        #front-label .company-name {
            margin-left: 30px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        #front-label .type-name {
            font-family: Impact, fantasy;
            color: #7c1907;
            /*margin-left: -25px;*/
            margin-top: 65px;
            font-size: 25px;
        }
       /* #front-label .type-name .producing-year {
          margin-left: 50px;
        }*/
        #front-label .producing-year {
            font-style: italic;
            font-size: 20px;
            color: #000;
        }
        #front-label .qrcode-1 {
            margin-top: 280px;
            width:100px;
            height:100px;
            background: #dfdfdf;
            margin-left: 5px;
        }
        #front-label .type-volume, #front-label .type-country {
            margin: 10px;
        }
        .all-info {
            margin: 0 0 5px 5px;
            font-size: 10px;
        }
        .border{
            margin: 20px 150px;
            border-top: 2px solid #7c1907;
        }
        .barcode {
            width:150px;
            height:100px;
            background: #dfdfdf;
            margin-left: 5px;
        }

    </style>
    <script type="text/javascript">
        $(document).ready(function(){
          var area_print = $('#area-print');
          var cache_width = area_print.width();
          var a4  =[ 595.28,  841.89];
          $('#btn-print').on('click',function(){
              createPDF();
          });
          function createPDF(){
              getCanvas().then(function(canvas){
                  var
                  img = canvas.toDataURL("image/png"),
                  doc = new jsPDF({
                  unit:'px',
                  format:'a4'
                  });
                  doc.addImage(img, 'JPEG', 20, 20);
                  var file_name = '<?php echo $batch->type_name.'-'.$batch->lot ?>';
                  doc.save(file_name + '.pdf');
                  area_print.width(cache_width);
              });

            // create canvas object
            function getCanvas(){
                area_print.width((a4[0]*1.33333) -80).css('max-width','none');
                return html2canvas(area_print,{
                  imageTimeout:2000,
                  removeContainer:true
                });
            }
          }
        });
    </script>
</head>
<body>
    <div id='area-print' class='container'>
        <div id='front-label' class='row'>
            <div class='row'>
                <div class='col-xs-3'>
                    <div class='qrcode-1'>
                        QRCode1
                    </div>
                </div>
                <div class='col-xs-6'>
                   <!--  <h2 class='company-name'>Michael's Store</h2> -->
                    <div class='col-xs-12 text-center'>
                        <img src="<?php echo convert_img_to_base64(base_url('assets/img/logo.jpg')) ?>" width=200 />
                        <h2 class='type-name'><?php echo $batch->type_name ?> <div class='producing-year'><?php echo $batch->producing_year ?></div></h2>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-xs-6'>
                    <div class='type-volume'><?php echo $batch->volume ?> ml</div>
                </div>
                <div class='col-xs-6 text-right'>
                    <div class='type-country'>Product of <?php echo $batch->country ?></div>
                </div>
            </div>
        </div>
        <div id='back-label'>
            <div class='row'>
                <div class='col-xs-12 text-center'>
                  <img src="<?php echo convert_img_to_base64(base_url(LINK_TO_GET_IMAGE. LOGO_IMAGE)) ?>" width=100 />
                    <h3><span class='company-name'>Michael's Store</span> <span class='producing-year'><?php echo $batch->producing_year ?></span> <span class='type-name'><?php echo $batch->type_name ?></span></h3>
                    <p class='type-details'>
                      <?php echo nl2br($batch->type_details)  ?>
                    </p>
                    <hr class='border'>
                </div>
            </div>
            <div class='row all-info'>
                <div class='col-xs-7'>
                    <div class='company-address'>
                        <strong>Company address:</strong>
                        <span>127 van ams way</span>
                    </div>
                    <div class='country'>
                        <strong>Country:</strong>
                        <span><?php echo $batch->country ?></span>
                    </div>
                    <div class='volume'>
                        <strong>Volume:</strong>
                        <span><?php echo $batch->volume ?> ml</span>
                    </div>
                    <div class='batch'>
                        <strong>Batch:</strong>
                        <span><?php echo $batch->lot ?></span>
                    </div>
                    <div class='producing-date'>
                        <strong>Production date:</strong>
                        <span><?php echo date('m-d-Y', strtotime($batch->producing_date)) ?></span>
                    </div>
                    <div class='expiration-date'>
                        <strong>Expiration date:</strong>
                        <span><?php echo (strtotime($batch->expiry_date) > 0) ? date('m-d-Y', strtotime($batch->producing_date)) : 'None' ?></span>
                    </div>
                    <div class='website'>
                        <strong>Website:</strong>
                        <span>www.rudholmhaak.se</span>
                    </div>
                </div>
                <div class="col-xs-5 text-right">
                    <div class="barcode">Barcode</div>
                </div>
            </div>
        </div>
    </div>
    <div class='container' style='margin-top:50px;margin-bottom:50px'><div class='row text-left'><button id='btn-print' class='btn btn-info'>Print</button></div></div>
</body>
</html>