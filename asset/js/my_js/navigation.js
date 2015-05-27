/** JS for Navigation effects **/
var link = $('.nav').find('ul li');
if(window.innerWidth >= 748){
	$(function(){
		link.mouseenter(function(){
			$this = $(this).find('a');
			if($this.parent().attr('id') == '')
			{
				$this.animate({
					paddingBottom: 5
				}, 250);
			}	
		});

		link.mouseleave(function(){
			$this = $(this).find('a');
			// $this.css('paddingBottom', 19)
			$this.animate({
					paddingBottom: 18
				}, 250);
		});
	});
}

/*******************************************************************************
** A click event to display the Menu List in devices with Screen size less than 750 **
***************************************************************************************/
$('.menu-trigger').click(function(){
	$this = $(this);
	if($this.data('active') == 0 || $this.data('active') == undefined)
	{
		$('.nav ul').slideDown(500);
		$this.data('active', 1);
	}
	else if($this.data('active') == 1)
	{
		$('.nav ul').slideUp(500);
		$this.data('active', 0);

	}
	return false;
});
