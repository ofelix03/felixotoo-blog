<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($page_title)? $page_title : 'Ofelix.tk | Home Page'; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap.css'); ?>"> 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/lg-devices.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/md-devices.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/md-devices-fix.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/index-folder/sm-devices.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('asset/js/jQuery.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/prism.css'); ?>"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Asap' rel='stylesheet' type='text/css'>	
<?php echo  isset($resources)? $resources : ""; ?>
<!-- <link href='http://fonts.googleapis.com/css?family=Nunito:300,400' rel='stylesheet' type='text/css'>
 --><!-- <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'> -->
<link href='http://fonts.googleapis.com/css?family=Lora:400,400italic' rel='stylesheet' type='text/css'>
 <body>
	<div id="top" class="container">
		<div class="nav" >
			<div class="logo">
			<span><a href="<?php echo site_url('home'); ?>"><img src="<?php echo base_url('asset/img/logo/a8e42f8fe987b7cc9bf2d43b74b2c74b2448d2e3.png'); ?>" style='height: 50px; width: 100px; background-color: transparent;'></a></span>
				
 				<span class="searchbox-sm"></span>
				<button class="menu-trigger">MENU <i class="fa fa-bars"></i></button>
				<p class="clear"></p>
			</div>
			<ul class="main-menu">
				<li  id="<?php echo  (isset($current) && $current == 'home')? 'current' : '';?>"><a href="<?php echo site_url('/home'); ?>" ><i class='fa fa-home '></i><i class="fa fa-caret-up"></i> Home</a></li>
				<li  id="<?php echo  (isset($current) && $current == 'articles')? 'current' : '';?>"><a href="<?php echo site_url('/articles'); ?>" ><i class='fa fa-book '></i><i class="fa fa-caret-up"></i> Articles</a></li>
				<li  id="<?php echo  (isset($current) && $current == 'about')? 'current' : '';?>" ><a href="<?php echo site_url('about'); ?>" ><i class='fa fa-user '></i><i class="fa fa-caret-up"></i> About</a></li>
				<li  style="display: none;" id="<?php echo  (isset($current) && $current == 'portfolio')? 'current' : '';?>"><a href="page_not_found.html"><i class='fa fa-folder '></i><i class="fa fa-caret-up"></i> Portfolio</a></li>
			</ul>
			<?php echo form_open('search/term/', array("class" => "searchbox", "method" => "get"))?>
			<input type="text" name="search" value="" style="border-radius: 3px; " placeholder=" Enter your search " /> 
			<input type="submit" value="Search" class="btn" />
			<span class='clear-icon'>&nbsp;<i class='fa fa-times '></i></span>
		</form>
	</div>
