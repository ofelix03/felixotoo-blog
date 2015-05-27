<html>
<head>
	<title></title>

	<script type="text/javascript" src="<?php echo base_url('asset/js/jQuery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/bootstrap.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap_css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/font-awesome.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/layout.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/main.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/form.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/cms/dialogBox.css'); ?>">

	<style type="text/css">
		.searchbox input{
			height: 28px;
			border: 1px solid #ccc;

		}

		.searchbox select{
			height: 28px;
			border: 1px solid #ccc;
		}

		.container .content-box .content table tr td:nth-child(3){
			min-width: 500px;
			max-width: 950px;
			width: 900px;
			cursor: pointer;
		}

		.container .content-box .content table tr td:nth-child(4){
			min-width: 30px;
			max-width: 30px;
			width: 30px;
			cursor: pointer;
		}


	</style>
</head>
<body>

	<!-- DialogBox Markup -->
	<div id="dialogBox-underlay"></div>
	<div id="dialogBox">
		<div id="dialogBox-underlay"></div>
		<div id="dialogBox-curtain"></div>
		<div id="closeBtn"><button data-response='close'>Close</button></div>
		<div id="title"><i class="fa fa-info-circle fa-2x"></i><header><!-- tittle message here --></header></div>
		<div id="message"><!-- dialog message here --> </div>
		<div id="response">
			<button data-text="yes">Yes</button><button data-text='no'>No</button>
		</div>
	</div>

	<!-- DialogBox Markup end -->
	<div class="container">
		<div class="container-head">
			<div class="logo">
				<h3>CMS Dashboard</h3>
			</div>

			<div class="notification">Notifiction : <span></span></div>

			<div class="menu">
				<ul>
					<li><a href=""><i class =' fa fa-cog'></i>&nbsp; Setting</a>
						<ul data-active='inactive' >
							<li ><a data-url='<?php echo site_url('cms/edit_profile'); ?>' href="" data-action='edit-profile'>Edit Profile</a></li>
							<li><a data-url='<?php echo site_url('cms/delete_profile'); ?>' href=""  data-action='delete-profile'>Delete Profile</a></li>
							<li ><a  data-url='<?php echo site_url('cms/logout'); ?>' href="" data-action='logout'>Logout</a></li>
						</ul> 
					</li>
					<li><a href=""><i class='fa fa-user'></i>&nbsp; <?php echo ucfirst($_SESSION['username']); ?></a></li>
				</ul>
				
			</div>
			<p class="clear"></p>
		</div><!-- container-head ends here -->

		<div class="topics">
			<ul>
				<li><a class='current' href="<?php echo site_url('cms'); ?>">Articles</i></a></li>
				<li><a href="">Authors</a></li>
				<li><a href="">About</a></li>

			</ul>
		</div><!-- topics ends here -->

		<div class="searchbox">
			<span>
				<label>Search By</label>
				<select>
					<option>-Select-</option>
					<option>Author</option>
					<option>Published Date</option>
				</select>
				<input type='text' name='search-value' value='' />

			</span>
		</div>

		<div class="content-box">

			<div class="view-options">
				<ul>
					<?php 
					$segment = $this->uri->segment(2);
					if($segment == 'view_only_published')
						$active_only_published = "current";
					else if($segment == 'view_only_unpublished')
						$active_only_unpubilshed = "current";
					else if($segment == 'view_trashed')
						$active_only_trashed = "current";
					else
						$active_view_all = 'current';

					$disable_command = ($_SESSION['access_level'] != 0)? true : false;
					?>

					<li class="<?php echo isset($active_view_all) ? $active_view_all : ''; ?>"><a href="<?php echo site_url('cms/view_all');?>">View All</a><i class='fa fa-caret-up fa-2x'></i><span class='notify'><?php echo $view_all_num_rows;?></span></li>
					<li class="<?php echo isset($active_only_published) ? $active_only_published : ''; ?>"><a href="<?php echo site_url('cms/view_only_published'); ?>">Published</a><i class='fa fa-caret-up fa-2x'></i><span class='notify'><?php echo $pub_num_rows; ?></span></li>
					<li  class="<?php echo isset($active_only_unpubilshed) ? $active_only_unpubilshed : ''; ?>"><a href="<?php echo site_url('cms/view_only_unpublished');?>">Unpublished</a><i class='fa fa-caret-up fa-2x'></i><span class='notify'><?php echo $unpub_num_rows; ?></span></li>
					<li class="<?php echo isset($active_only_trashed) ? $active_only_trashed : ''; ?>"><a href="<?php echo site_url('cms/view_trashed');?>">Trashed</a><i class='fa fa-caret-up fa-2x'></i><span class='notify'><?php echo $trashed_num_rows; ?></span></li>
				</ul>
			</div>

			<div class="commands">
				<style type="text/css">

				</style>
				<ul>
					<li data-action="check_all" data-state="unchecked"><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/check.png') ;?>">&nbsp;<span>Check All</span></a><i class='fa fa-bookmark'></i></li>
					<li data-action="edit"><a  href="<?php echo site_url("cms/edit_article"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/file.png') ; ?>">&nbsp;<span>Edit</span></a></li>
					<li data-action="add"><a href="<?php echo site_url("cms/add_article"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/add.png') ; ?>">&nbsp;<span>Add</span></a></li>
					<li data-action='undel'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>">&nbsp;<span>Restore</span></a></li>
					<li data-action='del'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>">&nbsp;<span>Delete</span></a></li>
					<li data-action='pub'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/eye.png') ; ?>">&nbsp;<span>Publish</span></a></li>
					<li data-action='unpub'><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/eye-blocked.png') ; ?>">&nbsp;Unpublish</a></li>


				</ul>
			</div>




			<div class="content">
				<?php if($results):?>
					<table>
						<tr class='first-row'>
							<td data-table ='article'  data-order-by = 'id' data-order='asc' data-active="1"><a href="#">id &nbsp;<i class='fa fa-caret-up'></i></a></td>
							<td data-table = 'authors'   data-order-by = 'name' data-order='asc' data-active="0"><a href="#">Author&nbsp;<i  class='fa fa-caret-up'></i></a> </td>
							<td data-table = 'article'  data-order-by = 'title' data-order='asc' data-active="0"><a href="#">Article Title  &nbsp;<i  class='fa fa-caret-up'></i></a></td>
							<td>Check</td><td>Del</td>
							<td>Pub </td><td>Edit </td>
						</tr>
						<!-- content starts here -->
						<?php 
						foreach($results as $result):
							$title = $result['title'];
						$id = $result['id'];
						$pub_status = $result['pub_status'];
						$del_status = $result['del_status'];
						$auth_name = $result['name'];

						$border_bottom = "border-bottom: 1px solid ";
						if($pub_status == 0)
							$border_bottom .= "#ccc";
						else if($pub_status == 1)
							$border_bottom .= 'green';

						?>
						<tr data-id="<?php echo $id; ?>" style="<?php echo $border_bottom; ?>">
							<td ><?php echo $id?></td>
							<td ><?php echo $auth_name;?></td>
							<td  data-id='<?php echo $id;?>' data-action='edit'><?php echo $title?></td>
							<td data-id='<?php echo $id;?>' data-action='check' data-state='unchecked'><img src="<?php echo base_url('asset/img/cms/unchecked.png');?>"></td>
							<td data-id='<?php echo $id;?>' data-action ='perm_del' data-state = "<?php  echo ($del_status == 1)? '1' : '0'; ?>"><img src="<?php echo base_url('asset/img/cms/close.png');?>"></td>
							<td data-id='<?php echo $id;?>' data-action ='pub' data-state = "<?php  echo ($pub_status == 1)? '1' : '0'; ?>"><img src="<?php echo ($pub_status == 1) ? base_url('asset/img/cms/eye.png') : base_url('asset/img/cms/eye-blocked.png');?>"></td>
							<td><a href="<?php  echo site_url("cms/edit_article/{$id}");?>"><img src="<?php echo base_url('asset/img/cms/file.png');?>"></a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p style='margin-top: 30px; text-align: center;'>No articles found!</p>
			<?php endif; ?>
		</div>

	</div>
