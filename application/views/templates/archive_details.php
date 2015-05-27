 		<div class="inner-wrapper">
		<div class="inner-left">
			<!--breadcrumb -->
			<style type="text/css">
                .breadcrumb-form input[placeholder]{
                	border: 1px solid red;
                	font-size: 12px;
                	color: red;
                	width: 50%;
                }

			</style>
			<div class="breadcrumb">
				<h2>Archived Articles</h2>
				<p>
					<!-- <span><a href="<?php echo site_url('articles');?>">articles</a></span> -->
				<?php if(isset($breadcrumb)) : ?>
					<!-- <span><?php echo $breadcrumb; ?></span> -->
				<?php endif; ?>
				<form action="<?php echo site_url('articles/archive'); ?>" method="get" class="breadcrumb-form" style="display: inline;">
                      <input type='text' name='pub-date' value='' placeholder='<?php echo $breadcrumb;?>'>
			    </form>
				</p>
			</div>
		<!--/breadcrumb --> 

		<?php
		if(isset($articles) && is_array($articles)) :
			echo isset($pagination)? $pagination : '';

			foreach($articles as $article):
				$article_id = $article['id'];
				$article_auth = $article['name'];
				$article_auth_id = $article['auth_id'];
				$article_pub_date = $article['pub_date'];
				$article_slug = $article['slug'];
				$article_title = $article['title'];
				$article_title_url = url_title($article_title, '-', TRUE);
				$article_message = html_entity_decode($article['summary']);
				$article_pic = $article['thumb_name'];
				$article_pic_alt = $article['img_alt'];
				$article_tags = array_map('trim', explode(',', $article['tags']));
				$article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;

				
			?>
 
			<article>
				<header><h1><a href="<?php echo site_url('articles/page').'/'.$article_slug; ?>"><?php echo $article_title; ?></a></h1></header>
				<div class="header-meta"><span><i class="fa fa-clock-o "></i>&nbsp;<?php echo $article_pub_date;?> &nbsp;</span>
						                     <span><i class='fa fa-user'></i><a href='<?php echo site_url('authors/author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a></span>
							                 <span>&nbsp;<i class='fa fa-comment'></i><a href="<?php echo site_url('articles/page').'/'.url_title($article_title, '-', TRUE).'#disqus_thread'; ?>"></a> </span></div>
				<?php if($article_pic !== ''):  ?>
					<a href="<?php echo site_url('articles/page').'/'.$article_slug; ?>"> <img class="article-img" src="<?php echo $article_path; ?>"  alt="<?php echo $article_pic_alt; ?>" /></a>
				<?php endif; ?>
				<div id="summary"><?php echo $article_message; ?></div>
       			<span class="more-btn"><a href="<?php echo site_url('articles/page').'/'.$article_slug;?>">Continue reading <i class="fa fa-long-arrow-right"></i></a></span>
				<p class="clear"></p>
				<ul class="article-tags">
					<?php foreach($article_tags as $tag): ?>
					<li><a href="<?php echo site_url('articles/list_articles').'/'.url_title($tag); ?>"><?php echo url_title($tag); ?></a></li>
					<?php endforeach; ?>
				</ul>

			<style type="text/css">
				.pluginButtonContainer{
					display: inline;
					line-height: 10px;
				}

				.pluginButtonContainer a{
					border: 1px solid red;
				}


			</style>
			<p style='display: block; padding: 2px 0px; background-color: #f5f5f5; box-size: content-box; font-weight: normal; padding-left: 10px;'>Share Page : &nbsp;&nbsp;
				<span><a href="https://twitter.com/share?url=<?php echo site_url('articles/page'); ?>" class="twitter-share-button" data-lang="en">Tweet</a></span>
			</p>

			

			<!-- Twitter share js -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

			<!-- ends here -->


			

			<p class="clear"></p>
		</article>
		<?php
		endforeach; ?>
		<?php else: ?>
			<p class='warning'><?php echo isset($warning_message)? $warning_message : ' No Data Found'; ?></p>
		<?php endif; ?>
	     <?php echo isset($pagination)? $pagination : ''; ?>

       <!-- Related Articles -->
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

			
		</div><!-- /inner-left -->

		<div class="inner-right">
				<div class="top-section">
					<div class="box wise-saying">
						<h3>Widsom Dose for Today</h3>
					<h5><span class="red">''</span><?php echo isset($wisdom_dose)? $wisdom_dose : "";?></h5>
					</div>

					<article class="box">
						<h3>Latest Article </h3>
						<?php if($latest_article_headlines) :?>
							<ul>
								<?php foreach($latest_article_headlines as $headline):
									$headline_title = $headline['title'];
								?>
								<li><a href="<?php echo site_url('articles/page').'/'.url_title(strtolower($headline_title));?>"><?php echo $headline_title; ?></a></li>
								<?php endforeach?>
							</ul>

						<?php endif; ?>
					</article>
					
				</div>


				<div class="box bottom-section">
					<h3>Happenings in the Tech World</h3>
					<ul>
						<li><a href="#">Google develope a 'new' microprocessor ...</a></li>
						<li><a href="#">Yahoo sues Microsoft over copyright issues ... </a></li>
						<li><a href="#">Youngest Billionaires in the IT world...</a></li>
						<li><a href="#">Time with the young prodigy who ....</a></li>
					</ul>


								
				</div>


				<div class="box">
                     <h3>Tweets</h3>
                     <ul>
						<li><a href="#">Google develope a 'new' microprocessor ...</a></li>
						<li><a href="#">Yahoo sues Microsoft over copyright issues ... </a></li>
						<li><a href="#">Youngest Billionaires in the IT world...</a></li>
						<li><a href="#">Time with the young prodigy who ....</a></li>
					</ul>
				</div>

				<div class="box">
					<h3  class="h3">Archive</h3>
					<ul class="archive">
						<?php if($archiveYears):
						         foreach($archiveYears as $year):
						?>
						<li><a href="#" data-year="<?php echo $year;?>"><?php echo $year;?></a>
						</li>
						<?php endforeach; endif;?>
					</ul>
				</div>



				<div class="box">
                     <h3>Quick Links</h3>
                     <ul>
                         <li><a href="#">Home</a></li>
                         <li><a href="#">About Me</a></li>
                         <li><a href="#">Articles</a></li>
                         <li><a href="#">Portfolio</a></li>

                     </ul>
				</div>


				<p class="clear"></p>
			</div>
			<p class="clear"></p>
		</div>
	</div><!-- /container -->








