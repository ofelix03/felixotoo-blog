$checkboxCarouselACtive = $("input[name='carousel-article-active']");
$carousel_data = $('.carousel-data');

$checkboxCarouselACtive.click(function(){
	$this = $(this);
	if($this.val() == 'n'){
		//change val to 'n'
		$this.val('y');
		//show hidden markup
		$carousel_data.slideDown();
	}
	else{
		//change val to 'y'
		$this.val('n');
		//hide displayed markup
		$carousel_data.slideUp();
	}
});



$inputs = $('span').find('input#picker');
	$inputs.each(function(){
		$this = $(this);
		$this.colpick({
			layout:'hex',
			submit:0,
			colorScheme:'light',
			onChange:function(hsb,hex,rgb,el,bySetColor) {
				$(el).css('border-color','#'+hex);
			// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
			if(!bySetColor) $(el).val(hex);
		}
		}).keyup(function(){
			$(this).colpickSetColor(this.value);
		});
	})