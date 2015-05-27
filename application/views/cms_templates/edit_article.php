
<div class="content-box">
	<div class="head"><h3>Edit Article</h3></div>
	<?php if (isset($js_run) )
	echo $js_run;

	?>
	<div class="content">
		<?php if($article_details) : ?>
		<?php echo form_open_multipart('cms/edit_article', array('id' => 'ofelix')); ?>

		<div class="left" style="position : relative;">
		<?php if(isset($edit_success_status)): ?>
			    <div class="new-note-btn" style="position: absolute; right:-2%; top: -2%; border:1px solid #f0f1f2; background: #fff; border-radius: 50%; padding: 14px 16px;">
			    <a href="<?php echo site_url("cms/edit_article").'/'.$article_details['id']; ?>" title="Edit"><i class='fa fa-file-o fa-2x'></i></a>
			    </div>
			<?php endif;?>
			<h4>Article Details</h4>
			<?php if(isset($edit_success_status)): ?>
			<p class='success'><?php echo $edit_success_status; ?></p>
		<?php elseif(isset($edit_fail_status)) : ?>
			<p class='warning'><?php echo $edit_fail_status; ?></p>
	<?php endif;?>
	<?php
	$article_author = isset($article_details['name'])? stripslashes($article_details['name']) : $_SESSION['fullname'];
	$article_id = isset($article_id)? $article_id : $_SESSION['user_id'];
	$article_title = isset($article_details['title'])?  stripslashes($article_details['title'] ): '';
	$article_summary = isset($article_details['summary'])? $article_details['summary'] : '';
	$article_message = isset($article_details['message'])? $article_details['message'] : '';
	$article_slug = isset( $article_details['slug'])?  $article_details['slug'] : '';
	$article_tags =  isset($article_details['tags'])? $article_details['tags'] : '';
	$article_thumbnail = isset( $article_details['thumb_name'])?  $article_details['thumb_name'] : '';
	$article_thumbnail_width = isset( $article_details['thumb_width'])?  $article_details['thumb_width'] : 'n/a';
	$article_thumbnail_height = isset($article_details['thumb_height'])? $article_details['thumb_height'] : 'n/a';
	$article_thumbnail_file_size = isset($article_details['thumb_size'])? $article_details['thumb_size'] : 'n/a';
	$article_thumbnail_mime = isset( $article_details['thumb_mime'])?  $article_details['thumb_mime'] : 'n/a';
	$article_thumbnail_alt =  isset($article_details['img_alt'])? $article_details['img_alt'] : '';
	$article_thumbnail_path = base_url('asset/img/article_thumbnails').'/'.$article_thumbnail;
	$article_publish_date = $article_details['pub_date'];
	$article_pub_status = $article_details['pub_status'];
	$article_last_modified = isset($article_details['last_modified']) && ($article_details['last_modified'] != null)? $article_details['last_modified'] : 'n/a';
	?>
	<label>Author</label>
	<span><input type='text' name='author' disabled='disabled' value='<?php echo stripslashes($_SESSION['fullname']); ?>'/><span>
	<label>Title</label>
	<span><input type='text' name="title" value="<?php echo $article_title?>"  class="<?php echo isset($warning['title'])? 'warning' : ''; ?>"/><span>
	<label>Summary</label>
	<span><textarea name='summary' cols='5' rows='5'   class="<?php echo isset($warning['summary'])? 'warning' : ''; ?>"><?php echo $article_summary; ?></textarea><span>
	<label>Message</label>
	<span><textarea name='message' cols='5' rows='7'   class="<?php echo isset($warning['message'])? 'warning' : ''; ?>"><?php echo $article_message; ?></textarea><span>
	<label>Slug</label>
	<span><input type='text' name='slug' value='<?php echo $article_slug;?>'/><span>
				<label>Tags</label>
				<span><input type='text' name='tags' value='<?php echo $article_tags; ?>'  class="<?php echo isset($warning['tags'])? 'warning' : ''; ?>"/><span>
					<label>Published</label>
					<span style='margin-left: 15px;' class='published-radiobox'>
						<input  type='radio'   name='pub_status' value='pub' <?php echo ($article_pub_status == 1)? "checked=checked" :  "";?> style="width: 5%; display: inline; height: auto; border: none;" /> Yes&nbsp;&nbsp;
						<input  type='radio'   name='pub_status' value='unpub'  <?php echo ($article_pub_status == 0)? "checked=checked" :  "";?>  style="width: 5%; display: inline; height: auto; border: none;" /> No 
					</span>
					<label>Publish Date</label>
					<span><input type='text' name='pub_date'    value="<?php echo $article_publish_date; ?>"  class="<?php echo isset($warning['pub_date'])? 'warning' : ''; ?>"/></span>
					<span>
						<label style="display:inline-block;">Feature article on carousel</label>
						<input type='checkbox' name='carousel-article-active'    value="<?php echo (isset($set_values['carousel_article']['active']) && ($set_values['carousel_article']['active'] == 'y'))? 'y' : 'n'; ?>" <?php if(isset($set_values['carousel_article']['active']) && ($set_values['carousel_article']['active'] == 'y')) echo 'checked=checked'; ?>  style="width: 5%; display: inline; height: auto; border: none;"/>
					</span>
					<div class="carousel-data" style="display:<?php echo (isset($set_values['carousel_article']['carousel_active']) && ($set_values['carousel_article']['carousel_active'] == 'y'))?  'block' : 'none'; ?>" >
						<label>Fill the following requirement for article's carousel feature</label>
						<span><input class='no-validation'  type='text' name='carousel-article-description' value='<?php echo  isset($set_values['carousel_article']['description'])? $set_values['carousel_article']['description'] : ''; ?>' placeholder=' Enter a brief of your article here'/></span>
						<span><input class='no-validation' id="picker" type='text' name='carousel-article-description-color' value='<?php echo   isset($set_values['carousel_article']['description_color'])? $set_values['carousel_article']['description_color'] : ''; ?>' placeholder='description color'/></span>
						<span><input class='no-validation' id="picker" type='text' name='carousel-article-title-color' value='<?php echo  isset( $set_values['carousel_article']['title_color'])?  $set_values['carousel_article']['title_color'] : ''; ?>' placeholder='title color'/></span>
						<span><input class='no-validation' id="picker" type='text' name='carousel-article-link-color' value='<?php  echo  isset($set_values['carousel_article']['link_color'])? $set_values['carousel_article']['link_color'] : ''; ?>' placeholder='link color'/></span>
					</div>				
					<label>Last Modified Date</label>
					<span><input type='text' name='last-modified' disabled='disabled' value="<?php echo $article_last_modified; ?>" /></span>
					<!-- store the article id in a hidden input field -->
					<input type='hidden' name='article_id' value='<?php echo $article_id; ?>' />
					<span>
						<input style='width: 15%; float:right;' type='submit' value='Edit' />
						<input style='width: 15%; float:right;' type='reset' value='Reset' />
					</span>
				</div>

				<div class="right">
					<h4>Article Thumbnail Details</h4>

					<div class="thumbnail">
						<img src="<?php echo $article_thumbnail_path; ?>" />
					</div>

					<div class="thumbnail-details">
						<label>File Name</label><span><?php echo isset($article_thumbnail) && !empty($article_thumbnail)? $article_thumbnail : 'n/a'; ?></span>
						<label>Dimension</label><span><?php echo isset($article_thumbnail_width) && isset($article_thumbnail_height) && ($article_thumbnail_width != 0) && ($article_thumbnail_height != 0)? $article_thumbnail_width .' * '. $article_thumbnail_height : 'n/a'; ?></span>
						<label>File Type</label><span><?php echo isset($article_thumbnail_mime)? $article_thumbnail_mime : 'n/a'; ?></span>

						<p><label>Image alt</label>&nbsp; <input type='text' name = 'thumbnail_alt' value='<?php echo isset($article_thumbnail_alt)? $article_thumbnail_alt : ''; ?>' /></p>
						<?php if(empty($article_thumbnail)):?>
						<p style='font-size: 13px;'>No thumbnail attached to article.</p>
						<p><input  style='display: none;' type='file' name='thumbnail' /><a style='text-decoration: none;'  class='upload-thumbnail' href="#">Upload thumbnail</a></p> 


					<?php else :?>
					<p><input  style='display: none;' type='file' name='thumbnail' value="<?php $article_thumbnail; ?>"/><a style='text-decoration: none;'  class='upload-thumbnail' href="#">Change thumbnail</a></p> 
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
	<script type="text/javascript" src='<?php echo base_url('asset/js/cms/colpick_cust.js') ?>'></script>
<script type="text/javascript" src='<?php echo base_url('asset/js/cms/add_article.js') ?>'></script>

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
					if($this.attr('type') == 'radio')
						return false;
					if($this.val() != '')
					{
						//detach the warning class form the input
						$this.attr('style', '');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('style', 'border: 1px solid red');
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
						$this.attr('style', '');
					}
					else
					{
						//attach the warning class to the input
						$this.attr('style','border: 1px solid red');
					}
				})
			})
		})


		$(function(){
			var $form = $('form');
			var $pub_date_field = $form.find("input[name='pub_date']");
			console.log($pub_date_field);
			$form.find('input[type="radio"]').click(function(){
				$this = $(this);
				if($this.attr('name') == "pub_status" && $this.val() == "pub")
					$pub_date_field.attr('placeholder', 'Date would be setted automatically');

			})
		})
		</script>

	</body>
	</html>