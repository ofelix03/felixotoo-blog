	<div class="inner-wrapper" data-spy="scroll" data-target=".navigation">
		<div class="inner-left">
			<!--breadcrumb -->
				<div class="breadcrumb" style="border-bottom:1px solid #f0f1f2">
				<h2>Search</h2>
					<p><span>&nbsp;<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></span></p>
			</div>
			<!--/breadcrumb -->
			<div class="profile-section box">
				<?php
				  if(isset($author) && $author != false):
					$attributes = $author;
					$id = $attributes['id'];
					$name = $attributes['name'];
					$age = $attributes['age'];
					$sex = strtoupper(substr(strtolower($attributes['sex']), 0, 1)).substr(strtolower($attributes['sex']), 1, 6);
					$in_brief = $attributes['in_brief'];
					$profession= $attributes['profession'];
					$thumb = ($attributes['auth_thumb'])? $attributes['auth_thumb'] : 'image_unavailable.jpg';
					$social_networks = (!empty($attributes['social_networks']))?  explode(',', $attributes['social_networks']) : 'N/A';
					$websites = (!empty($attributes['websites']))? $attributes['websites'] : 'N/A';
					$current_auth_id = $id;
				?>
				<img src="<?php echo base_url('asset/img/authors_thumbs').'/'.$thumb;?>"  alt="pic here" >
				<div class='profile-attributes'>
					<div><h4>Name</h4></div>
				    <div><?php echo $name?></div>
					<div><h4>Age</h4></div>
					<div><?php echo $age?></div>
					<div><h4>Sex</h4></div>
					<div><?php echo $sex?></div>
					<div><h4>Profession</h4></div>
					<div><?php echo $profession?></div>
					<div><h4>Websites</h4></div>
					<div><?php echo $websites;?></div>
					<div><h4>Brief from Me</h4></div>
					<div><?php echo $in_brief; ?></div>
					<div><h4>Social Netowrks</h4></div>
					<div>
						<?php if(is_array($social_networks)):
						 foreach($social_networks as $url): 
							$network = getSocialNetwork($url);
						?>
							<a href="<?php echo 'http://'.$url; ?>"><?php echo $network; ?></a>&nbsp;
						<?php endforeach;endif;?>
					</div>
				    <div><h4>Contributions</h4></div>
					<div>
						<ul>
						<?php 
						if($auth_article_titles):
						foreach($auth_article_titles as  $index => $title) : 
						?>
							<li><a href="<?php echo site_url('articles').'/'.url_title(strtolower($title['title']));?>"><?php echo $title['title'];?></a></li>
						<?php 
						endforeach; 
						else : ?>
						<li>No contributions found</li>
						<?php endif; ?>
						<?php if(count($auth_article_titles) > 3): ?>
							<li style='float: right; list-style: none; margin-top: 5px;'><a href="<?php echo site_url('author').'/'.$id.'/articles'; ?>">View All...</a></li>
						<?php endif; ?>
						</ul>
					</div>
				</div>
			<?php else: ?>
				<p class="warning">No author found with the given ID.</p>
			<?php endif; ?>
				<p class="clear"></p>
				<div class="authors" >
					<!-- Other Authors Section -->
					<h2>Other Authors</h2>
					<?php if(isset($other_authors) && is_array($other_authors)) : ?>
					<ul>
						<?php foreach($other_authors as $author): 
							$a_name = $author['name'];
							$a_id = $author['id'];
							$a_thumb = ($author['auth_thumb'])?  $author['auth_thumb'] : 'image_unavailable.jpg';
							$a_profession = substr($author['profession'], 0, 45);
							if(isset($current_auth_id) && $current_auth_id ==$a_id)
								continue;
						?>
							<li class="author"><img src="<?php echo base_url('asset/img/authors_thumbs').'/'.$a_thumb; ?>" width='100' height='100' >
								<a href="<?php echo site_url('author').'/'.$a_id; ?>">
									<ul class="details">
										<li class="name"> <i class='fa fa-user'></i>&nbsp;<?php echo $a_name?></i></li>
										<li class="profession" style="padding-left: 10px;"><?php echo $a_profession;?></li>
										<li class='article_list_icon'><a title='Contributions' href="<?php echo site_url('author').'/'.$a_id. '/articles'; ?>"><i class='fa fa-book'></i>&nbsp;<?php echo $articles_count[$a_id]; ?></a></li>
									</ul>
								</a>
							</li>
						<?php endforeach; endif;?>
						<p class="clear"></p>
					</ul>			
					<p class="clear"></p>
				</div>
			</div>
		</div><!-- /inner-left -->
		<?php include 'sidebar.php'; ?>
		<p class="clear"></p>
	</div><!-- /inner-wrapper -->
</div><!-- /container -->








