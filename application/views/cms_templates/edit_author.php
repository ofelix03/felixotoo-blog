<style type="text/css">

form span{
	position: relative;
}
form span img#eye{
	position: absolute;
	height : 20px;
	width: 20px;
	right:8px;
	top:6px;
	cursor: pointer;
	display: none;

}



</style>
<div class="content-box">
	<div class="head"><h3>Edit Author</h3></div>
	<div class="content">
	<?php 	if(isset($author_details)):  ?>
		<?php echo form_open_multipart('cms/author_edit', array('id' => 'ofelix')); ?>

		<div class="left">
			<h4>Article Details</h4>
			<?php if(isset($edit_success_status)): ?>
			<p class='success'><?php echo $edit_success_status; ?></p>
			<?php endif; if(isset($edit_fail_status)) : ?>
				<p class='warning'><?php echo $edit_fail_status; ?></p>
			<?php endif;?>
		
	<?php
		$name = stripslashes($author_details['name']);
	    $username = $author_details['username'];
	    $password = $author_details['password'];
	    $age = $author_details['age'];
	    $sex = $author_details['sex'];
	    $profession  = $author_details['profession'];
	    $in_brief = $author_details['in_brief'];
	    $social_networks = $author_details['social_networks'];
	    $websites = $author_details['websites'];
	    $thumbnail = isset($author_details['auth_thumb'])? $author_details['auth_thumb'] : 'n/a';
	    $user_id = isset($author_details['id']) ? $author_details['id'] : $author_details['user_id'];
	    $thumbnail = isset($author_details['thumb_name'])? $author_details['thumb_name'] : "image_unavailable.jgp";
	    $thumbnail_mime = isset($author_details['thumb_mime'])? $author_details['thumb_mime'] : 'n\a';
	    $thumbnail_size =  isset($author_details['thumb_size'])? $author_details['thumb_size']."Kb" : 'n\a';
	    $thumbnail_dimesion = isset($author_details['thumb_width'])? $author_details['thumb_width']. " * ".$author_details['thumb_height'] : 'n\a';

	?>
	<label>Username</label>
	<span><input type='text' name='username' value='<?php echo $username;?>'/><span>
	<label>Password</label>
	<span><img id="eye" data-state = "" src="<?php echo base_url('asset/img/cms/eye-blocked.png'); ?>"><input type='password' name='password' value="<?php echo $password; ?>" id="password" class="<?php echo isset($warning['password'])? 'warning' : ''; ?>" /><span>
 	<span><input type='password' style='display: none' name='password_confirm' value="<?php echo $password;?>"  id = "re-password" class="<?php echo isset($warning['password_confirm'])? 'warning' : ''; ?>" /><span>
 	<span><input type='hidden' name='password_tampered' value="" class="password_tampered" id = "password-tampered" /><span>

		<label>Name</label>
		<span><input type='text' name='name' value='<?php echo $name; ?>'   class="<?php echo isset($warning['name'])? 'warning' : ''; ?>"/><span>
	<label>Age</label>
		<span><input type='text' name='age' value='<?php echo $age; ?>'   class="<?php echo isset($warning['age'])? 'warning' : ''; ?>"/><span>
	<label style="display: inline;">Sex</label>
	      <span class="<?php echo isset($warning['sex'])? 'warning' : ''; ?>">
	          	<input  type="radio" name="sex" value="male"   style="width: 2%;" id="male"  <?php echo (strtolower($sex) == "male")? "checked=checked" : "";?>/> <label for="male" style="display: inline;">Male</label> &nbsp;&nbsp; 
          	    <input  type="radio" name="sex" value="female"  style="width: 2%;" id="female"  <?php echo (strtolower($sex) == "female")? "checked=checked" : "";?> /> <label for="female" style="display: inline;">Female</label>
          </span>


           </script>
		<label>Profession</label>
		<span><textarea name='profession' cols='5' rows='2'   class="<?php echo isset($warning['profession'])? 'warning' : ''; ?>"><?php echo $profession; ?></textarea><span>
		
		<label>In_brief</label>
		<span><textarea name='in_brief' cols='5' rows='2'   class="<?php echo isset($warning['in_brief'])? 'warning' : ''; ?>"><?php echo $in_brief; ?></textarea><span>
		
		<label>Social Networks</label>
		<span><input type='text' name='social_networks' value='<?php echo $social_networks;?>'  class="<?php echo isset($warning['social_networks'])? 'warning' : ''; ?>"/><span>
		<label>Websites</label>
		<span><input type='text' name='websites' value='<?php echo $websites; ?>'  class="<?php echo isset($warning['websites'])? 'warning' : ''; ?>"/></span>
		<!-- store the article id in a hidden input field -->
		<span><input type='hidden' name='user_id' value='<?php echo $user_id; ?>' /></span>

		<span>
			<input style='width: 15%; float:right;' type='submit' value='Edit' />
			<input style='width: 15%; float:right;' type='reset' value='Reset' />
		</span>
	</div><!-- end of left -->

	<div class="right">
		<h4>Author Thumbnail Details</h4>

		<div class="thumbnail">
			<img src="<?php echo base_url('asset/img/authors_thumbs').'/'.$thumbnail; ?>" />
		</div>

		<div class="thumbnail-details">
			<label>File Name</label><span><?php  echo $thumbnail; ?></span>
			<label>Dimension</label><span><?php echo $thumbnail_dimesion; ?></span>
			<label>File Type</label><span><?php echo $thumbnail_mime; ?></span>
			<label>File Size</label><span><?php echo $thumbnail_size; ?></span>
		<?php if(empty($thumbnail)):?>
			<p style='font-size: 13px; padding: 10px 10px;'>No thumbnail attached to article.</p>
			<p style='font-size: 13px; padding: 10px 10px;'><input  style='display: none;' type='file' name='thumbnail'/><a style='text-decoration: none;'  class='upload-thumbnail' href="#">Upload thumbnail</a></p> 
		<?php else :?>
			<p style='font-size: 13px; padding: 10px 10px;'><input  style='display: none;' type='file' name='thumbnail'/><a style='text-decoration: none;'  class='upload-thumbnail' href="#">Change thumbnail</a></p> 
		<?php endif; ?>

