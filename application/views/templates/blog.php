	<style type="text/css">
	 .inner-wrapper .inner-left{
	 	border: 2px solid #111;
	 	float: none;
	 	width: 90%;
	 	margin: 0px auto;
	 }

	 .inner-wrapper .inner-left article h2{
	 	font-size:  40px;
	 }
	</style>


	<div class="inner-wrapper">
		<div class="inner-left">
			<!--breadcrumb -->
			<div class="breadcrumb">
				<h2>Blog</h2>
				
				<p style='font-weight: normal;'>
					<span><a href="<?php echo site_url('articles');?>">article</a></span>
					<?php if(isset($breadcrumb)) : ?>
					<span>Selected Tag : <?php echo $breadcrumb; ?></span>
				<?php endif; ?>
			</p>
		</div>
		<!--/breadcrumb --> 

		<?php 
		echo isset($pagination)? $pagination : ''; ?>
		<?php			
		if(isset($articles) && is_array($articles)) :
			foreach($articles as $article):
				$article_id = $article['id'];
				$article_auth = $article['name'];
				$article_auth_id = $article['auth_id'];
				$article_pub_date = $article['pub_date'];
			
				$article_title = $article['title'];
				$article_title_url = url_title($article_title, '-', TRUE);
				$article_message = $article['summary'];
				$article_pic = $article['thumb_name'];
				$article_pic_alt = $article['img_alt'];
				$article_tags = array_map('trim', explode(',', $article['tags']));
				$article_path = base_url('asset/img/lang-logos').'/'.$article_pic;
			?>
			<article>
				<h2><a href="<?php echo site_url('articles/page').'/'.url_title(htmlspecialchars($article_title), '-', TRUE); ?>"><?php echo $article_title; ?></a>
					<p style="font-size: 12px"><i class="fa fa-book"></i>&nbsp;<?php echo $article_pub_date;?> &nbsp;<i class='fa fa-user'></i> <strong><a href='<?php echo site_url('authors/author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a>
					&nbsp;<a href="<?php echo site_url('articles/page').'/'.url_title($article_title, '-', TRUE).'#disqus_thread'; ?>"></a></strong> </p></h2>
				
				<?php if($article_pic !== ''):  ?>
					<a href="<?php echo site_url('articles/page').'/'.url_title(htmlspecialchars($article_title), '-', TRUE); ?>"> <img src="<?php echo $article_path; ?>" height="200" width="200" alt="<?php echo $article_pic_alt; ?>" /></a>
				<?php endif; ?>

				<?php echo $article_message; ?>
				<span class="button"><a href="<?php echo site_url('articles/page').'/'.url_title($article_title, '-', TRUE); ?>">More ...</a></span>
				<p class="clear"></p>
				<ul class="article-tags">
					<li><p>Related Tags : </p></li>
					<?php foreach($article_tags as $tag): ?>

					<li><a href="<?php echo site_url('articles/list_articles').'/'.url_title($tag); ?>"><?php echo url_title($tag); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<p style='display: block; padding: 8px 0px; background-color: #fff; box-size: content-box; font-weight: bold; padding-left: 10px;'>Share Page : &nbsp;&nbsp;
				<span><a href="https://twitter.com/share?url=<?php echo site_url('articles/page').'/'.$article_title_url; ?>" class="twitter-share-button" data-lang="en">Tweet</a></span>
			</p>

			<!-- Twitter share js -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


			<!-- ends here -->


			<p class="clear"></p>
		</article>
		<?php
		endforeach;
		else:
			echo "<p class='warning'>No data found</p>";
		endif;
		?>

		<?php if(isset($related_articles)): ?>
		<article>
			<h2>Related Articles</h2>
			<ul>
				<?php	foreach($related_articles as $article):
				$article_title = $article['title'];
				?>
				<li><a href="<?php echo site_url('articles/page').'/'.url_title($article_title, '-', TRUE); ?>"><?php echo $article_title; ?></a></li>
				<?php  
				endforeach;
				?>
				<ul>
				</article>
			<?php	endif; ?>

			<!-- pagination here -->
			<?php  echo isset($pagination)? $pagination : ''; ?>
			<!-- pagination ends here -->
		</div><!-- /inner-left -->

		<p class="clear"></p>
	</div>
</div><!-- /container -->


