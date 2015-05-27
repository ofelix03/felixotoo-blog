<div class="inner-wrapper" >
	<div class="inner-left" style="position: relative;">
		<div class="loader-container">
			<img src="<?php echo base_url('asset/img/cms/ajax_loader5.gif'); ?>" height="30" width="30">
			<p class="caption">LOADING</p>
		</div>
		<!--breadcrumb -->
		<div class="breadcrumb" style="border-bottom:1px solid #f0f1f2">
			<h2>Articles</h2>
			<p>
				<span><a href="<?php echo site_url('articles');?>">articles</a></span>
				<?php if($breadcrumb): ?>
					<span><?php echo $breadcrumb; ?></span>
				<?php endif;?>
			</p>
		</div>
		<!--/breadcrumb --> 

		<!-- Article List -->
		<?php
		if($articles) :
			foreach($articles as $article):
				$article_id = $article['id'];
				$article_auth = stripslashes( $article['name']);
				$article_auth_id = $article['auth_id'];
				$article_pub_date = justDate( $article['pub_date']);
				$article_title = stripslashes($article['title']);
				$article_message = html_entity_decode( $article['message']);
				$article_pic = $article['thumb_name'];
				$article_pic_alt = $article['img_alt'];
				$article_tags = array_map('trim', explode(',', $article['tags']));
				$article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;
				$article_slug = $article['slug'];
			

		?>

			<article class='full-article' style="position: relative;">
				<div  class="prevBtn" style="display: <?php echo ($prev_article_slug)? 'block' : 'none'; ?>"><a href="<?php echo site_url('article').'/'.$prev_article_slug; ?>"  ><img src="<?php echo base_url('asset/img/cms/caret_left.png');?>"><span class="prevTitle"><?php echo  $prev_article_title; ?></span></a>
				</div>
				<div class="nextBtn" style="display: <?php echo ($next_article_slug)? 'block' : 'none'; ?>"><a href="<?php echo site_url('article').'/'.$next_article_slug;  ?>"><span class='nextTitle'><?php echo  $next_article_title; ?></span><img src="<?php echo base_url('asset/img/cms/caret_right.png');?>"></a></div>
				<header><h1><?php echo $article_title; ?></h1></header>
				<div class="header-meta"><span><i class="fa fa-clock-o"></i>&nbsp;<?php echo getDaysRemaining( $article_pub_date);?> &nbsp;</span>
					<span><i class='fa fa-user'></i><a href='<?php echo site_url('author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a></span>
					<span class="comments">&nbsp;<i class='fa fa-comment'></i><a href="<?php echo site_url('article').'/'.$article_slug.'#disqus_thread'; ?>" ></a> </span>
				</div>
				<?php if($article_pic !== '') : ?>
					<img class="full-article-img" src="<?php echo $article_path; ?>"  alt="<?php echo $article_pic_alt; ?>" />
				<?php endif;  ?>
				<div class="sharing-buttons" style="<?php echo empty($article_pic)? "float : none; width: 90%; display: block; margin: 0px auto; " : ""; ?>">
					<div style="<?php echo empty($article_pic)? "display: inline-block;" : ""; ?>">Share Page</div>
					<div style="<?php echo empty($article_pic)? "display: inline-block;" : ""; ?>"><a id='twitter-popup' href="https://twitter.com/share?text=<?php echo $article_title;?>&via=ofelix03" class="twitter" ><i class="fa fa-twitter" id="twitter-hidden-icon"></i><i class="fa fa-twitter "></i><span>Tweet</span></a></div>
					<div style="<?php echo empty($article_pic)? "display: inline-block;" : ""; ?>"><a href="#" class="facebook"><i class="fa fa-facebook" id="facebook-hidden-icon"></i><i class="fa fa-facebook "></i><span>Facebook</span></a></div>
					<div style="<?php echo empty($article_pic)? "display: inline-block;" : ""; ?>"><a id='google-popup' class="google-plus" href="https://plus.google.com/share?url=<?php echo site_url('articles/').'/'.$article_slug; ?>"><i class="fa fa-google-plus"></i><span>Google+</span></a></div>
			</div>
				<p class="clear"></p>
				<div id='message'><?php echo $article_message; ?></div>
				<p class="clear"></p>
				<ul class="article-tags">
					<?php foreach($article_tags as $tag): ?>
						<li><a href="<?php echo site_url('article/tags').'/'.$tag; ?>"><?php echo $tag; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<p class="clear"></p>
			</article>
			<?php
			endforeach;
			else:
				echo "<p class='warning'>No data found</p>";
			endif;?>

			<!-- End of Article List -->
			<?php if($related_articles): ?>
				<div class="related-articles box" >
					<h2 style="margin-bottom: 20px;">Related Articles</h2>
					<?php 
					foreach($related_articles as $article):
						$article_title = stripslashes($article['title']);
						$article_pub_date = $article['pub_date'];
						$author_name = stripslashes($article['name']);
						$auth_id = $article['id'];
						$bg_img = base_url('asset/img/article_thumbnails').'/'.$article['thumb_name'];
					?>
						<div class="thumbnail">
							<header ><span><?php echo getDaysRemaining( $article_pub_date );?></span><span><a href="<?php echo site_url('author').'/'.$auth_id; ?>"><?php echo $author_name;?></a></span></header>
							<section class="body" style="background-image: url(<?php echo $bg_img; ?>); background-size : 100%  100%; background-repeat: no-repeat;">
								<div class="bg-color" style="background-color: #f5f5f5; opacity: 0.8; border-radius: 2px;"><h4><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE); ?>"><?php echo $article_title; ?></a></h4></div>
							</section>
							<div class="author-pic"><img src="<?php echo base_url('asset/img/authors_thumbs/felix.jpg'); ?>" /></div>
						</div>
					<?php endforeach; ?> 
					<p class="clear"></p>

					<!-- markup for mobile and tablet view -->
					<ul class="viewport-not-desktop">
						<?php 
						foreach($related_articles as $article):
							$article_title = $article['title'];
						?>
							<li><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE); ?>"><?php echo $article_title; ?></a></li>
						<?php  endforeach; ?>
					<ul>
				</div>
			<?php endif;?><!-- /Related Articles -->

			<!-- disqus here -->
			<div id="disqus_thread" style="background-color: #fff; padding: 20px;"></div>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			<!-- disqus ends here -->
		</div><!-- /inner-left -->
		<?php include 'sidebar.php'; ?>
		<p class="clear"></p>
	</div>
</div><!-- /container -->
<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/plugins/prism.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/plugins/page_sharing.js'); ?>"></script>
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
<script type="text/javascript">
  	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'ofel'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
    	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    	dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
    	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>


<script type="text/javascript">
/** JS for setting float to "none" for all imgs when viewport <= 600px **/
	// var $imgs = $('#message').find('img');
	// var view_port = $(window).innerWidth();
	// if(view_port <= 600)
	// {
	// 	$imgs.each(function(){
	// 		$this = $(this);
	// 		//change float to none
	// 		$this.css('float', 'none');
	// 	});
	// }
</script>


<script type="text/javascript">
// $links = $('.inner-left').find('a');
// $links.each(function(){
// 	$this = $(this);
// 	if($this.attr('href').search('localhost') == -1)
// 	{
// 		console.log($this.append("<i class='fa fa-external-link'></i>&nbsp;"));
// 	}

// })

</script>