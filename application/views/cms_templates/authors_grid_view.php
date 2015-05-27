<div class="content-box">
	<div class="commands">
		<ul>
			<li data-action="check_all" data-state="checked"><a href=""><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/check.png') ;?>">&nbsp;<span>Check All</span></a><i class='fa fa-bookmark'></i></li>
			<li data-action="add"><a href="<?php echo site_url("cms/add_article"); ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/add.png') ; ?>">&nbsp;<span>Add</span></a></li>
			<li data-action='del'><a href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>">&nbsp;<span>Delete</span></a></li>
		</ul>
		<ul class='view-style'>
			<li><a href="#"><span>Views</span></a></li>
			<li data-action='grid_view' ><a href="<?php echo site_url('cms/authors/grid'); ?>" title="grid"><img style="width: 25px; height: 25px ;" src="<?php echo base_url('asset/img/cms/grid_view.png') ; ?>">&nbsp;</a></li>
			<li data-action='list_view' ><a href="<?php echo site_url('cms/authors/list'); ?>" title="view"><img style="width: 25px; height: 20px ;" src="<?php echo base_url('asset/img/cms/table_view.png') ; ?>">&nbsp;</a></li>
		</ul>
	</div><!-- commands ends here -->
	<div class="content">
		<div class='thumbnail-outer-wrapper'>
			<?php if(isset($results)): 
                  foreach($results as $result):
                  $username = $result['username'];
                  $user_id = $result['user_id'];
                  $back_img = ( $result['thumb_name'])?  $result['thumb_name'] : "image_unavailable.jpg";
                  $article_num = $result['article_num'];

			?>
			<div class="thumbnail-wrapper">
				<div class="thumbnail" data-id="<?php echo $user_id; ?>"><img style="width: 100%; height: 100%;" src="<?php echo base_url().'asset/img/authors_thumbs/'.$back_img; ?>" /></div>
				<div class="thumbnail-sidebar">
					<span data-action='edit'><a data-action='edit' data-id="<?php echo $user_id; ?>"  href="<?php echo site_url('cms/author_edit').'/'.$user_id; ?>"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/file.png') ; ?>"></a></span>
					<span data-action='del'><a data-action='del'  data-id="<?php echo $user_id; ?>" href="#"><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/close.png') ; ?>"></a></span>
				</div>
				<div class="notify"><a  style='display: block; text-decoration: none;padding: 10px; ' href="<?php echo site_url('cms/view_all').'/'.$user_id; ?>"><?php echo $article_num;  ?></a></div>
				<div class="author-name"><a href="<?php echo site_url('cms/author_edit').'/'.$user_id;; ?>"><?php echo $this->cms_m->getAuthorField($user_id, 'name'); ?></a></div>
				<div class="check-show" data-id = '1' data-action='check' data-state='unchecked'><img style="width: 20px; height: 20px;" src="<?php echo base_url('asset/img/cms/unchecked.png') ;?>"></div>
			    <?php if($user_id == $_SESSION['user_id']) : ?><i class="fa fa-user " style="position: absolute; bottom: 10px; right: 70px;"></i><?php endif;?>
			</div><!-- thumbnail-wrapper ends -->
			<?php endforeach; endif;			?>



		</div>
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
			<p class="message">Click on a thumbnail to see profile</p>
			<img />
		</div><!-- author-profile end -->


		<p class="clear"></p>
		
	</div><!--end of content-->

</div><!-- content-box ends here -->


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

	<!-- DO NOT DELETE THIS, VERY IMPORTANT 
	USED by site_url() function in cms_funtions
	USED by base_url() function  in cms_functions -->
	<p id='base_url' data-url="<?php echo base_url(); ?>"></p>
	<p id="site_url" data-url="<?php echo site_url(); ?>"></p>
	<!-- end of DO NOT DELETE THIS, VERY IMPORTANT -->


	<script type="text/javascript" src="<?php echo base_url('asset/js/cms/authors_grid_view.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/cms/dialogBox.js'); ?>"></script>

	<script type="text/javascript">
	var commands = $('.commands').find('ul li');
	var $checkIcons = $('.check-show');
	var $thumbnailSidebar = $('.thumbnail-sidebar').find('span');
	var access_level = "<?php echo isset($_SESSION['access_level']) ? $_SESSION['access_level'] : ''; ?>";
	var user_id = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
    var dialog = new DialogBox();
    //Handlers on click event on main command menu list
    commands.each(function(){
    	$menu_list = $(this);
    	$menu_list.click( function(){
    		//click event triggered
    		$this = $(this);
    		var action = get_action($this);
    		switch(action){
    			case 'check_all':
	    			checkAllClicked($this, $checkIcons);
	    			break;

    			case 'add':
	    			return true;
	    			break;

    			case 'del': 
	    			var checked_ids = get_checked_ids($checkIcons);
	    			var failed_ids = [];
	    			var count = 0;
	    			for(var i = 0; i < checked_ids.length; i++)
	    			{
	    				if(checked_ids[i] == user_id ||  access_level == 0)
	    				{
	    					//not enought privilege to delete account
	    					var options = {
	    						dialogType : "confirmation",
	    						message :  "You have priviledges to delete only  account with id[" + checked_ids[i] +"]. Confirm deletion  of this account",
	    						title : "Delete Confirmation",
	    						responseCallback : ajax_del_checked,
	    						responseCallbackParameters : $checkIcons
	    					}
	    					dialog.show(options);
	    				}
	    			}
	    			break;

    			default:
    				return true;
    			break;
    		}
    		return false;

    	})

});

	//Handlers on click event on inline commands
	$thumbnailSidebar.each(function(){
		$this = $(this);
		$this.click(function(){
			var $link = $(this).find('a');
			var action = get_action($link);
			switch(action){
				case 'edit':
					return true;
				break;

				case 'del':
					if(user_id  == get_id($link) || access_level == 0)
					{
						var options = {
	    						dialogType : "confirmation",
	    						message :  " Confirm deletion  of this account",
	    						title : "Delete Confirmation",
	    						responseCallback : ajax_del,
	    						responseCallbackParameters :  $link
	    					}
	    					dialog.show(options);
					}
					else
					{
    					var options = {
    						dialogType : "notification",
    						message :  "You dont have enough priviledge to delete this account",
    						title : "Delete notification"
    					}
    					dialog.show(options);
	    			}
    			break;
    		}
    			return false;
    		})
	});

	$(function(){
    	//CheckIcon Click Handler
    	$checkIcons.each(function(){
    		$this = $(this);
    		$this.click(function(){
    			$this  = $(this);
    			checkIconClicked($this);
    		})
    	})

    	//Check All Click Handler
    });


</script>
<script type="text/javascript" src='<?php echo base_url('asset/js/cms/authors_grid_view.js') ?>'></script>

<script type="text/javascript">

var $thumbnail = $('.thumbnail');
var $message = $('.author-profile').find('.message');
var $img = $('.author-profile').find('img');
var $profile = $('.author-profile').find('.profile');
$thumbnail.click(function(){
	$this = $(this);
	//hide the p.message element
	$message.fadeOut();
	$ajax_loader_img =  $img;
    ajax_get_profile(get_id($this), $ajax_loader_img);

	return false;
})

</script>