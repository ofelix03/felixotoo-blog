	<div class="inner-wrapper">
		<div class="inner-left">
			<!--breadcrumb -->
			<div class="breadcrumb" style="border-bottom:1px solid #f0f1f2">
				<h2>Search</h2>
					<p><span>&nbsp;<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></span></p>
			</div>
			<!--/breadcrumb -->
			<?php
				if(isset($search_results) && is_array($search_results)) : ?>
					<p  class='success'>Yes! found (&nbsp;<strong><?php echo $returned_num_rows; ?></strong>&nbsp;) article(s) for searched keyword : "&nbsp;<em><?php echo $search_term;?></em>&nbsp;"</p>
			<article class="pagination"><?php echo $pagination;?></article>
			<div class="search-zone">
				<?php
		            // echo $create_pagination;
				    $css_string = "<span style='background-color : #9cf; '>%s</span>";
	               
	                $accepted_keywords = explode(' ', $accepted_keywords);
				    $replace_values = array();
	                foreach($accepted_keywords as $index => $term)
	                 	$replace_values[$index] = sprintf($css_string, $term);
	                 	 				
					foreach($search_results as $article):
						$article_id = $article['id'];
						$article_auth = stripslashes(  $article['name'] );
						$article_auth_id = $article['auth_id'];
						$article_pub_date = $article['pub_date'];
						$article_title =   stripslashes( str_ireplace($accepted_keywords, $replace_values,  $article['title']) );
						$article_message = str_ireplace($accepted_keywords, $replace_values, html_entity_decode($article['summary']));
						$article_pic = $article['thumb_name'];
						$article_pic_alt = $article['img_alt'];
						$article_tags = array_map('trim', explode(',', $article['tags']));
						$article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;
					?>

					<article >
						<header><h1><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE); ?>"><?php echo $article_title; ?></a></span></h1></header>
						<div class="header-meta"><span><i class="fa fa-clock-o "></i>&nbsp;<?php echo getdaysRemaining($article_pub_date) ;?> &nbsp;</span>
						                     <span><i class='fa fa-user'></i><a href='<?php echo site_url('authors/author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a></span>
							                 <span>&nbsp;<i class='fa fa-comment'></i><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE).'#disqus_thread'; ?>"></a> </span>
							             </div>
							<?php if($article_pic !== ''):  ?>
								<a href="<?php  echo site_url('article').'/'.url_title($article_title, '-', TRUE); ?>"> <img class="article-img" src="<?php echo $article_path; ?>"  alt="<?php echo $article_pic_alt; ?>" /></a>
							<?php endif; ?>
							<div id="summary"><?php echo $article_message; ?></div>
	   			            <span class="more-btn"><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE); ?>">Continue reading <i class="fa fa-long-arrow-right"></i></a></span>
							<p class="clear"></p>
							<ul class="article-tags">
								<?php foreach($article_tags as $tag): ?>
									<li><a href="<?php echo site_url('article/tags').'/'.url_title($tag); ?>"><?php echo str_ireplace($accepted_keywords, $replace_values, $tag); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<p class="clear"></p>
					</article>
					<?php endforeach; else: ?>
						<p class='warning'>Oooh! no,  found no article for searched keyword : &nbsp;" <em><?php echo $search_term; ?></em> "</p>
					<?php endif; ?>
					<article class="pagination"><?php echo $pagination;?></article>
			</div>
		</div><!-- /inner-left -->
	     <?php include 'sidebar.php' ?>
		<p class="clear"></p>
	</div>
</div><!-- /container -->

<script type="text/javascript" src="<?php echo base_url('asset/js/plugins/prism.js'); ?>"></script>



