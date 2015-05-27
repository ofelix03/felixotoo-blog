<div class="footer">
			
</div>


<div class="scroll-up" >
	<a href="#top"><i class="fa fa-arrow-up fa-2x"></i></a>
</div>


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=620407888046217&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<!-- owlCarousel -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.carousel').owlCarousel({
			items: 1,
			autoPlay: 5000,
			itemsTablet : [1920, 1],
			itemsMobile : [500, 1],
			responsive: true,
			pagination: true,
			paginationNumbers :true

		});
	});
</script>
<!-- /owlCarousel -->

<script type="text/javascript">
var link = $('.nav').find('ul li a');

	$(function(){
		link.mouseenter(function(){
			if($(this).parent().attr('id') == '')
			{
				$(this).animate({
					paddingBottom: 5,
				}, 300);
			}	
		});


		link.mouseleave(function(){
			$(this).css('paddingBottom', 12)
		});
	});

</script>


<script type="text/javascript">
//input field css
var $input = $('.searchbox').find("input[type='text']");
// var $input_sm = $('.searchbox-sm form');
var $clear_icon = $('.clear-icon');

show_clear_icon($input);
// show_clear_icon(input_sm);


function show_clear_icon($node){
	$node.keypress(function(){
	//show clear-icon
	$clear_icon.show();
	});

	$clear_icon.click(function(){
		$input.val('');
	});

}



</script>


<!-- DISQUS Comment Counter -->
     <script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	    var disqus_shortname = 'ofelix'; // required: replace example with your forum shortname
	    var disqus_identifier
	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function () {
	        var s = document.createElement('script'); s.async = true;
	        s.type = 'text/javascript';
	        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
	        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
	    }());
    </script>
<!-- end of DISQUS Comment Counter -->


<script type="text/javascript">
// //changing the nav background color
// var $nav = $('.nav');
// var img = "<?php echo base_url('asset/img/my_wallpapers/sativa');?>";

// 	$(window).scroll(function(){
// 		if($(this).scrollTop() > 180)
// 		{
// 			$nav.addClass('nav_callback');
// 		}
// 		else
// 			$nav.removeClass('nav_callback');
// 	});
// </script>


	<!-- <p  id='red'>This is felix</p> -->
	<script type="text/javascript">
		// var text = $('#red').text();
		// text = text.replace("felix", "<span style='background-color: red'>samuel</span>");

		// $strong_node = document.createElement("strong");
		// $text_node = document.createTextNode(text);

		// $strong_node.appendChild($text_node);	
		// $strong_node.appendChild($text_node);
		//  document.getElementById('red').innerHTML =  $text_node.textContent;


		// var keyword = 'Guide'

		// var $articles = $('.inner-left').find('article');
		//  $articles.each(function(){
		// 	var  $this = $(this);
		// 	var $h2 = $this.find('h2 > a');
		// 	var h2_string = $h2.text();
	

		// 	if(h2_string.search(keyword) >= 0)
		// 	{
		// 		samuel = 'samuel';

				
		// 		// element_node = document.createElement("span");
		// 		// element_node.setAttribute('style', 'background-color: red; padding: 10px;');
		// 		string  = '';
		// 		string += "God si googd <span style='color: red;'>" + samuel + "</span>";
		// 		h2_string = h2_string.replace(keyword, string);
		// 		$parsed_html = $.parseHTML(string);
		//  			console.log($parsed_html);
		// 	}
		// });
	</script>


<script type="text/javascript" src="<?php echo base_url('asset/js/smooth-scroll.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/db_archive.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/m_searchbox.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/scroll-detect.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/my_js/menu_trigger.mobile.js'); ?>"></script>
</body>
</html>