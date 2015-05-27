        <style type="text/css">

        .enclose-tag{
        	margin-top: 10px;
        }

        </style>

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
			</div><!-- view -options ends here -->

			<div class="commands">
				<ul>
					<li data-action="check_all" data-state="unchecked"><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/check.png') ;?>">&nbsp;<span>Check All</span></a><i class='fa fa-bookmark'></i></li>
					<li data-action="edit"><a  href="<?php echo site_url("cms/edit_article"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/file.png') ; ?>">&nbsp;<span>Edit</span></a></li>
					<li data-action="add"><a href="<?php echo site_url("cms/add_article"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/add.png') ; ?>">&nbsp;<span>Add</span></a></li>
					<li data-action='del'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>">&nbsp;<span>Trash</span></a></li>
					<li data-action='pub'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/eye.png') ; ?>">&nbsp;<span>Publish</span></a></li>
					<li data-action='unpub'><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/eye-blocked.png') ; ?>">&nbsp;Unpublish</a></li>
				</ul>
			</div><!-- commands ends here -->
  			

  			<?php  if(isset($feedback) && !empty($feedback)) :  ?>
  			<script type="text/javascript">
  				$(document).ready(function(){
  					 var d = new DialogBox();
	  				 var message = "<?php echo  $feedback; ?>";
	  				 var options = {
						"dialogType" : "notification",
						"title" : "Account Validation",
						"message" : message
					}
					d.show(options);
  				});
  			</script>
	  		<?php endif; ?>

			<div class="content">
				<?php if(isset($results) && $results !== FALSE):?>
				<?php echo isset($pagination)? $pagination : "";?>
				<table>
					<tr class='first-row'><td data-table ='article'  data-order-by = 'id' data-order='asc' data-active="1"><a href="#">id &nbsp;<i class='fa fa-caret-up'></i></a></td>
						<td data-table = 'authors'   data-order-by = 'name' data-order='asc' data-active="0"><a href="#">Author&nbsp;<i  class='fa fa-caret-up'></i></a> </td>
						<td data-table = 'article'  data-order-by = 'pub_date' data-order='asc' data-active="0"><a href="#">Publish Date  &nbsp;<i  class='fa fa-caret-up'></i></a></td>
						<td data-table = 'article'  data-order-by = 'title' data-order='asc' data-active="0"><a href="#">Article Title  &nbsp;<i  class='fa fa-caret-up'></i></a></td>
						<td>Check</td><td>Del</td>
						<td>Pub </td><td>Edit </td>
					</tr>
					<!-- content starts here -->
					<?php 
					foreach($results as $result):
						$title =  stripslashes($result['title']);
						$id = $result['id'];
						$pub_status = $result['pub_status'];
						$del_status = $result['del_status'];
						$auth_name = stripslashes($result['name']);
						$auth_id = $result['auth_id'];
	                    $pub_date = $result['pub_date'];
						$border_bottom = "border-bottom: 1px solid ";
						if($pub_status == 0)
							$border_bottom .= "#ccc";
						else if($pub_status == 1)
							$border_bottom .= 'green';


					?>
					<tr data-id="<?php echo $id; ?>" style="<?php echo $border_bottom; ?>">
						<td ><?php echo $id?></td>
						<td > <?php echo $this->cms_m->getAuthorField($auth_id, 'name'); ?></td>
                        <td ><?php echo $pub_date;?></td>
 						<td  data-id='<?php echo $id;?>' data-action='edit'><a href="<?php echo site_url('cms/edit_article').'/'.$id; ?>"><?php echo $title?></a></td>
						<td data-id='<?php echo $id;?>' data-action='check' data-state='unchecked' data-auth-id="<?php echo $auth_id;?>"><img src="<?php echo base_url('asset/img/cms/unchecked.png');?>"></td>
						<td data-id='<?php echo $id;?>' data-action ='del' data-state = "<?php  echo ($del_status == 1)? '1' : '0'; ?>"><img src="<?php echo base_url('asset/img/cms/close.png');?>"></td>
						<td data-id='<?php echo $id;?>' data-action ='pub' data-auth-id="<?php echo $auth_id;?>" data-state = "<?php  echo ($pub_status == 1)? '1' : '0'; ?>"><img src="<?php echo ($pub_status == 1) ? base_url('asset/img/cms/eye.png') : base_url('asset/img/cms/eye-blocked.png');?>"></td>
						<td data-id='<?php echo $id;?>' data-action ='edit' data-auth-id="<?php echo $auth_id;?>" data-auth-id="<?php echo $auth_id;?>"><a href="<?php  echo site_url("cms/edit_article/{$id}");?>"><img src="<?php echo base_url('asset/img/cms/file.png');?>"></a></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php echo isset($pagination)? $pagination : "";?>
		<?php else: ?>
		<p style='margin-top: 30px; text-align: center;'>No articles found!</p>
	<?php endif; ?>
