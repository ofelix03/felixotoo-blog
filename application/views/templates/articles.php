<div class="inner-wrapper">
	<div class="inner-left">
		<!--breadcrumb -->
		<div class="breadcrumb" style="border-bottom:1px solid #f0f1f2">
			<h2>Articles</h2>
			<p>
				<span><a href="<?php echo site_url('articles');?>">articles</a></span>
			</p>
		</div>
		<!--/breadcrumb --> 
		<article class="pagination"> <?php echo isset($pagination)? $pagination : ''; ?></article>
		<?php
		if(isset($articles) && is_array($articles)) :
		foreach($articles as $index => $article):
			$article_id = $article['id'];
			$article_auth = stripslashes( $article['name'] );
			$article_auth_id = $article['auth_id'];
			$article_pub_date = justDate($article['pub_date']);
			$article_slug = $article['slug'];
			$article_title =  stripslashes( $article['title'] );
			$article_title_url = url_title($article_title, '-', TRUE);
			$article_message = html_entity_decode($article['summary']);
			$article_pic = $article['thumb_name'];
			$article_pic_alt = $article['img_alt'];
			$article_tags = array_map('trim', explode(',', $article['tags']));
			$article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;
			// humandReadableTimestamp($article_pub_date);
		?>
		<article>
			<header><h1><a href="<?php echo site_url('article').'/'.$article_slug; ?>"><?php echo $article_title; ?></a></h1></header>
			<div class="header-meta"><span><i class="fa fa-clock-o "></i>&nbsp;<?php echo getDaysRemaining($article_pub_date);?> &nbsp;</span>
				<span><i class='fa fa-user'></i><a href='<?php echo site_url('author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a></span>
				<span class="comments">&nbsp;<i class='fa fa-comment'></i><a href="<?php echo site_url('article').'/'.$article_slug.'#disqus_thread'; ?>" ></a> </span>
			</div>
			<?php if($article_pic !== ''):  ?>
			<a href="<?php echo site_url('article').'/'.$article_slug; ?>"> <img class="article-img" src="<?php echo $article_path; ?>"  alt="<?php echo $article_pic_alt; ?>" /></a>
		<?php endif; ?>
		<div id="summary"><?php echo $article_message; ?></div>
		<span class="more-btn"><a href="<?php echo site_url('article').'/'.$article_slug;?>">Continue reading <i class="fa fa-long-arrow-right"></i></a></span>
		<p class="clear"></p>
		<ul class="article-tags">
			<!-- <li><p>Related Tags : </p></li> -->
			<?php foreach($article_tags as $tag): ?>
				<li><a href="<?php echo site_url('article/tag').'/'.url_title($tag); ?>"><?php echo url_title($tag); ?></a></li>
			<?php endforeach; ?>
		</ul>

		<p class="clear"></p>
		</article>
		<?php endforeach;
				else: 
			echo "<p class='warning'> Ooh! Sorry we couldn't any articles for you this moment. Try Again. Check in again later.</p>";
		endif;?>
		<article class="pagination"> <?php echo isset($pagination)? $pagination : ''; ?></article>

	</div><!-- /inner-left -->

	<?php include 'sidebar.php'; ?>
	<p class="clear"></p>
	</div>
</div><!-- /container -->

<script type="text/javascript" src="<?php echo base_url('asset/js/plugins/prism.js'); ?>"></script>
<script type="text/javascript">
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'ofel'; // required: replace example with your forum shortname
	var disqus_title = "<?php echo $article_title; ?>";
	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function () {
		var s = document.createElement('script'); s.async = true;
		s.type = 'text/javascript';
		s.src = '//' + disqus_shortname + '.disqus.com/count.js';
		(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	}());
</script>

