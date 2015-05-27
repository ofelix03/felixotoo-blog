/************************************************************************
** Display the hidden scroll-up button when window height is >= 250    **
*************************************************************************/
	//Up btn js
	$(window).scroll(function(){
		$scroll_btn = $('.scroll-up a');
		if(window.scrollY >= 250)
			$scroll_btn.show();
		else
			$scroll_btn.hide();
	});



/*********************************************************
	Show the borderBottom of 1px when the scroll is vertically triggered
********************************************************/
	$(window).scroll(function(){
		$nav = $('.nav');
		if(window.scrollY >= 1)
			$nav.css('borderBottom', '1px solid #EDF1F2');
		else
			$nav.css('borderBottom', 'none');
	})



/*************************************
 Show the PrevBtn and NextBtn on scroll
 ***************************************/
 var $nextBtn  = $('.nextBtn').find('a');
 $(window).scroll(function(){
 	$this = $(this);
 	if(window.scrollY >= 1)
 	{
 		$('.nextBtn').find('a').fadeIn();
 		$('.prevBtn').find('a').fadeIn();
 	}
 	else
 	{
 		$('.nextBtn').find('a').fadeOut();
 		$('.prevBtn').find('a').fadeOut();
 	}
 })


 /****************************************
  JS code for the  Next/Prev Article Loader 
  ********************************/
  var inner_left_width  = $('.inner-left').innerWidth();
  var loader_container_width = $('.loader-container').width();
  var $prevBtn = $('.prevBtn');
  var $nextBtn = $('.nextBtn');
  var $loader_container = $('.loader-container');
  var $loader_img = $loader_container.find('img');
  var load_img_src  = "<?php echo base_url('asset/img/cms/ajax_loader5.gif');?> alt='loader'";

  $prevBtn.click(function(){
  	$loader_container.css('margin-left', (inner_left_width/2) - (loader_container_width / 2) );
  	$loader_container.show();
  })

  $nextBtn.click(function(){
  	$loader_container.css('margin-left', (inner_left_width/2) - (loader_container_width / 2) );
  	$loader_container.show();
  })



 /**************************************
  JS for PrevBtn and NextBtn
  ****************************************/
  $prevBtn = $('.prevBtn').find('a');
  $nextBtn = $('.nextBtn').find('a');

  $prevTitle = $prevBtn.find('.prevTitle');
  $nextTitle = $nextBtn.find('.nextTitle');
  var inner_left_width = $('.inner-left').width();
  var prevTitle_width = Math.ceil(inner_left_width);
  var nextTitle_width = $nextTitle.width();


  /** Hide nextBtn / prevBtn if view_port <= 800  **/
  if($(window).innerWidth() <= 800){
  	$prevBtn.parent().hide();
  	$nextBtn.parent().hide();
  }
      
//automatically set the posiiton of the nextBtn 
$prevBtn.mouseenter(function(){
	$(this).css({
		maxWidth : prevTitle_width
	});
	$(this).css('border', '2px solid #EDF1F2').find('.prevTitle').slideDown(200);
});

$prevBtn.mouseleave(function(){
	$(this).css('border', '1px solid #fff');
	$prevTitle.hide();
})

$nextBtn.mouseenter(function(){
	$(this).css({
		maxWidth : prevTitle_width
	});

	$(this).css('border', '2px solid #EDF1F2').find('.nextTitle').slideDown(200);
	$(this).parent().css('right', $nextTitle.width() + 37);

});

$nextBtn.mouseleave(function(){
	$(this).css('border', '1px solid #fff');
	$(this).parent().css('right', '1.5%');
	$nextTitle.hide();
})
