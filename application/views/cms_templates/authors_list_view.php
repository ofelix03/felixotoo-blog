<div class="content-box">

	<div class="commands">
		<ul>
			<li data-action="check_all" data-state="unchecked"><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/check.png') ;?>">&nbsp;<span>Check All</span></a><i class='fa fa-bookmark'></i></li>
			<?php if($_SESSION['access_level'] == 0) : ?>
			<li data-action="add"><a href="<?php echo site_url("cms/add_author"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/add.png') ; ?>">&nbsp;<span>Add</span></a></li>
			<?php endif; ?>
			<li data-action='del'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>">&nbsp;<span>Delete</span></a></li>
		</ul>
		<ul class='view-style'>
			<li><a href="#"><span>Views</span></a></li>
			<li data-action='grid_view' ><a href="<?php echo site_url('cms/authors/grid'); ?>" title="grid"><img style="width: 25px; height: 25px ;" src="<?php echo base_url('asset/img/cms/grid_view.png') ; ?>">&nbsp;</a></li>
			<li data-action='list_view' ><a href="<?php echo site_url('cms/authors/list'); ?>" title="view"><img style="width: 25px; height: 20px ;" src="<?php echo base_url('asset/img/cms/table_view.png') ; ?>">&nbsp;</a></li>
		</ul>
	</div><!-- commands ends here -->


	<div class="content">
		<?php if(isset($results)):?>
		<table class="author-table">
			<tr class='first-row'><td data-table ='authors'  data-order-by = 'user_id' data-order='asc' data-active="1"><a href="#">id &nbsp;<i class='fa fa-caret-up'></i></a></td>
				<td data-table = 'authors'   data-order-by = 'username' data-order='asc' data-active="0"><a href="#">Author&nbsp;<i  class='fa fa-caret-up'></i></a> </td>
				<td data-table = 'authors'  data-order-by = 'access_level' data-order='asc' data-active="0"><a href="#"> Priviledge &nbsp;<i  class='fa fa-caret-up'></i></a></td>
                <td data-table = 'authors'  data-order-by = 'access_level' data-order='asc' data-active="0"><a href="#"> Article(s) &nbsp;<i  class='fa fa-caret-up'></i></a></td>
				<td>Check</td><td>Del</td><td>Edit</td>
			</tr>
			<!-- content starts here -->
			<?php 
			foreach($results as $result):
				$id = $result['user_id'];
				$username = $result['username'];
				$access_level = ($result['access_level'] == 0)? 'Admin' : 'Publisher';
				$auth_article_total = $result['article_total'];
			?>

			<tr data-id="<?php echo $id; ?>">
				<td  data-id = '<?php echo $id;?>'><?php echo $id?></td>
				<td  data-id = '<?php echo $id;?>' class="author-td" style="position: relative;">
			     <a href="<?php echo site_url('cms/author_edit').'/'.$id; ?> ">
			     	<?php echo $this->cms_m->getAuthorField($id, 'name'); ?>
			        <?php if($id == $_SESSION['user_id']) : ?><i class="fa fa-user" style="position: absolute; bottom: 50%; right: 10px;"></i><?php endif;?>
			    </a> 
			     </td>
				<td  data-id = '<?php echo $id;?>'><?php echo $access_level;?></td>
                <td  data-id = '<?php echo $id;?>' data-action='article-total' data-name='auth-articles'><a href="<?php echo site_url('cms/view_all').'/'.$id; ?>"><?php echo $auth_article_total; ?></a></td>
				<td data-id='<?php echo $id;?>' data-action='check' data-state='unchecked'><img src="<?php echo base_url('asset/img/cms/unchecked.png');?>"></td>
				<td data-id='<?php echo $id;?>' data-action ='del'><img src="<?php echo base_url('asset/img/cms/close.png');?>"></td>
				<td  data-id='<?php echo $id;?>' data-action ='edit'> <a href="<?php  echo site_url("cms/author_edit/{$id}");?>"><img src="<?php echo base_url('asset/img/cms/file.png');?>"></a></td>
			</tr>
		<?php endforeach; ?>
	</table><!-- table end-->
