

<div class="content-box">
	<div class="head"><h3>Add New Article</h3><span></div>

	<div class="content">
		<div class="left" style="position: relative;">
			<?php if(isset($add_success_status)): ?>
			   <div class="new-note-btn" style="position: absolute; right:-2%; top: -2%; border:1px solid #f0f1f2; background: #fff; border-radius: 50%; padding: 14px 16px;">
				    <a href="<?php echo site_url("cms/add_article"); ?>" title="Add New Article"><i class='fa fa-file-o fa-2x'></i></a>
			    </div>
			<?php endif;?>

			<h4>Article Details</h4>
			<?php if(isset($add_success_status)): ?>
				<p class='success'><?php echo $add_success_status; ?></p>
			<?php elseif(isset($add_fail_status)):?>
				<p class='warning'><?php echo $add_fail_status; ?></p>
			<?php endif; ?>

			<?php echo form_open_multipart('cms/add_article', array('id' => 'ofelix'));?>
			<label>Author</label>
			<span><input type='text'  name='author'	value="<?php echo $_SESSION['fullname']; ?>"><span>
				<span><input type='hidden' name='auth_id' value="<?php echo $_SESSION['user_id']; ?>"><span>
					<label>Title</label>
					<span><input type='text' name='title' value="<?php echo set_value('title'); ?>"
						class="<?php echo isset($warning['title'])?  'warning' : ''; ?>"/><span>
						<label>Summary</label>
						<span><textarea name='summary' cols='5' rows='5' 
							class="<?php echo isset($warning['summary'])? 'warning' : ''; ?>"><?php echo set_value('summary'); ?></textarea>
						</span>
						<label>Message</label>
						<span><textarea name='message' cols='5' rows='7' 
							class="<?php echo isset($warning['message'])? 'warning' : ''; ?>"><?php echo set_value('message'); ?></textarea>
							<span>
								<label>Slug</label>
								<span><input type='text' name='slug' value="<?php echo set_value('slug'); ?>"
									class="<?php echo isset($warning['slug'])? 'warning' : ''; ?>"/><span>
									<label>Tags</label>
									<span><input type='text' name='tags' value="<?php echo set_value('tags'); ?>"
										class="<?php echo isset($warning['tags'])? 'warning' : ''; ?>"/><span>
										<label>Publish</label>
										<span style='margin-left: 15px;' class='published-radiobox'>
											<input  type='radio'   name='pub_status' value='y'   <?php if(isset($set_values['pub_status']) && $set_values['pub_status'] == 'y') echo 'checked=checked'; ?> style="width: 5%; display: inline; height: auto; border: none;" /> Yes&nbsp;&nbsp;
											<input  type='radio'   name='pub_status' value='n' <?php if(isset($set_values['pub_status']) && $set_values['pub_status'] == 'n') echo 'checked=checked'; ?> style="width: 5%; display: inline; height: auto; border: none;" /> No 
										</span>
										<label>Publish Date</label>
										<span>
											<input type='text' name='pub_date' selected='selected' disabled='disabled' value="<?php echo set_value('pub-date'); ?>"  class="<?php echo isset($warning['pub_date'])? 'warning' : ''; ?>"/>
										</span>
										<span>
											<label style="display:inline-block;">Feature article on carousel</label>
											<input type='checkbox' name='carousel-article-active'    value="n" <?php if(isset($set_values['carousel_article']['carousel_active']) && ($set_values['carousel_article']['carousel_active'] == 'y')) echo 'checked=checked'; ?>  style="width: 5%; display: inline; height: auto; border: none;"/>
										</span>
										<div class="carousel-data" style="display:<?php echo (isset($set_values['carousel_article']['carousel_active']) && ($set_values['carousel_article']['carousel_active'] == 'y'))?  'block' : 'none'; ?>" >
											<label>Fill the following requirement for article's carousel feature</label>
											<span><input class='no-validation'  type='text' name='carousel-article-description' value='<?php echo  isset($set_values['carousel_article']['description'])? $set_values['carousel_article']['description'] : ''; ?>' placeholder=' Enter a brief of your article here'/></span>
											<span><input class='no-validation' id="picker" type='text' name='carousel-article-description-color' value='<?php echo   isset($set_values['carousel_article']['description_color'])? $set_values['carousel_article']['description_color'] : ''; ?>' placeholder='description color'/></span>
											<span><input class='no-validation' id="picker" type='text' name='carousel-article-title-color' value='<?php echo  isset( $set_values['carousel_article']['title_color'])?  $set_values['carousel_article']['title_color'] : ''; ?>' placeholder='title color'/></span>
											<span><input class='no-validation' id="picker" type='text' name='carousel-article-link-color' value='<?php  echo  isset($set_values['carousel_article']['link_color'])? $set_values['carousel_article']['link_color'] : ''; ?>' placeholder='link color'/></span>
										</div>
										<label>Article Thumbnail</label>
										<span><input type='file' name='thumbnail' value="<?php echo isset($thumbnail)? $thumbnail : '';?>" /><span>
											<label>Article Thumbnail Alt</label><span>
											<input type='text' name='thumbnail_alt' value="<?php echo isset($thumbnail_alt)? $thumbnail_alt : ''; ?>"
											/><span>
											<!-- store the article id in a hidden input field -->
											<span><input type='submit' value='Add'  style='width: 15%; float:right;'  <?php if(isset($add_success_status)) echo 'disabled=disabled'; ?> />
												<input  type='reset' value='Rest'   style='width: 15%; float:right;'/>
											</span>
										</form>
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
					if($(this).attr('type') == "file" || $(this).attr('class') == 'no-validation')
						return false;
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

	</script>



	<script type="text/javascript">
	/*********************************************************
	*		Ajax call to server that returned a slug of a text *
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
<script type="text/javascript" src='<?php echo base_url('asset/js/cms/add_article.js') ?>'></script>




<script type="text/javascript">
	// $inputs = $('span').find('input#picker');
	// $inputs.each(function(){
	// 	$this = $(this);
	// 	$this.colpick({
	// 		layout:'hex',
	// 		submit:0,
	// 		colorScheme:'light',
	// 		onChange:function(hsb,hex,rgb,el,bySetColor) {
	// 			$(el).css('border-color','#'+hex);
	// 		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
	// 		if(!bySetColor) $(el).val(hex);
	// 	}
	// 	}).keyup(function(){
	// 		$(this).colpickSetColor(this.value);
	// 	});
	// })
</script>



</body>
</html>