		<div class="content-box">
			<div class="head"><h3>Add New Author</h3></div>

			<div class="content">
				<div class="left" style="position: relative;">
					<h4>Author's Credentials</h4>
					<?php if(isset($add_success_status)): ?>
						<p class='success'><?php echo $add_success_status; ?></p>
						 <div class="new-note-btn" style="position: absolute; right:-2%; top: -5%; border:1px solid #f0f1f2; background: #fff; border-radius: 50%; padding: 14px 16px;">
						    <a href="<?php echo site_url("cms/add_author"); ?>" title="Add New Article"><i class='fa fa-user fa-2x'></i></a>
					    </div>
					<?php elseif(isset($add_fail_status)):?>
						<p class='warning'><?php echo $add_fail_status; ?></p>
					<?php endif; ?>
                    
                    <div class="admin"  style="display: <?php echo ($_SESSION['access_level'] == 0)? 'block' : 'none';?>">
                    	<?php echo form_open_multipart('cms/add_author', array('id'=>'ofelix'));?>
					     	<label>Username</label>
							<span><input type='text' name='username' value="<?php echo set_value('username');?>" class="<?php echo isset($warning['username'])? 'warning-notice' : ''; ?>" /><span>
							<label>Email</label>
							<span><input type='text' name='email' value="<?php echo set_value('email');?>" class="<?php echo isset($warning['email'])? 'warning-notice' : ''; ?>" /><span>
							
							<span><input type='hidden' name='current_user_level' value="<?php echo $_SESSION['access_level']; ?>" class="<?php echo isset($warning['access_level'])? 'warning-notice' : ''; ?>" /><span>
					     	<label>Access Level</label>
							<span style='margin-left: 15px;' class='published-radiobox'>
								<input style='width: 0px;' type='radio'   name='access_level' value='admin' id="admin" /> <label for="admin" style="display: inline;">Admin</label>&nbsp;&nbsp;
								<input  style='width: 0px;' type='radio' name='access_level' value='publisher' id="publisher"/> <label for="publisher" style="display: inline;">Publisher</label> </span>
							<p style="margin-top: 5px; "><i class='fa fa-info-circle fa-2x' style='position: relative; top: 5px; margin-right: 5px;'></i>Password would be automatically generated and emailed to author.</p>
							<span>
								<input type='submit' value='Add'  style='width: 15%; float:right;' />
								<input  type='reset' value='Rest'   style='width: 15%; float:right;'/>
							</span>
						</form>
                    </div>
			       </div>
			</div>
		</div>
	</div>
</div>



<!-- DO NOT DELETE THIS, VERY IMPORTANT 
	USED by site_url() function in cms_funtions
	USED by base_url() function  in cms_functions -->
	<p id='base_url' data-url="<?php echo base_url(); ?>"></p>
	<p id="site_url" data-url="<?php echo site_url(); ?>"></p>
	<!-- end of DO NOT DELETE THIS, VERY IMPORTANT -->


	<!-- UPLOAD BUTTON JAVASCRIPT -->
	<script type="text/javascript">
	var $upload_link_fake = $('.upload-thumbnail');
	var $upload_link_real  = $('.thumbnail-details').find("input[type='file']");
	$upload_link_fake.click(function(){
		//trigger click on the real upload link
		$upload_link_real.click();
		return false;
	})


	</script>

	<script type="text/javascript">


	var $radiobox = $('.published-radiobox').find('input');
	var $publish_date_field = $("input[name='pub_date']");
	$radiobox.click(function(){
		$this = $(this);
		if($this.val() == 'y')
		{
			var message = "Publish date woulld be set automatically.";
			//set publish date to the current date
			$publish_date_field.attr('placeholder', message);
			$publish_date_field.val('automatically-setted');

			//disable field
			$publish_date_field.attr('disabled', 'disabled');

		}
		else 
		{
			//enable the field
			$publish_date_field.removeAttr('disabled');
			$publish_date_field.val('');
			message = 'Enter a  publish date for this article';
			//prompt the user to enter the publish date 
			$publish_date_field.attr('placeholder', message );
		}
	})


	</script>

	<script type="text/javascript">
		//input and textarea focusout event
		//on focusout if input or textarea contains value change to green or show red

		$(function(){
			var $form = $('form');
			var $spans = $form.find('span');
			$spans.each(function(index){
				$input = $(this).find('input');
				$input.focusout(function(){
					$this = $(this);
					if($this.val() != '')
					{
						//detach the warning class form the input
						$this.removeAttr('class', 'warning');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('class', 'warning');
						$this.attr('placeholder', "Please this field is required!");					}
				})
			})
		})

		$(function(){
			var $form = $('form');
			var $spans = $form.find('span');
			$spans.each(function(index){
				$textarea = $(this).find('textarea');
				$textarea.focusout(function(){
					$this = $(this);
					if($this.val() != '')
					{
						//detach the warning class form the input
						$this.removeAttr('class', 'warning');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('class', 'warning');
					}
				})
			})
		})
	</script>



	<script type="text/javascript">
	/*********************************************************
	*			Ajax call to server that returned a slug of a text *
	***************************************************************/
	var $title = $('form').find("input[name='title']");
	var $slug = $('form').find("input[name='slug']");
	$title.focusout(function(){
		$this = $(this);
		if($this.val() != ""){
			//ajax call to server to build a slug for the title
			var url = $('#site_url').data('url') + '/cms/create_slug';
			var data = {"text" : $this.val()};

			$.get(url, data, function(ret_data){
					var data = ret_data;
					//assign it to the val of $slug
					$slug.val(data);
			});

		}
	})
	</script>



<script type="text/javascript" src='<?php echo base_url('asset/js/cms/common.js') ?>'></script>








</body>
</html>