<?php else: ?>
	<p style='margin-top: 30px; text-align: center;'>No articles found!</p>
<?php endif; ?>
<div class="author-profile">
	<h3 style="border-bottom: 1px solid #ccc; padding-left: 5px;">Profile</h3>
	<div class="profile" style="display: none;">
		<p class='name'><span>Name</span><span></span></p>
		<p class='age'><span>Age</span><span></span></p>
		<p class='sex'><span>Sex</span><span></span></p>
		<p class='profession'><span>Profession</span><span></span></p>
		<p class='in-brief'><span>In_Brief</span><span></span></p>
		<p class='social-networks'><span>Social Networks</span><span></span></p>
	</div>
	<p class="message">Click on an author to see profile.</p>
	<img />
</div><!-- author-profile end -->
<p class="clear"></p>
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
	var current_user_id = "<?php echo $_SESSION['user_id']; ?>";
	var access_level = "<?php echo $_SESSION['access_level']; ?>";
	var dialog = new DialogBox();
	$td = $('.content').find('td');
	$td.click(function(){
	$this = $(this);
	var action = get_action($this);
	switch(action){
		case 'del' :
		if(access_level != 0){
			var options = {
				"dialgogType" : "notification",
				"title" : "Notification",
				"message" : "Not enough privilege to  delete this account"
			}
			dialog.show(options);
		}
		else{
			var options = {
				"dialogType" : "confirmation",
				"title" : "Delete Article Confirmation",
				"message" : "Are you sure you want to delete?",
				"responseCallback" : ajax_del_author,
				"responseCallbackParameters" : $this
			}
		   dialog.show(options);
		}
		break;

		case 'check' :
			change_check_icon($this);
		break;
		
		case 'edit':
		if(current_user_id == get_id($this) || access_level == 0)
			return true;
		else
			var options = {
				"dialogType" : "notification",
				"title" : "Notification",
				"message" : "Not enough privilege to edit selected article(s)"
			}
			dialog.show(options);
	    break;
	    case 'article-total':
	    	return true;

	}
	return false;
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
	    return true;
		break;


		case 'del' :
		var access_level = "<?php echo $_SESSION['access_level']; ?>";
		if(access_level != 0){
			var options = {
				"title" : "Notification",
				"message" : "Not enough privilege to delete selected article(s)"
			}
			dialog.show(options);
		}

		else if(access_level  == 0 && get_checked_ids($tds).length  == 0)
		{
			var options = {
				"title" : "Notification",
				"message" : "No article selected for deletion",
				"dialogType" : "confirmation"
			}
			dialg.show(options);
		}
		else 
		{
			var options = {
				"dialogType" : "confirmation",
				"title" : "Delete Article Confirmation",
				"message" : "Are you sure you want to delete?",
				"responseCallback" : ajax_perm_del_authors_checked,
				"responseCallbackParameters" : $tds
			}
			dialog.show(options);
		}
		break;

		default:
			return true;
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
var $profile = $('.author-profile').find('.profile');
var $message = $('.author-profile').find('.message');
var $author_td = $('.author-td');

	$author_td.click(function(){
		$this = $(this);
			//hide the p.message element
			$message.fadeOut();
			$ajax_loader_img =  $profile.parent().find('img');
			ajax_get_profile(get_id($this), $ajax_loader_img);				
		return false;
	})

</script>
<script type="text/javascript" src='<?php echo base_url('asset/js/cms/authors_list_view.js') ?>'></script>
<script type="text/javascript" src='<?php echo base_url('asset/js/cms/common.js') ?>'></script>
<script type="text/javascript" src='<?php echo base_url('asset/js/prism.js') ?>'></script>
</body>
</html>