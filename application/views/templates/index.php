<div class="inner-wrapper">
	<div class="inner-left">
		<div class="carousel">
			<?php
			if(isset($carousel_imgs) && is_array($carousel_imgs)) :
				foreach($carousel_imgs as $img) :
					$image_name = $img['carousel_name'];
					$image_caption = $img['caption'];
					$image_brief = $img['brief'];
					$image_caption_color = $img['caption_color'];
					$image_brief_color  = $img['brief_color'];
					$image_link = $img['link'];
					$image_link_color = $img['link_color'];
							// $background_img = base_url("asset/img/carousel/carousel_heading_bg2.jpg");
					$image_caption_style = 'color :'.$image_caption_color.'; border: 1px dotted '.$image_caption_color.'; border-left: none;';
					$image_brief_style = 'color :'.$image_brief_color.'; border: 1px dotted '.$image_brief_color.'; border-left: none;';;
						// $background_img_width = explode(" ", getimagesize($background_img)[3])[0];

				if($image_brief === ""){
					$image_brief_style  = "";
				}

				?>
				<div class="jumbotron" title="Scroll left or right to see another wallpaper" style="background-image: url('<?php echo base_url('asset/img/carousel').'/'.$image_name;?>');">
					<div><h2 style="<?php echo $image_caption_style;  ?>; font-weight: bold; padding: 12px 10px; "><?php echo  $image_caption;?></h2></div>
					<div><p style="<?php echo $image_brief_style; ?>; " ><?php echo $image_brief;?></p></div>
					<span  class='button' style="<?php if(empty($image_link)) echo 'display: none';?>">
						<a href="<?php echo $image_link;  ?>" style=" color: <?php echo $image_link_color;?>; border-radius: 4px; border: 1px dashed <?php echo $image_link_color;?>"> Read Details </a></span>
				</div>

				<?php endforeach;  else:?>
				<p class="warning">No carousel imgs found.</p>
			<?php endif;?>
		</div><!-- /carousel -->

		
		<article>
			<div class='block'>
				<h1>Welcome</h1>
				<p>This is <strong>ofex.com</strong>, the personal / blog site of <a href="<?php echo site_url('about');?>">Felix Otoo</a>. 
					A playground, where he tries to continually live  his 
					philosophy: <i>"Knowledge is for the world so we share"</i>. So on this site, its all about him sharing what he knows and things that 
					he is learnin daily. Be prepaared for some great stuffs on anything web and a dose of personal stuffs too. So again , you welcome.
					Its time to exploite. Dive in.
				</p>
				

				<ul class="details">
					<li  class="thumbnail" class='btn'>
						<a href="<?php site_url('home'); ?>">
							<div class="img"><i class="fa fa-user"></i></div>
							<div class="text">About Me </div>
						</a>
					</li>
					<li  class="thumbnail" class='btn'>
						<a href="<?php echo site_url('article'); ?>">
							<div class="img"><i class="fa fa-book"></i></div>
							<div class="text">Blog </div>
						</a>
					</li>
					<li  class="thumbnail" class='btn'>
						<a href="#">
							<div class="img"><i class="fa fa-git"></i></div>
							<div class="text">Portfolio </div>
						</a>
					</li>
					<p class="clear"></p>
				</ul>
				<p class="clear"></p>
			</div>
		</article>
	</div><!-- /inner-left -->
	<?php include 'sidebar.php'; ?>
	<p class="clear"></p>
</div>
</div><!-- /container -->


<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/carousel.js'); ?>"></script>