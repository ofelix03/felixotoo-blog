<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($page_title)? $page_title : 'Ofelix.tk'; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap-theme.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/font-awesome.css'); ?>">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/lg-devices.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/md-devices.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/sm-devices.css'); ?>">
	<link href='http://fonts.googleapis.com/css?family=Abril+Fatface' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jQuery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>
	<meta name="" conent>

	<?php echo  isset($resources)? $resources : ""; ?>
	<style type="text/css">
	.jumbotron{
		min-height: 300px; 
	}

	</style>
	<?php 
		$background_img = base_url('asset/img/my_wallpapers').'/';
		$background_img .= isset($wallpaper)? $wallpaper : 'winter.jpg';
	
	?>

	<style type="text/css">


	</style>


</head>
<body>
<div id="top" class="container">
	
</div>