</div><!-- content ends here -->

</div>
</div>


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
	$td.click(function(){
		$this = $(this);
		$object = $this;
		var action = get_action($this);
	    var access_level = "<?php echo $_SESSION['access_level']; ?>";
	    var cur_user_id = "<?php echo $_SESSION['user_id']; ?>";
	    var article_auth_id = $this.data('auth-id');
		var dialogBox = new DialogBox();
		switch(action){
			case 'del' :
			if(access_level != 0){
				var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task",
				}
				dialogBox.show(options);
			}
			else{
				var options = {
					"dialogType" : "confirmation",
					"title" : "Deletion Confirmation",
					"message" : "Are you sure about deletion of selected item",
					"responseCallback" : ajax_del,
					"responseCallbackParameters" : $this
				}
				dialogBox.show(options);
			}


			break;

			case 'pub' :
			if(article_auth_id != cur_user_id && access_level != 0)
			{
				var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task",
				}
				dialogBox.show(options);
			}
			else
			  ajax_pub_unpub($this);
			break;

			case 'check' :
			if(article_auth_id != cur_user_id && access_level != 0)
			{
				var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task",
				}
				dialog.show(options);

			}
			else
			{
				change_check_icon($this);

			}
			break

			case 'edit':
			if(article_auth_id != cur_user_id && access_level != 0)
			{
              var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "Not enough privilege to execute selected task",
				}
				dialog.show(options);
			}
			else
				return true;
		 break;
		}
		return false;

	});


       
	

	//implemenent actions in class commands
	$command_list = $('.commands').find('li');
	$tds = $('.content').find('td');
	var dialog = new DialogBox();
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
					"message" : "Not enough privilege to execute selected task",
					}
					dialog.show(options);
					
				}
				else{
					var selected_id  = get_checked_ids($tds)[0];
					var new_url = $(this).find('a').attr('href') + "/" + selected_id;
					window.location.replace(new_url);
					
				}


				break;

				case 'del' :
				var access_level = "<?php echo $_SESSION['access_level']; ?>";
				if(access_level != 0){
					var options = {
					"dialogType" : "notification",
					"title" : "Notification",
					"message" : "No article checked / Selected more than one article."
					}
					dialog.show(options);
				}

				else if(access_level  == 0 && get_checked_ids($tds).length  == 0)
				{
					var options = {
						"title" : "Notification",
						"message" : "No article selected for deletion",
						"dialogType" : "notification"
					}
					dialog.show(options);
				}
				else 
				{				
					var options = {
					"dialogType" : "confirmation",
					"title" : "Deletion Confirmation",
					"message" : "Are you sure about deletion of selected item",
					"responseCallback" : ajax_del_checked,
					"responseCallbackParameters" : $tds
				}
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
					dialog.show(options);
				}
				ajax_unpub_checked($tds);
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
		var old_url = "<?php echo current_url();?>";
		var cur_page_id = "<?php echo !empty($cur_page_id)? $cur_page_id : 0; ?>";  //keeps tracks of the page_id of the pagination
		//create a new url , using the ORDER Details as appended query
		var new_url = old_url + '?order_by='+order_by + "&order=" + order + "&tb_name=" + table  + "&page=" + cur_page_id;
		//load new url 
		window.locate.url_replace(new_url);

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
		if($this.data('table') == table && get_order_by($this) == order_by){
			//change the order value  with value received from the server
			set_order($this, order);

			//change the caret-img
			$i = $this.find('i');
			change_sort_img($i, order);
		}
	});
}


</script>

<script type="text/javascript" src='<?php echo base_url('asset/js/cms/common.js') ?>'></script>
<script type="text/javascript" src='<?php echo base_url('asset/js/prism.js') ?>'></script>

</body>
</html>