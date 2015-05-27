
<div class="inner-wrapper">
	<div class="inner-left">		
		<article>
			<div class='block'>
				<div class="notify-icon"><i class='fa fa-warning fa-3x'></i></div>
				<div class="content">
					<h2>Ooops! Page Not Found</h2>
					<p>You are seeing this because of a <strong>broken</strong> or <strong>dead</strong> link , a <strong>deleted</strong> or <strong>moved </strong> page.</p>
					<p>It's a shame. We're really sorry.</p>
					<p>You can go back <a href="<?php echo site_url('home');?>"> home</a></p>
					<p class="or">OR</p>

					<p>Enter your search here, you might get fortunate.</p>
					<?php echo form_open('search/term/', array("class" => "searchbox", "method" => "get"))?>
					<?php echo form_input(array('type' => 'text', 'name' => 'search', 'class' =>'search', 'placeholder' => 'Enter your serach here')); ?>
			        <?php echo form_close(); ?>
				</div>
				
			</div>
		</article>
	</div><!-- /inner-left -->
	<!--<?php include 'sidebar.php'; ?>-->
	<p class="clear"></p>
</div>
</div><!-- /container -->


<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/carousel.js'); ?>"></script>