/******************************************************************************
*  Showing the searchbox again on Screen Resize and Screen Reload for devices with screen size  between 500 and 750 **
********************************************************************************/
var show_searchbox = function(){
	var $searchbox = $('.searchbox');
	var $searchbox_sm = $('.searchbox-sm');
	var $clear_icon = $('.clear-icon');
	var window_width = $(window).width();
	if(window_width >= 0 && window_width <= 800 )
	{
		var action = $('#site-url').data('site-url') + '/search/term';
		$searchbox_sm.text("");
		$clear_icon.hide();
		var html = "<form method='GET' acton='"+ action +"'>" + $searchbox.html() + "</form>";
		$(html).appendTo($searchbox_sm);
	}
}


$(function(){		
	$(window).resize(function(){
		show_searchbox();
	});

	$(window).load(function(){
		show_searchbox();
	});

});



/******************************************************************************
* Show Input Clear icon on keypress
********************************************************************************/


//input field css
var $input = $('.searchbox').find("input[type='text']");

var $clear_icon = $('.clear-icon');// var $input_sm = $('.searchbox-sm form');
show_clear_icon($input); // show_clear_icon(input_sm);

function show_clear_icon($node){
	$node.keypress(function(){
		//show clear-icon
		$clear_icon.show();
		console.log($node);
	});

	$clear_icon.click(function(){
		$input.val('');
	});

}