</div>


<div id="dialogBox">
	<div class="closeBtn"><button data-response='close'>Close</button></div>
	<div class="title">Confirm Action</div>
	<div class="message">Are you sure you want to delete the select item ?</div>
	<div class="response">
		<button data-responseText ='yes'>Yes</button><button data-responseText='no'>No</button>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/js/cms/dialogBox.js'); ?>"></script>

<!-- DO NOT DELETE THIS, VERY IMPORTANT 
	USED by site_url() function in cms_funtions
	USED by base_url() function  in cms_functions -->
	<p id='base_url' data-url="<?php echo base_url(); ?>"></p>
	<p id="site_url" data-url="<?php echo site_url(); ?>"></p>
	<!-- end of DO NOT DELETE THIS, VERY IMPORTANT -->

	<script type="text/javascript" src="<?php echo base_url('asset/js/cms/cms_functions.js'); ?>"></script>
	<script type="text/javascript">
		$(function(){

	//implementing actiosn for individuals row's commands
	$td = $('.content').find('td');
	var dialog = new DialogBox();

	$td.click(function(){
		$this = $(this);
		var action = get_action($this);
		switch(action){
			case 'perm_del' :
			console.log('permanent del');
			var access_level = "<?php echo $_SESSION['access_level']; ?>";
			if(access_level != 0){
				var options = {
					"type" : "confirmation",
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task"
				}
				dialog.show(options);
			}
			else{
				var options = {
					"dialogType" : "confirmation",
					"title" : "Delete Article Confirmation",
					"message" : "Are you sure you want to delete?",
					"responseCallback" : ajax_perm_del,
					"responseCallbackParameters" : $this
				}
				dialog.show(options);

				// ajax_perm_del($this);

			}


			break;

			case 'pub' :
			ajax_pub_unpub($this);
			break;

			case 'check' :
			change_check_icon($this);
			break;
		}

	});

	//implemenent actions in class commands
	$command_list = $('.commands').find('li');
	$tds = $('.content').find('td');

	$command_list.click(function(){
		$this = $(this);
		var action = get_action($this);
		switch(action){
			case 'check_all' :
			if(get_state($this) == "unchecked")
				check_all($this);
			else if(get_state($this) == 'checked')
				uncheck_all($this);
			break;

			case 'add':
			window.location.href();
			break;

			case 'edit':
			if(get_checked_ids($tds).length != 1)
			{ 
				var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "No article selected / multiple articles selected",
				}

				dialog.show(options);

			}
			else if(get_checked_ids($tds).length == 1){
				var selected_id  = get_checked_ids($tds)[0];
				var new_url = $(this).find('a').attr('href') + "/" + selected_id;
				window.location.replace(new_url);
				
			}


			break;

			case 'undel' :
			var access_level = "<?php echo $_SESSION['access_level']; ?>";
			if(access_level != 0){
				var options = {
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task"
				}
				var dialogBox = new DialogBox(options);
				dialogBox.show();
			}

			else if(access_level  == 0 && get_checked_ids($tds).length  == 0)
			{
				var options = {
					"title" : "Notification",
					"message" : "No article selected for undelete",
					"dialogType" : "notification"
				}
				var dialogBox = new DialogBox(options);
				dialogBox.show();
			}
			else 
			{
				var options = {
					"dialogType" : "confirmation",
					"title" : "Delete Article Confirmation",
					"message" : "Are you sure you want to delete?",
					"responseCallback" : ajax_undel_checked,
					"responseCallbackParameters" : $tds
				}
				dialog.show(options);

			}
			break;
			case 'del' :
			console.log('permanent del');
			var access_level = "<?php echo $_SESSION['access_level']; ?>";
			if(access_level != 0){
				var options = {
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task"
				}
				dialog.show(options);
			}

			else if(access_level  == 0 && get_checked_ids($tds).length  == 0)
			{
				var options = {
					"title" : "Notification",
					"message" : "No article selected for undelete",
					"dialogType" : "notification"
				};
				dialog.show(options);
			}
			else 
			{
				var options = {
					"dialogType" : "confirmation",
					"title" : "Delete Article Confirmation",
					"message" : "Are you sure you want to delete?",
					"responseCallback" : ajax_perm_del_checked,
					"responseCallbackParameters" : $tds
				};
				dialog.show(options);

			}
			
			break;


			case 'pub' :
			if(get_checked_ids($tds).length == 0)
			{
				var options = {
					"type" : "notification",
					"title" : "Notification",
					"message" : "No article selected for publishing"
				}
				dialog.show(options);
			}
			else
			{
				ajax_pub_checked($tds);
			}
			break;

			case 'unpub' :
			if(get_checked_ids($tds).length < 1)
			{
				var options = {
					"type" : "notification",
					"title" : "Notification",
					"message" : "No article selected for unpublishing"
				}
				var dialogBox = new DialogBox(options);
				dialogBox.show();
			}
			ajax_unpub_checked($tds);
			console.log('unpub');
			break;
		}
		return false;
	});


});

