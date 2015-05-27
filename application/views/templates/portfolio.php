<div class="inner-wrapper">
<div class="inner-left">
	<!--breadcrumb -->
	<div class="breadcrumb">
		<h2>Portfolio</h2>
		<!-- <p>
			<span><a href="<?php echo site_url('articles');?>">articles</a></span>
			<?php if(isset($breadcrumb)) : ?>
			<span title="Selected Tag">&nbsp;<i class="fa fa-tag" ></i>&nbsp;<?php echo $breadcrumb; ?></span>
		<?php endif; ?>
		</p> -->
	</div>
<!--/breadcrumb --> 
<style type="text/css">
.inner-wrapper .inner-left .archive-meter{
	width: 100%;
	position: relative;
	margin-top: 20px;

}

.inner-wrapper .inner-left .archive-meter hr{
	position : absolute;
	width: 100%;
	border-bottom: none;
	border: none;
	border-bottom: 1px solid red;
}
.inner-wrapper .inner-left .archive-meter span{

}
.inner-wrapper .inner-left .archive-meter ul{
	width : 100%;
	max-height: 70px;
	padding :0px;
	margin: 0px;
	position: absolute;
	left: 0px;
	background: transparent;
}

.inner-wrapper .inner-left .archive-meter ul li{
	width: auto;
	text-align: center;
	border: 1px solid #ccc;
	height: 30%;
	display: inline-block;
	margin-right: 10px;
	margin-top: 10px;
	background: #ccc;
	border: 1px solid red;
}

.inner-wrapper .inner-left .archive-meter ul li:first-child{
	margin-left: 10px;
}

.inner-wrapper .inner-left .archive-meter ul li a{
	text-align: center;
	display: block;
	padding: 10px;
}



</style>
   <div class="archive-meter">
   	<hr>
   	<span class="round-dot"></span>
   	  <ul>
         <li><a href="">2015</a></li>
         <li><a href="">2014</a></li>
         <li><a href="">2013</a></li>
         <li><a href="">2012</a></li>
         <li><a href="">2015</a></li>
         <li><a href="">2014</a></li>
         <li><a href="">2013</a></li>
         <li><a href="">2012</a></li>
   	  </ul>
   </div>



</div><!-- /inner-left -->

<?php include 'sidebar.php'; ?>
	<p class="clear"></p>
</div>
</div><!-- /container -->
	

<script type="text/javascript" src="<?php echo base_url('asset/js/plugins/prism.js'); ?>"></script>
    
<!--<script type="text/javascript">
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'ofel'; // required: replace example with your forum shortname

	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function () {
	    var s = document.createElement('script'); s.async = true;
	    s.type = 'text/javascript';
	    s.src = '//' + disqus_shortname + '.disqus.com/count.js';
	    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	}());
</script>-->
