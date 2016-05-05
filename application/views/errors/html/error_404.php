<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<title>404 Page Not Found</title>
</head>
<body>
	<div class="container">
		    <div class='row'>
		    	 <div class='col-xs-12 text-center' style="margin-top:50px; margin-bottom:50px;">
		            <h1><?php echo $heading; ?></h1>
					<?php echo $message; ?>
		        </div>
		        <div class='col-xs-12 text-center'>
		            <div>
		                <img class='img-thumbnail' src="<?php echo base_url('assets/img/404.png');?>" />
		            </div>
		        </div>
		    </div>
	</div>
</body>
</html>