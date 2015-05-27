<div class="inner-right">
	<div class="top-section">
		<div class="box wise-saying">
			<h3>Widsom Dose for Today</h3>
			<h4><i  class="fa fa-quote-left " style="color: #111;"></i><span >&nbsp;<?php echo isset($wisdom_dose)? $wisdom_dose : "";?></span></h4>
		</div>

			<article class="box">
				<h3>Recent Article </h3>
				<?php if($latest_article_headlines) :?>
					<ul>
						<?php foreach($latest_article_headlines as $headline):
							$headline_title = $headline['title'];
						?>
						<li><a href="<?php echo site_url('article').'/'.url_title(strtolower($headline_title));?>"><?php echo $headline_title; ?></a></li>
						<?php endforeach?>
					</ul>

				<?php else: ?>
				 <p style='text-align: center; padding: 20px; color: #777; font-style: italic;'> Ooh! Sorry we are working hard to get you informative contents. Check in again later.</p>
				<?php endif; ?>
			</article>
			<div class="box">
				   <a class="twitter-timeline"  href="https://twitter.com/ofelix03"  width="100%" data-widget-id="565541142432071680" data-link-color="#ff6600" data-chrome="transparent noborders ">Tweets by @ofelix03</a>
		            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
				</div>

		</div>


			<div class="box">
		         <h3>Quick Links</h3>
		         <ul>
		             <li><a href="<?php echo site_url('home');?>">Home</a></li>
		             <li><a href="<?php echo site_url('about');?>">About Me</a></li>
		             <li><a href="<?php echo site_url('articles');?>">Articles</a></li>
		             <li><a href="#">Portfolio</a></li>

		         </ul>
			</div>
			<p class="clear"></p>
		</div>