</script>


<script type="text/javascript">

	sort_data();
	change_sort_order();

	function sort_data(){
	//capture tds from the DOM
	var $first_row_td = $('.first-row').children();
	var $active_row_td;

	$first_row_td.click(function(){
		$this = $(this);
		$active_row_td = $this;

		
		//retrieve default order details from the DOM
		var order = $this.data('order');
		var order_by = $this.data('order-by');
		var table = $this.data('table');
		var old_url = "<?php echo current_url();?>"

		//create a new url , using the ORDER Details as appended query
		var new_url = old_url + '?order_by='+order_by + "&order=" + order + "&tb_name=" + table;
		//load new url 
		locate.url_replace(new_url);

		return false;
	});

}

function change_sort_order(){
	//capture tds from the first row in the DOM
	var $first_row_td = $('.first-row').children();

	//store the order details received fromt the server
	var order_by = "<?php echo isset($order_by)? $order_by : ''; ?>";
	var order = "<?php echo isset($order)? $order : ''; ?>";
	var table = "<?php echo isset($tb_name)? $tb_name : ''; ?>";

	//iterate through tds to find the td tht matches the order details received from the server
	$first_row_td.each(function(){
		$this = $(this);
		if(get_tb_name($this) == table && get_order_by($this) == order_by){
			//change the order value  with value received from the server
			set_order($this, order);

			//change the caret-img
			$i = $this.find('i');
			change_sort_img($i, order);
		}
	});
}


</script>


<script type="text/javascript">
	//cms menu list js
	var $main_menu_list = $('.menu').find('ul').first().children();
	var $hidden_menu = $main_menu_list.find('ul');
	//var $hidden_menu = $main_menu_list.find('ul');
	$main_menu_list.click(function(){
		$this = $(this);
		if($hidden_menu.data('active') == 'inactive')
		{
			$hidden_menu.data('active', 'active');
			$hidden_menu.show().slideDown(100);
		}
		else if($hidden_menu.data('active') == 'active')
		{
			$hidden_menu.data('active', 'inactive');
			$hidden_menu.hide().slideUp(100);

		}
		return false;
	});


	$hidden_menu.children().each(function(){
		$this = $(this);
		$this.find('a').click(function(){
			$this = $(this);
			if($this.data('url')){
				var url = $this.data('url');
			}
			else
			{
				var url = $(this).attr('href');
			}

			window.location.replace(url);
			
			return false;
		})

	});
		// var $hidden_menu = $this.find('ul');

		// //set data-active = active
		

		

	</script>



</body>
</html>