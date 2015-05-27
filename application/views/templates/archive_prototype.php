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
				<!-- <form action="<?php echo site_url('articles/archive'); ?>" method="get" class="breadcrumb-form" style="display: inline;">
                      <input type='text' name='pub-date' value='' placeholder='<?php echo $breadcrumb;?>'>
			    </form> -->
				</p>
			</div>
			<style type="text/css">
			div.archive-outer-container{
				display: block;
				margin-top: 20px;
			}
            div.archive-outer-container .archive-meter{
            	border: 1px solid #f6f6f6;
            	height: 300px;
            	width: 15%;
            	overflow: scroll;
            	float: left;
            }

            div.archive-outer-container .archive-meter ul{
            	min-height : auto;
            	display: block;
            	margin : 0px;
            	padding: 0px;
            }

            div.archive-outer-container .archive-meter ul li{
            	display: block;
                border-bottom: 1px solid #ddd;
                padding: 10px;

            }
            div.archive-outer-container .archive-meter ul li a{
            	display: block;
            	text-align :center;
            	text-decoration: none;
            	font-size: 22px;
            	line-height:48px;

            }

            div.archive-outer-container .archive-content{
            	border: 1px solid blue;
            	float: left;
            	width: 80%;
            	height: 30%;
            	margin-left: 10px;
            }


			</style>
			<div class="archive-outer-container">
				<div class="archive-meter">
					<ul>
						<li><a href="">2014</a></li>
						<li><a href="">2013</a></li>
						<li><a href="">2012</a></li>
						<li><a href="">2011</a></li>
					</ul>

				</div>
				<div class="archive-content">
				<?php 
				if(isset($archives) && is_array($archives)) :
					$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

					foreach($archives as $index => $month):
						$index = 11 - $index;
				?>
				<h3><?php echo $months[$index]; ?></h3>

				<!-- -->
				<div class="related-articles box" >
					<?php 
					foreach($month as $article):
						if(count($article) == 0)
						{
							continue;
						}

						$article_title = $article['title'];
						$article_pub_date = $article['pub_date'];
						$author_name = $article['name'];
						$auth_id = $article['id'];
						$bg_img = base_url('asset/img/article_thumbnails').'/'.$article['thumb_name'];
					?>
					<div class="thumbnail">
						<header ><span><?php echo $article_pub_date;?></span><span><a href="<?php echo site_url('authors/author').'/'.$auth_id; ?>"><?php echo $author_name;?></a></span></header>
						<section class="body" style="background-image: url(<?php echo $bg_img; ?>); background-size : 100%  100%; background-repeat: no-repeat;">
							<div class="bg-color" style="background-color: #f5f5f5; opacity: 0.8; border-radius: 2px;"><h4><a href="<?php echo site_url('articles').'/'.url_title($article_title, '-', TRUE); ?>"><?php echo $article_title; ?></a></h4></div>
						</section>
						<div class="author-pic"><img src="<?php echo base_url('asset/img/authors_thumbs/felix.jpg'); ?>" /></div>
					</div>
				<?php endforeach; ?> 
				<p class="clear"></p><div class="related-articles box" >
					
			</div>



				<!-- -->





				<?php 
					endforeach;
				endif;?>
				</div>
					

				<p class="clear"></p>

			</div>
		<!--/breadcrumb --> 

		
			
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








