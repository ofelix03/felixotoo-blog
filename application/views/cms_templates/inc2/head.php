<html>
<head>
	<title></title>
	<script type="text/javascript" src="<?php echo base_url('asset/js/jQuery.js'); ?>"></script>
	<!--<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/layout.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/main.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/form.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/dialogBox.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/prism.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/jquery.datetimepicker.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('asset/js/cms/jquery.datetimepicker.js');?>"></script>
   
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/vendor/colpick.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('asset/js/cms/plugins/colpick.js');?>"></script>

	<!-- Place inside the <head> of your HTML -->
	<script type="text/javascript" src="<?php echo base_url('asset/js/tinymce/tinymce.min.js');?>"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			 toolbar: "undo redo | styleselect | bold italic | link image | hr | jbimages | paste | searchreplace | emoticons | forecolor backcolor | selectall | newdocument | fontselect | fontsizeselect | numlist | bullist  ",
			 plugins : "hr, link, image, jbimages, paste, charmap, searchreplace , visualblocks ,code, fullscreen, media, table, emoticons, textcolor",
			 tools : 'inserttable',


			
			 relative_urls: false,


			// plugins: [
			// "advlist autolink lists link image charmap print preview anchor",
			// "searchreplace visualblocks code fullscreen",
			// "insertdatetime media table contextmenu paste",
			// "code", "emoticons", "colorpicker", "jbimages"
			// ],
			// toolbar: "insertfile undo redo | styleselect | paste   | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | textcolor | emoticons | jbimages",
			// relative_urls: false,
			// browser_spellcheck : true,
			// file_browser_callback: function(field_name, url, type, win) {
			// 	win.document.getElementById(field_name).value = 'my browser value';
			// }
			

		});
	</script>

	
	<?php
	if(isset($resources))
		echo $resources;

	?>

	<style type="text/css">
		.searchbox input{
			height: 28px;
			border: 1px solid #ccc;
			padding: 0px 5px;

		}


		.searchbox select{
			height: 28px;
			border: 1px solid #ccc;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="container-head">
			<div class="logo">
				<h3><a href="<?php echo site_url('cms'); ?>">CMS Dashboard</a></h3>
			</div>

			<div class="notification">Notifiction : <span></span></div>

			<div class="menu">
				<ul>
					<li data-menu='yes'><a href=""><i class =' fa fa-cog'></i>&nbsp; Setting</a>
						<ul data-active='inactive' >
							<li ><a data-url="<?php echo site_url('cms/author_edit'). '/'. $_SESSION['user_id']; ?>"` href="" data-action='edit-profile'>Edit Profile</a></li>
							<li><a data-url="<?php echo site_url('cms/delete_profile'); ?>" href=""  data-action='delete-profile'>Delete Profile</a></li>
							<li ><a  data-url="<?php echo site_url('cms/logout'); ?>" href="" data-action='logout'>Logout</a></li>
						</ul> 

					</li>
					<li><a href=""><i class='fa fa-user'></i>&nbsp; <?php echo ucfirst($_SESSION['username']); ?></a></li>
				</ul>
				
			</div>
			<p class="clear"></p>
		</div><!-- container-head ends here -->
		<div class="topics">
			<ul>
				<li><a class="<?php echo (isset($current) && $current == 'cms')? 'current' : '';?>" href="<?php echo site_url('cms'); ?>">Articles</i></a></li>
				<li><a class="<?php echo (isset($current)  && $current == 'authors')? 'current' : '';?>" href="<?php echo site_url('cms/authors'); ?>">Authors</a></li>
<!-- 				<li><a href="<?php echo (isset($current) && $current  == 'about')? 'current' : '';?>">About</a></li>
 -->
			</ul>
		</div><!-- topics ends here -->


		<div class="searchbox">
			<form method="get" action="<?php echo site_url('cms/search');?>">
				<span>
					<label>Search By</label>
					<select name="search_option">
						<option>-Select-</option>
						<option>Author Name</option>
						<option>Article Title</option>
						<option data-name="pub-date">Article Published Date</option>
					</select>
					<input type='text' id="datetimepicker" name='search_value' value='' />

				</span>
			</form>
		</div>

		<script type="text/javascript">
			$input = $('.searchbox').find('input');
			$select_options = $('.searchbox').find('option');
			$select_options.each(function(){
				$(this).click(function(){
					$this = $(this);
					if($this.data('name') == "pub-date")
					{
						$('#datetimepicker').datetimepicker({"timepicker": false, "format" : "Y-m-d"});
						$input.focus();

					}
				})
			})



		</script>