</div>
</div>
					<p class="clear"></p>
				</form>

			<?php else: ?>
			<p class='warning'><span>No article selected.</span><span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></span> </p>
		<?php endif; ?>
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

	<script type="text/javascript" src='<?php echo base_url('asset/js/cms/edit_article.js') ?>'></script>
	<script type="text/javascript" src='<?php echo base_url('asset/js/cms/common.js') ?>'></script>

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
					}
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



/****************************************************************
        Show Re-password field on keypress trigger on password field
***********************************************************************/
     
		var $password = ($('form').find("#password"));
		var $password_repeat = $('form').find('#re-password');
		var $password_tampered = $('form').find('#password-tampered');
          
          $password.keydown(function(){
          	  //show hidden re-password field
          	  $password_repeat.slideDown();
          	  $password_repeat.attr('type', 'text');
          	  $password_repeat.attr('placeholder', "Enter password again");

          	  //set password_tampered val to 1
          	  $password_tampered.val(1);
          });

           $password_repeat.focus(function(){
          	  $(this).attr('type','password');
          	  $(this).val('');
          })


			</script>


			<script type="text/javascript">




  /****************************************************
            show or hide password in plain text or
 *****************************************************/
       $password_visibility_icon = $("#eye");
       $password_repeat = $("#re-password");
       $password.mouseenter(function(){
             $password_visibility_icon.fadeIn();
       });


       $password_visibility_icon.click(function(){
       	  $this = $(this);
       	  var state = $this.data('state');
       	  if(state == ""){
       	  	   //turn password visibility on
       	  	   $this.attr('src', $("#base_url").data('url') + "asset/img/cms/eye.png");
       	  	   $this.data('state', 'visible');
       	  	   $password.attr('type', 'text');
       	  	   $password_repeat.attr('type', 'text');
       	  }
       	  else if(state == "visible"){
       	  	//turn password visibility off
       	  	  $this.attr('src', $("#base_url").data('url') + "asset/img/cms/eye-blocked.png");
       	  	   $this.data('state', '');
       	  	   $password.attr('type', 'password');
               $password_repeat.attr('type', 'password');
       	  }
       })


       //show or hide the re-password in plaint text or not
       $password_repeat.keypress(function(){
       	      $this = $(this);
       	      var state = $password_visibility_icon.data('state');
       	      if(state == "")
       	      {
       	      	  $this.attr('type', 'password');
       	      }
       	      else if(state == "visible")
       	      {
       	      	$this.attr('type', 'text');
       	      }
       })



	</script>




</body>
</html>